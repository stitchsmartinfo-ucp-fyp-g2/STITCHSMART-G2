<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/settings.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';
require_once BASE_PATH . '/app/models/Voucher.php';

require BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class OrderController {

    private $conn;
    private $productModel;
    private $categoryModel;
    private $voucherModel;

    public function __construct(){
        $database = new Database();
        $db = $database->connect();
        $this->conn = $db;
        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
        $this->voucherModel = new Voucher($db);
    }

    public function checkout(){

   $settingsModel = new Settings();  
        $webSettings = $settingsModel->getWebSettings();

        $webname = $webSettings['web_name'] ?? '';
        $webmail = $webSettings['web_mail'] ?? '';
        $webcontact = $webSettings['web_contact'] ?? '';
        $facebook = $webSettings['facebook'] ?? '';
        $instagram = $webSettings['instagram'] ?? '';
        $pinterest = $webSettings['pinterest'] ?? '';
        $linkdin = $webSettings['linkdin'] ?? '';
        $meta_title = $webSettings['meta_title'] ?? '';
        $meta_description = $webSettings['meta_description'] ?? '';
        $global_theme = $webSettings['theme'] ?? 'theme-luxury';
        $meta_keywords = $webSettings['meta_keywords'] ?? '';


  // fetch data for homepage
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getCategoriesTree();
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $this->refreshCartPrices();

    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        $_SESSION['checkout_error'] = "Your cart is empty. Please add products before checkout.";
        header("Location: " . url("") . "cart");
        exit;
    }

    // calculate total
    $total = 0;
    foreach($cart as $item){
        $total += $item['price'] * $item['qty'];
    }

    require BASE_PATH . '/app/views/User/checkout.php';
}

 public function placeOrder()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $this->refreshCartPrices();

    $submittedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $_SESSION['checkout_error'] = "Invalid security token. Please refresh the page and try again.";
        header("Location: " . url("") . "checkout");
        exit;
    }

    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        $_SESSION['checkout_error'] = "Your cart is empty. Please add products before checkout.";
        header("Location: " . url("") . "cart");
        exit;
    }

    $name = trim(strip_tags((string)($_POST['name'] ?? '')));
    $email = trim((string)($_POST['email'] ?? ''));
    $phone = trim(strip_tags((string)($_POST['phone'] ?? '')));
    $address = trim(strip_tags((string)($_POST['address'] ?? '')));
    $payment_method = in_array($_POST['payment_method'] ?? 'cod', ['cod', 'bank', 'card', 'paypal'], true) ? $_POST['payment_method'] : 'cod';

    // Form Validation
    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        $_SESSION['checkout_error'] = "All billing details are required.";
        header("Location: " . url("") . "checkout");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['checkout_error'] = "Please provide a valid email address.";
        header("Location: " . url("") . "checkout");
        exit;
    }

    // total
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }


    $voucher_code = strtoupper(trim($_POST['voucher_code'] ?? ''));
    $discount_amount = 0;
    $voucherRules = [
        'STITCH10' => 10,
        'LUCKY15' => 15,
        'STITCH20' => 20,
        'WELCOME10' => 10,
    ];
    $voucherData = null;

    if (!empty($voucher_code)) {
        $voucherData = $this->voucherModel->getVoucherByCode($voucher_code);

        if ($voucherData) {
            if ((int)$voucherData['redeemed'] === 1) {
                $_SESSION['checkout_error'] = "Voucher code '{$voucher_code}' has already been redeemed.";
                header("Location: " . url("") . "checkout");
                exit;
            }

            if (strtolower($voucherData['email']) !== strtolower($email)) {
                $_SESSION['checkout_error'] = "Voucher code '{$voucher_code}' is not valid for this email address.";
                header("Location: " . url("") . "checkout");
                exit;
            }

            $discount_amount = round($total * ((int)$voucherData['discount_percent'] / 100), 2);
        } else {
            if (!array_key_exists($voucher_code, $voucherRules)) {
                $_SESSION['checkout_error'] = "Voucher code '{$voucher_code}' is not valid. Please try a valid promotional code or a one-time email voucher.";
                header("Location: " . url("") . "checkout");
                exit;
            }

            $discount_amount = round($total * ($voucherRules[$voucher_code] / 100), 2);
        }

        $total = max(0, round($total - $discount_amount, 2));
    }

    $user_id = $_SESSION['customer_id'] ?? null;

    try {
        $this->conn->begin_transaction();

        // Ensure payment_method column exists
        $columnExists = $this->conn->query("SHOW COLUMNS FROM orders LIKE 'payment_method'");
        if ($columnExists && $columnExists->num_rows === 0) {
            $this->conn->query("ALTER TABLE orders ADD COLUMN payment_method VARCHAR(50) DEFAULT 'cod' AFTER total");
        }

        // insert order
        $stmt = $this->conn->prepare(
            "INSERT INTO orders (user_id, customer_name, email, phone, address, total, payment_method, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $status = ($payment_method === 'paypal') ? 'Paid (PayPal)' : 'Pending';
        $paypal_tx = trim((string)($_POST['paypal_transaction_id'] ?? ''));
        if ($payment_method === 'paypal' && !empty($paypal_tx)) {
            $status .= " [TX: " . strip_tags($paypal_tx) . "]";
        }
        if (!empty($voucher_code) && $discount_amount > 0) {
            $status .= " - Voucher: " . $voucher_code;
        }

        $stmt->bind_param("issssdss", $user_id, $name, $email, $phone, $address, $total, $payment_method, $status);
        if (!$stmt->execute()) {
            throw new RuntimeException('Unable to create order.');
        }

        $order_id = (int)$stmt->insert_id;

        if (!empty($voucher_code) && isset($voucherData) && $voucherData) {
            $this->voucherModel->markRedeemed((int)$voucherData['id'], $order_id);
        }

        // insert items and reduce stock
        $productModel = new Product($this->conn);
        $pendingAlerts = []; // collect alerts, send AFTER commit

        foreach ($cart as $item) {
            $itemId = (int)$item['id'];
            $itemQty = (int)$item['qty'];
            $itemPrice = (float)$item['price'];

            $product = $productModel->getProductById($itemId);
            if (!$product) {
                throw new RuntimeException('Product not found for order.');
            }

            $oldQty = (int)$product['quantity'];
            $newQty = $oldQty - $itemQty;
            if ($newQty < 0) {
                throw new RuntimeException('Insufficient stock for requested quantity.');
            }

            $itemStmt = $this->conn->prepare(
                "INSERT INTO order_items (order_id, product_id, price, quantity)
                 VALUES (?, ?, ?, ?)"
            );
            $itemStmt->bind_param("iidi", $order_id, $itemId, $itemPrice, $itemQty);
            if (!$itemStmt->execute()) {
                throw new RuntimeException('Unable to save order item.');
            }

            $stockUpdated = $productModel->reduceStock($itemId, $itemQty);
            if (!$stockUpdated) {
                throw new RuntimeException('Stock update failed.');
            }

            // Queue alert emails — will be sent AFTER transaction commits
            if ($newQty <= 0) {
                $pendingAlerts[] = ['type' => 'out_of_stock', 'product' => $product, 'qty' => 0];
            } elseif ($newQty <= 10) {
                $pendingAlerts[] = ['type' => 'low_stock', 'product' => $product, 'qty' => $newQty];
            }
        }

        $this->conn->commit();

        // ✅ Send stock alert emails AFTER commit so transaction doesn't block SMTP
        foreach ($pendingAlerts as $alert) {
            if ($alert['type'] === 'out_of_stock') {
                $this->sendOutOfStockMail($alert['product']);
            } else {
                $this->sendLowStockMail($alert['product'], $alert['qty']);
            }
        }

        // ✅ SEND EMAIL (IMPORTANT: PASS CART)
        if (!empty($email)) {
            $this->sendOrderEmail($email, $name, $order_id, $total, $cart, $discount_amount, $voucher_code);
        }

        // clear cart
        unset($_SESSION['cart']);

        if (isset($_SESSION['customer_id'])) {
            require_once BASE_PATH . '/app/models/SchemaBootstrap.php';
            $schemaBootstrap = new SchemaBootstrap($this->conn, false);
            $schemaBootstrap->syncCartToDb((int)$_SESSION['customer_id'], []);
        }

        header("Location: " . url("") . "order_success?id=" . $order_id);
        exit;
    } catch (Exception $e) {
        if ($this->conn->errno) {
            $this->conn->rollback();
        }
        error_log('Order placement failed: ' . $e->getMessage());
        $_SESSION['checkout_error'] = "We could not place your order right now. Please try again.";
        header("Location: " . url("") . "checkout");
        exit;
    }
}
private function sendOrderEmail($toEmail, $name, $order_id, $total, $cart, $discountAmount = 0, $voucher_code = '')
{
    $mail = new PHPMailer(true);
        $mail->Timeout = 15;

    try {

        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;

        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;

        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_USERNAME, 'Stitch Smart');
        $mail->addAddress($toEmail, $name);

        $mail->isHTML(true);
        $mail->Subject = "Order Confirmation #$order_id";

        // -----------------------------
        // BUILD ITEMS TABLE
        // -----------------------------
        $itemsHtml = "";

        foreach ($cart as $item) {

            $subtotal = $item['price'] * $item['qty'];

            $itemsHtml .= "
                <tr>
                    <td style='padding:8px;border:1px solid #ddd;'>
                        {$item['name']}
                    </td>
                    <td style='padding:8px;border:1px solid #ddd;text-align:center;'>
                        {$item['qty']}
                    </td>
                    <td style='padding:8px;border:1px solid #ddd;text-align:center;'>
                        Rs {$item['price']}
                    </td>
                    <td style='padding:8px;border:1px solid #ddd;text-align:center;'>
                        Rs {$subtotal}
                    </td>
                </tr>
            ";
        }

        // -----------------------------
        // EMAIL BODY
        // -----------------------------
        $voucherHtml = '';
        if (!empty($voucher_code) && $discountAmount > 0) {
            $voucherHtml = "<p style='color:#1a7f37;'><strong>Voucher {$voucher_code} saved Rs " . number_format($discountAmount, 2) . "</strong></p>";
        }

        $mail->Body = "

        <div style='font-family:Arial;padding:20px'>

            <h2>Hello $name 👋</h2>

            <p>Your order has been placed successfully.</p>

            <p><b>Order ID:</b> #$order_id</p>

            <br>

            <table width='100%' style='border-collapse:collapse;'>

                <tr style='background:#f2f2f2;'>
                    <th style='padding:10px;border:1px solid #ddd;'>Product</th>
                    <th style='padding:10px;border:1px solid #ddd;'>Qty</th>
                    <th style='padding:10px;border:1px solid #ddd;'>Price</th>
                    <th style='padding:10px;border:1px solid #ddd;'>Subtotal</th>
                </tr>

                $itemsHtml

            </table>

            <br>

            <h3>Total: Rs $total</h3>

            $voucherHtml

        </div>

        ";

        // fallback text
        $mail->AltBody = "Order #$order_id placed. Total: Rs $total" .
                        (!empty($voucher_code) && $discountAmount > 0 ? " (Voucher $voucher_code saved Rs " . number_format($discountAmount, 2) . ")" : "");

        $mail->send();

    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        echo $mail->ErrorInfo;
    }
}
private function sendOutOfStockMail($product)
{
    $mail = new PHPMailer(true);
        $mail->Timeout = 15;

    try {

        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_USERNAME, 'Stock Alert');

        // admin email
        $mail->addAddress(MAIL_USERNAME);

        $mail->isHTML(true);

        $mail->Subject = 'Restock Needed: ' . $product['name'] . ' (Out of Stock)';

        $mail->Body = "
        <div style='font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: #fdfcf9; padding: 40px 0; color: #1a1a1a;'>
            <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid rgba(193, 154, 78, 0.2);'>
                
                <!-- Header -->
                <div style='background: linear-gradient(135deg, #1a0f0a 0%, #3d241c 100%); padding: 30px 40px; text-align: center; border-bottom: 3px solid #c19a4e;'>
                    <h1 style='margin: 0; color: #ffffff; font-size: 24px; letter-spacing: 2px; text-transform: uppercase;'>
                        Stitch<span style='color: #c19a4e;'>Smart</span>
                    </h1>
                </div>

                <!-- Body -->
                <div style='padding: 40px;'>
                    <div style='text-align: center; margin-bottom: 30px;'>
                        <span style='display: inline-block; background-color: rgba(220, 53, 69, 0.1); color: #dc3545; padding: 8px 16px; border-radius: 50px; font-weight: bold; font-size: 14px; letter-spacing: 1px; border: 1px solid rgba(220, 53, 69, 0.3);'>
                            CRITICAL INVENTORY ALERT
                        </span>
                    </div>

                    <h2 style='color: #1a1a1a; margin-top: 0; font-size: 20px;'>Hello Admin,</h2>
                    <p style='font-size: 16px; line-height: 1.6; color: #5c4335;'>
                        The following product has just reached <strong>Out of Stock</strong> status following a recent customer order. Immediate restock is required.
                    </p>

                    <div style='background-color: #fcf8f2; border: 1px solid rgba(193, 154, 78, 0.3); border-radius: 8px; padding: 25px; margin: 30px 0;'>
                        <table style='width: 100%; border-collapse: collapse;'>
                            <tr>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600; width: 40%;'>Product Name</td>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>{$product['name']}</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600;'>Article Number</td>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>{$product['article_number']}</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600;'>Product ID</td>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>{$product['id']}</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600;'>Price</td>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>Rs. " . number_format($product['price']) . "</td>
                            </tr>
                            <tr>
                                <td style='padding: 15px 0 5px 0; color: #7a6253; font-weight: 600;'>Remaining Stock</td>
                                <td style='padding: 15px 0 5px 0; color: #dc3545; font-weight: bold; text-align: right; font-size: 18px;'>0 Units</td>
                            </tr>
                        </table>
                    </div>

                    <p style='font-size: 15px; line-height: 1.6; color: #5c4335;'>
                        Please log in to the <a href='#' style='color: #c19a4e; text-decoration: none; font-weight: bold;'>Admin Dashboard</a> and update your inventory as soon as possible to avoid losing potential sales.
                    </p>
                </div>

                <!-- Footer -->
                <div style='background-color: #1a0f0a; padding: 25px 40px; text-align: center;'>
                    <p style='margin: 0; color: rgba(255,255,255,0.5); font-size: 12px; letter-spacing: 1px;'>
                        STITCH SMART AUTOMATIC INVENTORY SYSTEM
                    </p>
                </div>

            </div>
        </div>
        ";

        $mail->send();

    } catch (Exception $e) {

        error_log('Stock Mail Error: ' . $mail->ErrorInfo);
    }
}
private function sendLowStockMail($product, $remainingQty)
{
    $mail = new PHPMailer(true);
        $mail->Timeout = 15;

    try {

        $mail->isSMTP();
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_USERNAME, 'Stock Alert');

        // admin email
        $mail->addAddress(MAIL_USERNAME);

        $mail->isHTML(true);

        $mail->Subject = 'Low Stock Alert: ' . $product['name'];

        $mail->Body = "
        <div style='font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: #fdfcf9; padding: 40px 0; color: #1a1a1a;'>
            <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid rgba(193, 154, 78, 0.2);'>
                
                <!-- Header -->
                <div style='background: linear-gradient(135deg, #1a0f0a 0%, #3d241c 100%); padding: 30px 40px; text-align: center; border-bottom: 3px solid #c19a4e;'>
                    <h1 style='margin: 0; color: #ffffff; font-size: 24px; letter-spacing: 2px; text-transform: uppercase;'>
                        Stitch<span style='color: #c19a4e;'>Smart</span>
                    </h1>
                </div>

                <!-- Body -->
                <div style='padding: 40px;'>
                    <div style='text-align: center; margin-bottom: 30px;'>
                        <span style='display: inline-block; background-color: rgba(205, 154, 72, 0.15); color: #c19a4e; padding: 8px 16px; border-radius: 50px; font-weight: bold; font-size: 14px; letter-spacing: 1px; border: 1px solid rgba(193, 154, 78, 0.4);'>
                            LOW STOCK WARNING
                        </span>
                    </div>

                    <h2 style='color: #1a1a1a; margin-top: 0; font-size: 20px;'>Hello Admin,</h2>
                    <p style='font-size: 16px; line-height: 1.6; color: #5c4335;'>
                        The following product has dropped to <strong>Low Stock</strong> (&le; 10 units) following a recent customer order.
                    </p>

                    <div style='background-color: #fcf8f2; border: 1px solid rgba(193, 154, 78, 0.3); border-radius: 8px; padding: 25px; margin: 30px 0;'>
                        <table style='width: 100%; border-collapse: collapse;'>
                            <tr>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600; width: 40%;'>Product Name</td>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>{$product['name']}</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600;'>Article Number</td>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>{$product['article_number']}</td>
                            </tr>
                            <tr>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600;'>Product ID</td>
                                <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>{$product['id']}</td>
                            </tr>
                            <tr>
                                <td style='padding: 15px 0 5px 0; color: #7a6253; font-weight: 600;'>Remaining Stock</td>
                                <td style='padding: 15px 0 5px 0; color: #c19a4e; font-weight: bold; text-align: right; font-size: 18px;'>{$remainingQty} Units</td>
                            </tr>
                        </table>
                    </div>

                    <p style='font-size: 15px; line-height: 1.6; color: #5c4335;'>
                        Please review your inventory on the <a href='#' style='color: #c19a4e; text-decoration: none; font-weight: bold;'>Admin Dashboard</a> and consider restocking this item soon.
                    </p>
                </div>

                <!-- Footer -->
                <div style='background-color: #1a0f0a; padding: 25px 40px; text-align: center;'>
                    <p style='margin: 0; color: rgba(255,255,255,0.5); font-size: 12px; letter-spacing: 1px;'>
                        STITCH SMART AUTOMATIC INVENTORY SYSTEM
                    </p>
                </div>

            </div>
        </div>
        ";

        $mail->send();

    } catch (Exception $e) {

        error_log('Low Stock Mail Error: ' . $mail->ErrorInfo);
    }
}
public function success(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $settingsModel = new Settings();
    $webSettings = $settingsModel->getWebSettings();
    $global_theme = $webSettings['theme'] ?? 'theme-luxury';
    $webname = $webSettings['web_name'] ?? 'StitchSmart';
    $webmail = $webSettings['web_mail'] ?? 'info@stitchsmart.com';
    $webcontact = $webSettings['web_contact'] ?? 'StitchSmart';
    $facebook = $webSettings['facebook'] ?? '';
    $instagram = $webSettings['instagram'] ?? '';
    $pinterest = $webSettings['pinterest'] ?? '';
    $linkdin = $webSettings['linkdin'] ?? '';
    $meta_description = $webSettings['meta_description'] ?? 'StitchSmart - Tailoring quality products with fast shipping.';

    $cartItems = $_SESSION['cart'] ?? [];

    $productModel = new Product($this->conn);

    foreach ($cartItems as $item) {
        $productModel->reduceStock($item['id'], $item['qty']);
    }

    $order_id = $_GET['id'] ?? 0;

    require BASE_PATH . '/app/views/User/order-success.php';
}
public function customerOrders(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $settingsModel = new Settings();
    $webSettings = $settingsModel->getWebSettings();
    $global_theme = $webSettings['theme'] ?? 'theme-luxury';
    $webname = $webSettings['web_name'] ?? 'StitchSmart';
    $webmail = $webSettings['web_mail'] ?? 'info@stitchsmart.com';
    $webcontact = $webSettings['web_contact'] ?? 'StitchSmart';
    $facebook = $webSettings['facebook'] ?? '';
    $instagram = $webSettings['instagram'] ?? '';
    $pinterest = $webSettings['pinterest'] ?? '';
    $linkdin = $webSettings['linkdin'] ?? '';
    $meta_description = $webSettings['meta_description'] ?? 'StitchSmart - Tailoring quality products with fast shipping.';

    if (empty($_SESSION['customer_id'])) {
        header("Location: " . url("") . "customer_login");
        exit;
    }

    $userId = (int)$_SESSION['customer_id'];
    $stmt = $this->conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $row['product_image_url'] = null;
        $row['product_name'] = null;
        $row['item_count'] = 0;
        $orders[] = $row;
    }

    if (!empty($orders)) {
        $orderIds = array_column($orders, 'id');
        $idList = implode(',', array_map('intval', $orderIds));

        $sql = "SELECT oi.order_id, p.image_url, p.name FROM order_items oi LEFT JOIN product p ON p.id = oi.product_id WHERE oi.order_id IN ($idList) ORDER BY oi.order_id, oi.id ASC";
        $itemStmt = $this->conn->prepare($sql);

        if ($itemStmt) {
            $itemStmt->execute();
            $itemResult = $itemStmt->get_result();
            $orderImages = [];
            $orderNames = [];
            $orderCounts = [];

            while ($itemRow = $itemResult->fetch_assoc()) {
                $orderId = (int)$itemRow['order_id'];
                $orderCounts[$orderId] = ($orderCounts[$orderId] ?? 0) + 1;

                if (empty($orderImages[$orderId]) && !empty($itemRow['image_url'])) {
                    $orderImages[$orderId] = $itemRow['image_url'];
                    $orderNames[$orderId] = $itemRow['name'];
                }
            }

            foreach ($orders as &$order) {
                $orderId = (int)$order['id'];
                $order['product_image_url'] = $orderImages[$orderId] ?? null;
                $order['product_name'] = $orderNames[$orderId] ?? null;
                $order['item_count'] = $orderCounts[$orderId] ?? 0;
            }
            unset($order);
        }
    }

    // fetch recent chat snippet and recent searches for logged-in user
    $lastMessage = null;
    $recentSearches = [];
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $userId = $_SESSION['customer_id'] ?? null;
    if ($userId) {
        // last chat message
        $stmt = $this->conn->prepare("SELECT role, message, created_at FROM user_chats WHERE user_id = ? ORDER BY id DESC LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $r = $stmt->get_result()->fetch_assoc();
            if ($r) $lastMessage = $r;
        }

        // recent searches
        $stmt = $this->conn->prepare("SELECT query, created_at FROM user_searches WHERE user_id = ? ORDER BY id DESC LIMIT 5");
        if ($stmt) {
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($sr = $res->fetch_assoc()) $recentSearches[] = $sr;
        }
    }

    // pass variables to view
    require BASE_PATH . '/app/views/User/customer_orders.php';
}

public function customerOrderDetail(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['customer_id'])) {
        header("Location: " . url("") . "customer_login");
        exit;
    }

    $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $userId = (int)$_SESSION['customer_id'];

    $settingsModel = new Settings();
    $webSettings = $settingsModel->getWebSettings();
    $global_theme = $webSettings['theme'] ?? 'theme-luxury';
    $webname = $webSettings['web_name'] ?? 'StitchSmart';
    $webmail = $webSettings['web_mail'] ?? 'info@stitchsmart.com';
    $webcontact = $webSettings['web_contact'] ?? 'StitchSmart';
    $facebook = $webSettings['facebook'] ?? '';
    $instagram = $webSettings['instagram'] ?? '';
    $pinterest = $webSettings['pinterest'] ?? '';
    $linkdin = $webSettings['linkdin'] ?? '';
    $meta_description = $webSettings['meta_description'] ?? 'StitchSmart - Tailoring quality products with fast shipping.';

    $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ? LIMIT 1");
    $stmt->bind_param("ii", $orderId, $userId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if (!$order) {
        header("Location: " . url("") . "customer_orders");
        exit;
    }

    $stmt = $this->conn->prepare(
        "SELECT oi.*, p.name AS product_name, p.image_url AS product_image
         FROM order_items oi
         LEFT JOIN product p ON p.id = oi.product_id
         WHERE oi.order_id = ?"
    );
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Fetch existing return requests for this order
    $this->ensureReturnTableExists();
    $stmt = $this->conn->prepare("SELECT order_item_id, status FROM return_requests WHERE order_id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $returnResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $itemReturns = [];
    foreach($returnResult as $r) {
        $itemReturns[$r['order_item_id']] = $r['status'];
    }

    require BASE_PATH . '/app/views/User/customer_order_detail.php';
}

public function customerOrderReview(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['customer_id'])) {
        header("Location: " . url("") . "customer_login");
        exit;
    }

    $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $userId = (int)$_SESSION['customer_id'];

    $settingsModel = new Settings();
    $webSettings = $settingsModel->getWebSettings();
    $global_theme = $webSettings['theme'] ?? 'theme-luxury';
    $webname = $webSettings['web_name'] ?? 'StitchSmart';
    $webmail = $webSettings['web_mail'] ?? 'info@stitchsmart.com';
    $webcontact = $webSettings['web_contact'] ?? 'StitchSmart';
    $facebook = $webSettings['facebook'] ?? '';
    $instagram = $webSettings['instagram'] ?? '';
    $pinterest = $webSettings['pinterest'] ?? '';
    $linkdin = $webSettings['linkdin'] ?? '';
    $meta_description = $webSettings['meta_description'] ?? 'StitchSmart - Tailoring quality products with fast shipping.';

    $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ? LIMIT 1");
    $stmt->bind_param("ii", $orderId, $userId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if (!$order || strtolower(trim($order['status'])) !== 'delivered') {
        header("Location: " . url("") . "customer_orders");
        exit;
    }

    $stmt = $this->conn->prepare(
        "SELECT oi.*, p.name AS product_name, p.image_url AS product_image
         FROM order_items oi
         LEFT JOIN product p ON p.id = oi.product_id
         WHERE oi.order_id = ?"
    );
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    require BASE_PATH . '/app/views/User/customer_order_review.php';
}

public function manageOrders(){

    $result = $this->conn->query("SELECT * FROM orders ORDER BY id DESC");

    $orders = [];
    while($row = $result->fetch_assoc()){
        $orders[] = $row;
    }

    $data = [
        'title' => 'Manage Orders',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view'  => 'admin/manage_orders.php',
        'orders' => $orders
    ];

    extract($data);

    require BASE_PATH.'/app/views/admin/layout.php';
}
public function deleteOrder(){

    if(isset($_GET['id'])){

        $id = (int)$_GET['id'];

        // delete order items first (important FK safety)
        $stmt = $this->conn->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // delete order
        $stmt = $this->conn->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        header("Location: " . url("") . "manage_orders");
        exit;
    }
}

public function markDelivered(){
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $stmt = $this->conn->prepare("UPDATE orders SET status = 'Delivered' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Order #$id marked as Delivered!";
        } else {
            $_SESSION['error'] = "Failed to update order status.";
        }
        header("Location: " . url("") . "manage_orders");
        exit;
    }
}

public function markProcessing(){
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $stmt = $this->conn->prepare("UPDATE orders SET status = 'Processing' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Order #$id marked as Processing!";
        } else {
            $_SESSION['error'] = "Failed to update order status.";
        }
        header("Location: " . url("") . "manage_orders");
        exit;
    }
}

public function markInTransit(){
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $stmt = $this->conn->prepare("UPDATE orders SET status = 'In Transit' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Order #$id marked as In Transit!";
        } else {
            $_SESSION['error'] = "Failed to update order status.";
        }
        header("Location: " . url("") . "manage_orders");
        exit;
    }
}

public function markOutForDelivery(){
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $stmt = $this->conn->prepare("UPDATE orders SET status = 'Out for Delivery' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Order #$id marked as Out for Delivery!";
        } else {
            $_SESSION['error'] = "Failed to update order status.";
        }
        header("Location: " . url("") . "manage_orders");
        exit;
    }
}

public function markCancelled(){
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        $stmt = $this->conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Order #$id has been Cancelled.";
        } else {
            $_SESSION['error'] = "Failed to update order status.";
        }
        header("Location: " . url("") . "manage_orders");
        exit;
    }
}

public function saveTracking()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . url("") . "manage_orders");
        exit;
    }

    $orderId = isset($_POST['order_id']) ? (int) $_POST['order_id'] : 0;
    $trackingId = trim($_POST['tracking_id'] ?? '');

    if ($orderId <= 0 || $trackingId === '') {
        $_SESSION['error'] = 'Please provide a valid tracking ID.';
        header("Location: " . url("") . "manage_orders");
        exit;
    }

    $columnExists = $this->conn->query("SHOW COLUMNS FROM orders LIKE 'tracking_id'");
    if ($columnExists && $columnExists->num_rows === 0) {
        $this->conn->query("ALTER TABLE orders ADD COLUMN tracking_id VARCHAR(100) NULL AFTER status");
    }

    $stmt = $this->conn->prepare(
        "UPDATE orders
         SET tracking_id = ?,
             status = IF(status = 'Delivered', status, 'Dispatched')
         WHERE id = ?"
    );

    if ($stmt === false) {
        error_log("OrderController::saveTracking prepare failed: " . $this->conn->error);
        $_SESSION['error'] = 'Database error while saving tracking. Please check your orders table schema.';
        header("Location: " . url("") . "manage_orders");
        exit;
    }

    $stmt->bind_param("si", $trackingId, $orderId);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Tracking ID saved for order #$orderId.";
    } else {
        error_log("OrderController::saveTracking execute failed: " . $stmt->error);
        $_SESSION['error'] = "Unable to save tracking ID.";
    }

    header("Location: " . url("") . "manage_orders");
    exit;
}

private function ensureReturnTableExists()
{
    $result = $this->conn->query("SHOW TABLES LIKE 'return_requests'");
    if ($result && $result->num_rows === 0) {
        $this->conn->query(
            "CREATE TABLE return_requests (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_id INT NOT NULL,
                order_item_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                status VARCHAR(50) NOT NULL,
                damage_note TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                FOREIGN KEY (order_item_id) REFERENCES order_items(id) ON DELETE CASCADE,
                FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );
    }
}

public function returnForm()
{
    $orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
    if ($orderId <= 0) {
        header("Location: " . url("") . "manage_orders");
        exit;
    }

    $this->ensureReturnTableExists();

    $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if (!$order) {
        $_SESSION['error'] = "Order not found.";
        header("Location: " . url("") . "manage_orders");
        exit;
    }

    $stmt = $this->conn->prepare(
        "SELECT oi.*, p.name AS product_name, p.quantity AS stock_quantity
         FROM order_items oi
         LEFT JOIN product p ON p.id = oi.product_id
         WHERE oi.order_id = ?"
    );
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $result = $this->conn->prepare(
        "SELECT rr.*, oi.quantity AS ordered_quantity, p.name AS product_name
         FROM return_requests rr
         LEFT JOIN order_items oi ON rr.order_item_id = oi.id
         LEFT JOIN product p ON p.id = rr.product_id
         WHERE rr.order_id = ?
         ORDER BY rr.created_at DESC"
    );
    $result->bind_param("i", $orderId);
    $result->execute();
    $returns = $result->get_result()->fetch_all(MYSQLI_ASSOC);

    $data = [
        'title' => 'Process Return',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view'  => 'admin/order_return_form.php',
        'order' => $order,
        'items' => $items,
        'returns' => $returns
    ];
    extract($data);
    require BASE_PATH.'/app/views/admin/layout.php';
}

public function processReturn()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . url("") . "manage_orders");
        exit;
    }

    $this->ensureReturnTableExists();

    $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
    $itemIds = $_POST['return_item_id'] ?? [];
    $quantities = $_POST['return_quantity'] ?? [];
    $damages = $_POST['damage'] ?? [];
    $notes = $_POST['damage_note'] ?? [];

    if ($orderId <= 0 || empty($itemIds)) {
        $_SESSION['error'] = 'Please select items to return.';
        header("Location: " . url("") . "return_form&order_id=$orderId");
        exit;
    }

    $created = false;
    foreach ($itemIds as $index => $itemId) {
        $itemId = (int) $itemId;
        $quantity = isset($quantities[$index]) ? (int) $quantities[$index] : 0;
        if ($quantity <= 0) {
            continue;
        }

        $damage = isset($damages[$index]) ? 1 : 0;
        $note = trim($notes[$index] ?? '');
        $status = $damage ? 'trashed' : 'restocked';

        $stmt = $this->conn->prepare(
            "SELECT order_id, product_id, quantity FROM order_items WHERE id = ? LIMIT 1"
        );
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();

        if (!$item || $item['order_id'] != $orderId) {
            continue;
        }

        $returnQty = min($quantity, (int) $item['quantity']);
        if ($returnQty <= 0) {
            continue;
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO return_requests (order_id, order_item_id, product_id, quantity, status, damage_note)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("iiiiss", $orderId, $itemId, $item['product_id'], $returnQty, $status, $note);
        $stmt->execute();

        if (!$damage) {
            $this->productModel->increaseStock($item['product_id'], $returnQty);
        }

        $created = true;
    }

    if ($created) {
        $_SESSION['success'] = 'Return request processed successfully.';
    } else {
        $_SESSION['error'] = 'No valid return quantities were provided.';
    }

    header("Location: " . url("") . "return_form&order_id=$orderId");
    exit;
}

public function returnReport()
{
    $this->ensureReturnTableExists();

    $result = $this->conn->query(
        "SELECT rr.*, o.customer_name, o.status AS order_status, p.name AS product_name, oi.quantity AS ordered_quantity
         FROM return_requests rr
         LEFT JOIN orders o ON o.id = rr.order_id
         LEFT JOIN product p ON p.id = rr.product_id
         LEFT JOIN order_items oi ON oi.id = rr.order_item_id
         ORDER BY rr.created_at DESC"
    );

    $returns = [];
    while ($row = $result->fetch_assoc()) {
        $returns[] = $row;
    }

    $data = [
        'title' => 'Return Requests',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view'  => 'admin/returns_report.php',
        'returns' => $returns
    ];
    extract($data);
    require BASE_PATH.'/app/views/admin/layout.php';
}

public function returnTrash()
{
    $this->ensureReturnTableExists();

    $result = $this->conn->query(
        "SELECT rr.*, o.customer_name, o.status AS order_status, p.name AS product_name, oi.quantity AS ordered_quantity
         FROM return_requests rr
         LEFT JOIN orders o ON o.id = rr.order_id
         LEFT JOIN product p ON p.id = rr.product_id
         LEFT JOIN order_items oi ON oi.id = rr.order_item_id
         WHERE rr.status = 'trashed'
         ORDER BY rr.created_at DESC"
    );

    $returns = [];
    while ($row = $result->fetch_assoc()) {
        $returns[] = $row;
    }

    $data = [
        'title' => 'Return Trash',
        'theme' => $_SESSION['theme'] ?? 'theme-luxury',
        'view'  => 'admin/returns_trash.php',
        'returns' => $returns
    ];
    extract($data);
    require BASE_PATH.'/app/views/admin/layout.php';
}

public function saveReview() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['customer_id'])) {
        $_SESSION['review_error'] = "Please log in to leave a review.";
        header("Location: " . url("") . "customer_login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . url("") . "customer_orders");
        exit;
    }

    $submittedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $_SESSION['review_error'] = "Invalid security token. Please try again.";
        header("Location: " . url("") . "customer_orders");
        exit;
    }

    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $reviewText = trim((string)($_POST['review_text'] ?? ''));
    $customerId = (int)$_SESSION['customer_id'];

    if ($productId <= 0 || $orderId <= 0 || $rating < 1 || $rating > 5 || empty($reviewText)) {
        $_SESSION['review_error'] = "Please fill in all required fields with valid values.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    // Validate that the order belongs to the user, status is Delivered, and contains this product
    $stmt = $this->conn->prepare(
        "SELECT o.id FROM orders o
         INNER JOIN order_items oi ON o.id = oi.order_id
         WHERE o.user_id = ? AND oi.product_id = ? AND o.id = ? AND o.status = 'Delivered'
         LIMIT 1"
    );
    $stmt->bind_param("iii", $customerId, $productId, $orderId);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        $_SESSION['review_error'] = "You can only review products from delivered orders.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    // Check if review already exists using correct model
    if ($this->productModel->userHasReviewedProduct($customerId, $productId)) {
        $_SESSION['review_error'] = "You have already reviewed this product.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    // Add review using correct model method (correct schema)
    if ($this->productModel->addProductReview($customerId, $productId, $rating, $reviewText)) {
        $_SESSION['review_success'] = "Thank you! Your review has been submitted successfully.";
    } else {
        $_SESSION['review_error'] = "Failed to submit review. Please try again.";
    }

    header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
    exit;
}

private function ensureReviewTableExists() {
    $tableExists = $this->conn->query("SHOW TABLES LIKE 'product_reviews'");
    if ($tableExists && $tableExists->num_rows === 0) {
        $this->conn->query(
            "CREATE TABLE product_reviews (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                order_id INT NOT NULL,
                customer_id INT NOT NULL,
                rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
                review_text LONGTEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE,
                FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                FOREIGN KEY (customer_id) REFERENCES user(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );
    }
}

public function submitReturnRequest() {
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    if (empty($_SESSION['customer_id'])) {
        header("Location: " . url("") . "customer_login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . url("") . "customer_orders");
        exit;
    }

    $submittedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $_SESSION['return_error'] = "Invalid security token. Please try again.";
        header("Location: " . url("") . "customer_orders");
        exit;
    }

    $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
    $itemId = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    $reason = trim($_POST['reason'] ?? 'Standard Return');
    $detailsReason = trim($_POST['details_reason'] ?? '');
    $details = trim($_POST['details'] ?? '');
    $customerId = (int)$_SESSION['customer_id'];

    if ($orderId <= 0 || $itemId <= 0 || $quantity <= 0) {
        $_SESSION['return_error'] = "Please provide all required fields.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    // Verify order ownership and status
    $stmt = $this->conn->prepare("SELECT status FROM orders WHERE id = ? AND user_id = ? LIMIT 1");
    $stmt->bind_param("ii", $orderId, $customerId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if (!$order || strtolower(trim($order['status'])) !== 'delivered') {
        $_SESSION['return_error'] = "You can only request returns for delivered orders.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    // Verify item belongs to order and get available quantity
    $stmt = $this->conn->prepare("SELECT product_id, quantity FROM order_items WHERE id = ? AND order_id = ? LIMIT 1");
    $stmt->bind_param("ii", $itemId, $orderId);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();

    if (!$item) {
        $_SESSION['return_error'] = "Invalid item selected.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    if ($quantity > (int)$item['quantity']) {
        $_SESSION['return_error'] = "Return quantity cannot exceed the purchased amount.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    // Check if return request already exists
    $stmt = $this->conn->prepare("SELECT id FROM return_requests WHERE order_item_id = ? LIMIT 1");
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['return_error'] = "A return request already exists for this item.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    $damageNote = "Type: " . $reason;
    if (!empty($detailsReason)) {
        $damageNote .= " | Issue: " . $detailsReason;
    }
    if (!empty($details)) {
        $damageNote .= " | Note: " . $details;
    }

    $status = 'pending';
    $this->ensureReturnTableExists();
    
    $stmt = $this->conn->prepare(
        "INSERT INTO return_requests (order_id, order_item_id, product_id, quantity, status, damage_note)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("iiiiss", $orderId, $itemId, $item['product_id'], $quantity, $status, $damageNote);
    
    if ($stmt->execute()) {
        $_SESSION['return_success'] = "Return request submitted successfully. We will review it shortly.";
    } else {
        $_SESSION['return_error'] = "Failed to submit return request. Please try again.";
    }

    header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
    exit;
}

public function customerReturnRequestPage() {
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    if (empty($_SESSION['customer_id'])) {
        header("Location: " . url("") . "customer_login");
        exit;
    }

    $orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
    $itemId = isset($_GET['item_id']) ? (int)$_GET['item_id'] : 0;
    $customerId = (int)$_SESSION['customer_id'];

    if ($orderId <= 0 || $itemId <= 0) {
        header("Location: " . url("") . "customer_orders");
        exit;
    }

    // Web Settings
    $settingsModel = new Settings();
    $webSettings = $settingsModel->getWebSettings();
    $global_theme = $webSettings['theme'] ?? 'theme-luxury';
    $webname = $webSettings['web_name'] ?? 'StitchSmart';
    $webmail = $webSettings['web_mail'] ?? 'info@stitchsmart.com';
    $webcontact = $webSettings['web_contact'] ?? 'StitchSmart';
    $facebook = $webSettings['facebook'] ?? '';
    $instagram = $webSettings['instagram'] ?? '';

    // Verify order
    $stmt = $this->conn->prepare("SELECT id, status FROM orders WHERE id = ? AND user_id = ? LIMIT 1");
    $stmt->bind_param("ii", $orderId, $customerId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if (!$order || strtolower(trim($order['status'])) !== 'delivered') {
        $_SESSION['return_error'] = "You can only request returns for delivered orders.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    // Verify item
    $stmt = $this->conn->prepare("SELECT oi.*, p.name AS product_name, p.image_url AS product_image FROM order_items oi LEFT JOIN product p ON p.id = oi.product_id WHERE oi.id = ? AND oi.order_id = ? LIMIT 1");
    $stmt->bind_param("ii", $itemId, $orderId);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();

    if (!$item) {
        $_SESSION['return_error'] = "Invalid item selected.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    // Check if return exists
    $this->ensureReturnTableExists();
    $stmt = $this->conn->prepare("SELECT id FROM return_requests WHERE order_item_id = ? LIMIT 1");
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['return_error'] = "A return request already exists for this item.";
        header("Location: " . url("") . "customer_order_detail?id=" . $orderId);
        exit;
    }

    require BASE_PATH . '/app/views/User/customer_return_request.php';
}

public function updateReturnStatus() {
    if (!isset($_GET['id']) || !isset($_GET['action'])) {
        header("Location: " . url("") . "return_report");
        exit;
    }

    $id = (int)$_GET['id'];
    $action = $_GET['action']; // 'restock', 'trash', 'reject'

    $stmt = $this->conn->prepare("SELECT * FROM return_requests WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $returnReq = $stmt->get_result()->fetch_assoc();

    if (!$returnReq) {
        $_SESSION['error'] = "Return request not found.";
        header("Location: " . url("") . "return_report");
        exit;
    }

    if ($returnReq['status'] !== 'pending') {
        $_SESSION['error'] = "This return request has already been processed.";
        header("Location: " . url("") . "return_report");
        exit;
    }

    $newStatus = '';
    if ($action === 'restock') {
        $newStatus = 'restocked';
        $this->productModel->increaseStock($returnReq['product_id'], $returnReq['quantity']);
    } elseif ($action === 'trash') {
        $newStatus = 'trashed';
    } elseif ($action === 'reject') {
        $newStatus = 'rejected';
    } else {
        $_SESSION['error'] = "Invalid action.";
        header("Location: " . url("") . "return_report");
        exit;
    }

    $updateStmt = $this->conn->prepare("UPDATE return_requests SET status = ? WHERE id = ?");
    $updateStmt->bind_param("si", $newStatus, $id);
    
    if ($updateStmt->execute()) {
        $_SESSION['success'] = "Return request has been $newStatus successfully.";
    } else {
        $_SESSION['error'] = "Failed to update return request.";
    }

    header("Location: " . url("") . "return_report");
    exit;
}

private function refreshCartPrices() {
    if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) return;
    foreach ($_SESSION['cart'] as $id => &$item) {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            $discount = max(0, (int)($product['sale_discount_percent'] ?? 0));
            $basePrice = (float)$product['price'];
            if ($discount > 0) {
                $item['price'] = round($basePrice * (1 - ($discount / 100)), 2);
                $item['old_price'] = $basePrice;
                $item['discount_percent'] = $discount;
            } else {
                $item['price'] = $basePrice;
                $item['old_price'] = $basePrice;
                $item['discount_percent'] = 0;
            }
        }
    }
    unset($item);
}
}
