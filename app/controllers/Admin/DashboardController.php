<?php
require_once __DIR__ . '/../../models/settings.php';
require_once __DIR__ . '/../../../config/database.php';
require_once BASE_PATH . '/app/models/Voucher.php';

require BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class DashboardController {
    public function index() {
        $settingsModel = new Settings();  
        $webSettings = $settingsModel->getWebSettings();

        // Get dashboard counts
        $database = new Database();
        $conn = $database->connect();
        $counts = [];
        $counts['products'] = $conn->query("SELECT COUNT(*) as c FROM product")->fetch_assoc()['c'];
        $counts['categories'] = $conn->query("SELECT COUNT(*) as c FROM category WHERE parent_id IS NULL OR parent_id = 0")->fetch_assoc()['c'];
        $counts['subcategories'] = $conn->query("SELECT COUNT(*) as c FROM category WHERE parent_id > 0")->fetch_assoc()['c'];
        $counts['orders'] = $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'];
        $counts['blogs'] = 0;

        $lowStockThreshold = 10;
        $counts['low_stock'] = (int) $conn->query("SELECT COUNT(*) as c FROM product WHERE quantity > 0 AND quantity <= {$lowStockThreshold}")->fetch_assoc()['c'];
        $counts['out_of_stock'] = (int) $conn->query("SELECT COUNT(*) as c FROM product WHERE quantity = 0")->fetch_assoc()['c'];
        $counts['healthy_stock'] = max(0, $counts['products'] - $counts['low_stock'] - $counts['out_of_stock']);

        $lowStockProducts = [];
        $resLowStock = $conn->query("SELECT id, article_number, name, quantity FROM product WHERE quantity > 0 AND quantity <= {$lowStockThreshold} ORDER BY quantity ASC, name ASC LIMIT 20");
        while ($row = $resLowStock->fetch_assoc()) {
            $lowStockProducts[] = $row;
        }

        $outOfStockProducts = [];
        $resOutOfStock = $conn->query("SELECT id, article_number, name, quantity FROM product WHERE quantity = 0 ORDER BY name ASC LIMIT 20");
        while ($row = $resOutOfStock->fetch_assoc()) {
            $outOfStockProducts[] = $row;
        }

        // Fetch data for the graph (last 7 days)
        $graphData = [];
        $res = $conn->query("SELECT DATE(created_at) as date, COUNT(*) as count FROM orders GROUP BY DATE(created_at) ORDER BY date DESC LIMIT 7");
        while($row = $res->fetch_assoc()) {
            $graphData[] = $row;
        }
        $graphData = array_reverse($graphData);

        $data = [
            'title' => 'Dashboard',
            'theme' => $_SESSION['theme'] ?? 'theme-default',
            'view'  => 'admin/dashbaord.php',
            'counts' => $counts,
            'graphData' => $graphData,
            'lowStockProducts' => $lowStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'webname' => $webSettings['web_name'] ?? '',
            'webmail' => $webSettings['web_mail'] ?? '',
            'webcontact' => $webSettings['web_contact'] ?? '',
            'facebook' => $webSettings['facebook'] ?? '',
            'instagram' => $webSettings['instagram'] ?? '',
            'pinterest' => $webSettings['pinterest'] ?? '',
            'linkdin' => $webSettings['linkdin'] ?? '',
            'meta_title' => $webSettings['meta_title'] ?? '',
            'meta_description' => $webSettings['meta_description'] ?? '',
            'meta_keywords' => $webSettings['meta_keywords'] ?? ''
        ];

        extract($data);
        require BASE_PATH . '/app/views/admin/layout.php';
    }

    public function salesReport() {
        $database = new Database();
        $conn = $database->connect();

        // Get customers who haven't ordered in the last 7 days
        $sql = "SELECT o.customer_name, o.email, o.phone, MAX(o.created_at) AS last_order_date
                FROM orders o
                GROUP BY o.email
                HAVING MAX(o.created_at) < DATE_SUB(NOW(), INTERVAL 7 DAY)
                ORDER BY last_order_date DESC";

        $res = $conn->query($sql);
        $inactiveCustomers = [];
        while($row = $res->fetch_assoc()) {
            $inactiveCustomers[] = $row;
        }

        $data = [
            'title' => 'Sales Report',
            'theme' => $_SESSION['theme'] ?? 'theme-default',
            'view'  => 'admin/sales_report.php',
            'inactiveCustomers' => $inactiveCustomers
        ];
        extract($data);
        require BASE_PATH . '/app/views/admin/layout.php';
    }

    public function wishlistReport()
    {
        $database = new Database();
        $conn = $database->connect();
        $schemaBootstrap = new SchemaBootstrap($conn, false);

        $wishlistEntries = $schemaBootstrap->getWishlistEntries();

        $topProducts = [];
        foreach ($wishlistEntries as $entry) {
            $productKey = $entry['product_id'];
            if (!isset($topProducts[$productKey])) {
                $topProducts[$productKey] = [
                    'product_id' => (int)$entry['product_id'],
                    'product_name' => $entry['product_name'],
                    'article_number' => $entry['article_number'],
                    'count' => 0,
                ];
            }
            $topProducts[$productKey]['count']++;
        }

        usort($topProducts, function ($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        $totalWishlistItems = count($wishlistEntries);
        $uniqueCustomers = count(array_unique(array_column($wishlistEntries, 'user_id')));

        $data = [
            'title' => 'Wishlist Report',
            'theme' => $_SESSION['theme'] ?? 'theme-default',
            'view' => 'admin/wishlist_report.php',
            'wishlistEntries' => $wishlistEntries,
            'topProducts' => array_slice($topProducts, 0, 10),
            'totalWishlistItems' => $totalWishlistItems,
            'uniqueCustomers' => $uniqueCustomers,
        ];

        extract($data);
        require BASE_PATH . '/app/views/admin/layout.php';
    }

    public function downloadReport() {
        $period = $_GET['period'] ?? '7days';
        $database = new Database();
        $conn = $database->connect();

        $interval = "7 DAY";
        if ($period == '1month') $interval = "1 MONTH";
        if ($period == '6month') $interval = "6 MONTH";

        $sql = "SELECT * FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL $interval) ORDER BY created_at DESC";
        $res = $conn->query($sql);
        $orders = [];
        while($row = $res->fetch_assoc()) {
            $orders[] = $row;
        }

        // Load a clean printable view
        require BASE_PATH . '/app/views/admin/print_report.php';
    }

    public function sendWishlistVoucher()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = trim($_GET['email'] ?? '');
        $name = trim($_GET['name'] ?? 'Valued Customer');
        $product = trim($_GET['product'] ?? 'one of our products');
        $article = trim($_GET['article'] ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Valid customer email is required.";
            header("Location: " . url("") . "wishlist_report");
            exit;
        }

        $database = new Database();
        $conn = $database->connect();
        $voucherModel = new Voucher($conn);

        $discountPercent = rand(10, 15);
        $seed = preg_replace('/[^A-Z]/', '', strtoupper($name));
        $seed = $seed ? substr($seed, 0, 3) : 'STI';
        $voucherCode = $voucherModel->generateUniqueCode($seed);

        if (!$voucherModel->createVoucher($email, $name, $voucherCode, $discountPercent)) {
            $_SESSION['error'] = "Unable to generate the voucher code. Please try again.";
            header("Location: " . url("") . "wishlist_report");
            exit;
        }

        $mail = new PHPMailer(true);
        $mail->Timeout = 15;

        try {
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRYPTION;
            $mail->Port       = MAIL_PORT;

            $mail->setFrom(MAIL_USERNAME, MAIL_FROM_NAME);
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = "Special Stitch Smart offer: {$discountPercent}% off your saved product";

            $mailBody = '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: #fff; border: 1px solid #e5e7eb; border-radius: 16px;">'
                . '<div style="text-align:center; margin-bottom:20px;">'
                . '<h2 style="color:#c19a4e; margin-bottom:0;">We saved your pick!</h2>'
                . '<p style="margin-top:8px; color:#6b7280;">Here is a special offer just for you.</p>'
                . '</div>'
                . '<p style="color:#374151; font-size:16px;">Hi ' . htmlspecialchars($name) . ',</p>'
                . '<p style="color:#374151; font-size:16px;">Thanks for saving <strong>' . htmlspecialchars($product) . '</strong> to your wishlist.</p>'
                . '<p style="color:#374151; font-size:16px;">We want to make it easier for you to bring it home, so here is a limited voucher for <strong>' . $discountPercent . '% off</strong> your next order.</p>'
                . '<div style="background:#f8fafc; border:1px dashed #c19a4e; border-radius:14px; padding:18px; margin:20px 0; text-align:center;">'
                . '<div style="font-size:14px; color:#6b7280; text-transform:uppercase; letter-spacing:1px; margin-bottom:8px;">Your voucher code</div>'
                . '<div style="font-size:28px; font-weight:700; color:#111827;">' . $voucherCode . '</div>'
                . '<div style="margin-top:12px; font-size:16px; color:#1f7a43;">Use this on ' . htmlspecialchars($product) . ($article !== '' ? ' (Article #' . htmlspecialchars($article) . ')' : '') . '.</div>'
                . '</div>'
                . '<p style="color:#374151; font-size:16px;">Click below to shop now and apply your voucher at checkout.</p>'
                . '<div style="text-align:center; margin:24px 0;">'
                . '<a href="' . url('') . 'allproducts" style="display:inline-block;padding:13px 28px;background:#c19a4e;color:#111827;text-decoration:none;border-radius:999px;font-weight:700;">Browse products</a>'
                . '</div>'
                . '<p style="color:#6b7280; font-size:13px;">Voucher valid for one use only. Redeem it on your next order.</p>'
                . '</div>';

            $mail->Body = $mailBody;
            $mail->AltBody = "Hi {$name},\nUse voucher {$voucherCode} for {$discountPercent}% off your next order at Stitch Smart. Product: {$product}.";

            $mail->send();
            $_SESSION['success'] = "Email sent to " . htmlspecialchars($name) . " with a {$discountPercent}% voucher.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Unable to send the voucher email. Mailer Error: " . $mail->ErrorInfo;
        }

        header("Location: " . url("") . "wishlist_report");
        exit;
    }

    public function saveSettings()
    {
        require_once BASE_PATH . '/config/database.php';
        $database = new Database();
        $conn = $database->connect();

        if(isset($_POST['save_contact_info'])) {
            $webname = trim($_POST['webname'] ?? '');
            $webmail = filter_var($_POST['webmail'] ?? '', FILTER_VALIDATE_EMAIL);
            $webcontact = trim($_POST['webcontact'] ?? '');

            if (!$webname || !$webmail || !$webcontact) {
                $_SESSION['error'] = "All contact fields are required and must be valid.";
                header("Location: " . url("") . "admin");
                exit;
            }

            $stmt = $conn->prepare("UPDATE web_settings SET web_name=?, web_mail=?, web_contact=? WHERE id=1");
            $stmt->bind_param("sss", $webname, $webmail, $webcontact);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Contact information updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update contact information.";
            }
            header("Location: " . url("") . "admin");
            exit;
        }
        
        if(isset($_POST['save_social_info'])) {
            $facebook = trim($_POST['facebook'] ?? '');
            $instagram = trim($_POST['instagram'] ?? '');
            $pinterest = trim($_POST['pinterest'] ?? '');
            $linkdin = trim($_POST['linkdin'] ?? '');

            $stmt = $conn->prepare("UPDATE web_settings SET facebook=?, instagram=?, pinterest=?, linkdin=? WHERE id=1");
            $stmt->bind_param("ssss", $facebook, $instagram, $pinterest, $linkdin);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Social media links updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update social media links.";
            }
            header("Location: " . url("") . "homepage");
            exit;
        }

        if(isset($_POST['save_meta_info'])) {
            $meta_title = trim($_POST['meta_title'] ?? '');
            $meta_description = trim($_POST['meta_description'] ?? '');
            $meta_keywords = trim($_POST['meta_keywords'] ?? '');

            if (!$meta_title) {
                $_SESSION['error'] = "Meta Title is required for SEO.";
                header("Location: " . url("") . "homepage");
                exit;
            }

            $stmt = $conn->prepare("UPDATE web_settings SET meta_title=?, meta_description=?, meta_keywords=? WHERE id=1");
            $stmt->bind_param("sss", $meta_title, $meta_description, $meta_keywords);
            if ($stmt->execute()) {
                $_SESSION['success'] = "SEO settings updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update SEO settings.";
            }
            header("Location: " . url("") . "homepage");
            exit;
        }
    }

    public function sendRetentionEmail() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = trim($_GET['email'] ?? '');
        $name = trim($_GET['name'] ?? 'Valued Customer');

        if (empty($email)) {
            $_SESSION['error'] = "Customer email is required.";
            header("Location: " . url("") . "sales_report");
            exit;
        }

        $database = new Database();
        $conn = $database->connect();
        $voucherModel = new Voucher($conn);

        $discountPercent = rand(10, 15);

        $seed = preg_replace('/[^A-Z]/', '', strtoupper($name));
        $seed = $seed ? substr($seed, 0, 3) : 'STI';
        $voucherCode = $voucherModel->generateUniqueCode($seed);

        if (!$voucherModel->createVoucher($email, $name, $voucherCode, $discountPercent)) {
            $_SESSION['error'] = "Unable to generate the voucher code. Please try again.";
            header("Location: " . url("") . "sales_report");
            exit;
        }

        $mail = new PHPMailer(true);
        $mail->Timeout = 15;

        try {
            // SMTP Settings
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRYPTION;
            $mail->Port       = MAIL_PORT;

            // From / To
            $mail->setFrom(MAIL_USERNAME, MAIL_FROM_NAME);
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'We miss you at Stitch Smart! Here is your special voucher';

            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #ffffff; color: #111827;'>
                    <div style='text-align: center; margin-bottom: 20px;'>
                        <h2 style='color: #c19a4e; font-size: 24px; margin-top: 0;'>Hello " . htmlspecialchars($name) . " 👋</h2>
                    </div>
                    <p style='font-size: 16px; line-height: 1.6; color: #374151;'>We noticed you haven't shopped with us recently, and we miss you at Stitch Smart.</p>
                    <p style='font-size: 16px; line-height: 1.6; color: #374151;'>As a thank you for being a valued customer, please use the voucher below on your next order.</p>
                    <div style='background: #f8fafc; border: 1px dashed #c19a4e; border-radius: 14px; padding: 22px; margin: 24px 0; text-align: center;'>
                        <p style='margin:0; font-size:14px; letter-spacing: .14em; text-transform: uppercase; color:#6b7280;'>Your one-time voucher code</p>
                        <h3 style='margin: 12px 0 0; font-size: 28px; color:#111827;'>{$voucherCode}</h3>
                        <p style='margin: 8px 0 0; font-size: 18px; color:#1a7f37;'><strong>{$discountPercent}% off</strong> at checkout</p>
                    </div>
                    <p style='font-size: 16px; line-height: 1.6; color: #374151;'>Enter the voucher code at checkout for a discount on your total. This code is active for one purchase and is valid only for this email address.</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='" . url("") . "checkout' style='display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #c19a4e 0%, #8b5a2b 100%); color: #ffffff; text-decoration: none; font-weight: 700; border-radius: 50px; text-transform: uppercase; box-shadow: 0 4px 15px rgba(193, 154, 78, 0.3); font-size: 14px;'>Redeem at Checkout</a>
                    </div>
                    <hr style='border: 0; border-top: 1px solid #e5e7eb; margin: 25px 0;'>
                    <p style='font-size: 13px; text-align: center; color: #6b7280; margin-bottom: 0;'>Thank you for being a cherished part of Stitch Smart.</p>
                </div>
            ";

            $mail->AltBody = "Hello {$name}, we miss you at Stitch Smart! Use voucher {$voucherCode} for {$discountPercent}% off on your next order at " . url("") . "checkout";

            $mail->send();
            $_SESSION['success'] = "Retention email sent successfully to " . htmlspecialchars($name) . " with voucher code {$voucherCode}.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed to send email. Mailer Error: " . $mail->ErrorInfo;
        }

        header("Location: " . url("") . "sales_report");
        exit;
    }
}
