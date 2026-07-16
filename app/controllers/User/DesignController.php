<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/settings.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';

require BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class DesignController {
 private $productModel;
    private $categoryModel;

    public function __construct(){
        $database = new Database();
        $db = $database->connect();

        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
    }
    public function index() {
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
        $global_theme = $webSettings['theme'] ?? 'theme-default';
        $meta_keywords = $webSettings['meta_keywords'] ?? '';

         // fetch data for homepage
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getCategoriesTree();
        require BASE_PATH . '/app/views/User/designyourself/interface.php';
    }
     public function hoodie() {
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
        $global_theme = $webSettings['theme'] ?? 'theme-default';
        $meta_keywords = $webSettings['meta_keywords'] ?? '';

         // fetch data for homepage
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getCategoriesTree();
        require BASE_PATH . '/app/views/User/designyourself/hoodie.php';
    }

    public function shopAllCustomizer() {
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
        $global_theme = $webSettings['theme'] ?? 'theme-default';
        $meta_keywords = $webSettings['meta_keywords'] ?? '';

        $allProducts = $this->productModel->getAllProducts();
        
        // Pagination logic
        $perPage = 12;
        $totalProducts = count($allProducts);
        $totalPages = ceil($totalProducts / $perPage);
        $currentPage = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
        
        // Ensure current page is not greater than total pages if total pages > 0
        if ($totalPages > 0 && $currentPage > $totalPages) {
            $currentPage = $totalPages;
        }
        
        $offset = ($currentPage - 1) * $perPage;
        $paginatedProducts = array_slice($allProducts, $offset, $perPage);

        $categories = $this->categoryModel->getCategoriesTree();
        require BASE_PATH . '/app/views/User/designyourself/shopall.php';
    }

    public function shorts() {
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
        $global_theme = $webSettings['theme'] ?? 'theme-default';
        $meta_keywords = $webSettings['meta_keywords'] ?? '';

         // fetch data for homepage
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getCategoriesTree();
        require BASE_PATH . '/app/views/User/designyourself/shorts.php';
    }
    public function crewneck() {
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
        $global_theme = $webSettings['theme'] ?? 'theme-default';
        $meta_keywords = $webSettings['meta_keywords'] ?? '';

         // fetch data for homepage
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getCategoriesTree();
        require BASE_PATH . '/app/views/User/designyourself/crewneck.php';
    }

 public function sweatpant() {
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
        $global_theme = $webSettings['theme'] ?? 'theme-default';
        $meta_keywords = $webSettings['meta_keywords'] ?? '';

         // fetch data for homepage
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getCategoriesTree();
        require BASE_PATH . '/app/views/User/designyourself/sweatpant.php';
    }

    public function sendInquiry() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim(strip_tags((string)($_POST['name'] ?? '')));
            $email = trim((string)($_POST['email'] ?? ''));
            $mobile = trim(strip_tags((string)($_POST['mobile'] ?? '')));
            $whatsapp = trim(strip_tags((string)($_POST['whatsapp'] ?? '')));
            $message = trim(strip_tags((string)($_POST['message'] ?? '')));
            $body = $_POST['body'] ?? '';
            $subject = trim(strip_tags((string)($_POST['subject'] ?? 'New Design Inquiry')));

            if (empty($name) || empty($email) || empty($body)) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Name, email and details are required.']);
                exit;
            }

            $mail = new PHPMailer(true);
        $mail->Timeout = 15;

            try {
                $mail->isSMTP();
                $mail->Host       = MAIL_HOST;
                $mail->SMTPAuth   = true;
                $mail->AuthType   = 'LOGIN';
                $mail->Username   = MAIL_USERNAME;
                $mail->Password   = MAIL_PASSWORD;
                $mail->SMTPSecure = MAIL_ENCRYPTION;
                $mail->Port       = MAIL_PORT;

                $mail->setFrom(MAIL_FROM_ADDRESS, 'Stitch Smart Design Inquiry');
                $mail->addAddress(MAIL_FROM_ADDRESS);
                $mail->addReplyTo($email, $name);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $this->formatHtmlEmail($subject, $body, $name, $email, $mobile, $whatsapp, $message);
                $mail->AltBody = $body;

                if (isset($_FILES['labelImage']) && $_FILES['labelImage']['error'] === UPLOAD_ERR_OK) {
                    $mail->addAttachment($_FILES['labelImage']['tmp_name'], $_FILES['labelImage']['name']);
                }
                if (isset($_FILES['designImage']) && $_FILES['designImage']['error'] === UPLOAD_ERR_OK) {
                    $mail->addAttachment($_FILES['designImage']['tmp_name'], $_FILES['designImage']['name']);
                }

                $mail->send();

                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Inquiry sent successfully!']);
                exit;
            } catch (Exception $e) {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
                exit;
            }
        }
    }

    private function formatHtmlEmail($subject, $body, $name, $email, $mobile, $whatsapp, $message) {
        $lines = explode("\n", $body);
        $sections = [];
        $currentSection = 'General';
        
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '---') !== false) {
                continue;
            }
            
            $lowerLine = strtolower($line);
            
            // Check for section transitions
            if (str_starts_with($lowerLine, 'order details') || str_starts_with($lowerLine, 'order summary')) {
                $currentSection = 'Order Details';
                continue;
            }
            if (str_starts_with($lowerLine, 'finishing')) {
                $currentSection = 'Finishing';
                continue;
            }
            if (str_starts_with($lowerLine, 'prints/comments') || str_starts_with($lowerLine, 'prints & requests')) {
                $currentSection = 'Prints/Comments';
                // Do not continue: the line might contain data after the colon (e.g. Prints/Comments: Left chest print)
            }
            if (str_starts_with($lowerLine, 'quantities')) {
                $currentSection = 'Quantities';
                // Try to extract sample info if present on this line
                if (preg_match('/sample(?:\s+first\?)?:\s*([^\)]+)/i', $line, $matches)) {
                    $sections['Quantities']['Sample'] = trim($matches[1]);
                }
                continue;
            }
            if (str_starts_with($lowerLine, 'sent via') || str_starts_with($lowerLine, 'sent from')) {
                $currentSection = 'General';
                continue;
            }
            if (stripos($line, 'New') === 0 && stripos($line, 'Inquiry') !== false) {
                $currentSection = 'Header';
                $sections['Title'] = $line;
                continue;
            }
            
            // Specific parsing for Labels line to make sure it goes to the Labels section
            if (stripos($line, 'labels:') === 0) {
                list($key, $val) = explode(':', $line, 2);
                $sections['Labels'][trim($key)] = trim($val);
                continue;
            }
            
            // Parse based on current section
            if ($currentSection === 'Quantities') {
                $parts = explode(',', $line);
                foreach ($parts as $part) {
                    if (strpos($part, ':') !== false) {
                        list($qKey, $qVal) = explode(':', $part, 2);
                        $qKey = trim($qKey);
                        $qVal = trim($qVal);
                        if (strtolower($qKey) !== 'sample') {
                            $sections['Quantities'][$qKey] = $qVal;
                        }
                    }
                }
            } else {
                if (strpos($line, ':') !== false) {
                    list($key, $val) = explode(':', $line, 2);
                    $key = trim($key);
                    $val = trim($val);
                    
                    if (strtolower($key) === 'contact' || strtolower($key) === 'message') {
                        continue;
                    }
                    
                    $sections[$currentSection][$key] = $val;
                } else {
                    if (!isset($sections[$currentSection]['_text'])) {
                        $sections[$currentSection]['_text'] = [];
                    }
                    $sections[$currentSection]['_text'][] = $line;
                }
            }
        }
        
        $logoText = "Stitch Smart";
        $titleText = isset($sections['Title']) ? $sections['Title'] : $subject;
        
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: \'Outfit\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;
            background-color: #f5f5f7;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }
        .header {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            padding: 35px 20px;
            text-align: center;
            border-bottom: 3px solid #c19a4e;
        }
        .header h1 {
            color: #ffffff;
            font-size: 26px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .header p {
            color: #c19a4e;
            font-size: 14px;
            margin: 8px 0 0 0;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .content {
            padding: 30px 40px;
        }
        .section-title {
            color: #111827;
            font-size: 18px;
            font-weight: 700;
            margin-top: 25px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f3f4f6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .card {
            background-color: #f9fafb;
            border: 1px solid #f3f4f6;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .detail-row {
            margin-bottom: 12px;
            font-size: 15px;
            line-height: 1.5;
        }
        .detail-label {
            color: #6b7280;
            font-weight: 600;
            width: 140px;
            display: inline-block;
            vertical-align: top;
        }
        .detail-value {
            color: #111827;
            display: inline-block;
            width: calc(100% - 150px);
            font-weight: 500;
        }
        .message-box {
            background-color: #fdfbf7;
            border-left: 4px solid #c19a4e;
            padding: 15px;
            border-radius: 4px 12px 12px 4px;
            font-style: italic;
            color: #4b5563;
            font-size: 15px;
            line-height: 1.6;
        }
        .qty-badge {
            display: inline-block;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 12px;
            margin: 5px;
            text-align: center;
            min-width: 60px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .qty-size {
            font-size: 12px;
            color: #6b7280;
            font-weight: bold;
            display: block;
            margin-bottom: 2px;
        }
        .qty-val {
            font-size: 16px;
            color: #111827;
            font-weight: 700;
        }
        .qty-val.has-qty {
            color: #c19a4e;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>' . htmlspecialchars($logoText) . '</h1>
            <p>' . htmlspecialchars($titleText) . '</p>
        </div>
        <div class="content">
            <div class="section-title">Client Information</div>
            <div class="card">
                <div class="detail-row">
                    <span class="detail-label">Name</span>
                    <span class="detail-value" style="font-size: 16px; font-weight: bold; color: #c19a4e;">' . htmlspecialchars($name) . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">' . htmlspecialchars($email) . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Mobile</span>
                    <span class="detail-value">' . htmlspecialchars($mobile) . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">WhatsApp</span>
                    <span class="detail-value">' . htmlspecialchars($whatsapp) . '</span>
                </div>
            </div>
 
            <div class="section-title">Client Message</div>
            <div class="message-box">
                ' . nl2br(htmlspecialchars($message)) . '
            </div>';
 
        if (isset($sections['Order Details']) && !empty($sections['Order Details'])) {
            $html .= '
            <div class="section-title">Garment Specifications</div>
            <div class="card">';
            foreach ($sections['Order Details'] as $key => $value) {
                if ($key === '_text') continue;
                $html .= '
                <div class="detail-row">
                    <span class="detail-label">' . htmlspecialchars($key) . '</span>
                    <span class="detail-value">' . htmlspecialchars($value) . '</span>
                </div>';
            }
            $html .= '</div>';
        }
 
        if (isset($sections['Labels']) && !empty($sections['Labels'])) {
            $html .= '
            <div class="section-title">Labels & Branding</div>
            <div class="card">';
            foreach ($sections['Labels'] as $key => $value) {
                if ($key === '_text') continue;
                $html .= '
                <div class="detail-row">
                    <span class="detail-label">' . htmlspecialchars($key) . '</span>
                    <span class="detail-value">' . htmlspecialchars($value) . '</span>
                </div>';
            }
            $html .= '</div>';
        }
 
        if (isset($sections['Prints/Comments']) && !empty($sections['Prints/Comments'])) {
            $html .= '
            <div class="section-title">Prints & Designs</div>
            <div class="card">';
            if (isset($sections['Prints/Comments']['_text'])) {
                foreach ($sections['Prints/Comments']['_text'] as $textLine) {
                    $html .= '<p style="margin: 0 0 10px 0; color: #4b5563; font-size: 15px; line-height: 1.5;">' . htmlspecialchars($textLine) . '</p>';
                }
            }
            foreach ($sections['Prints/Comments'] as $key => $value) {
                if ($key === '_text') continue;
                $html .= '
                <div class="detail-row">
                    <span class="detail-label">' . htmlspecialchars($key) . '</span>
                    <span class="detail-value">' . htmlspecialchars($value) . '</span>
                </div>';
            }
            $html .= '</div>';
        }
 
        if (isset($sections['Finishing']) && !empty($sections['Finishing'])) {
            $html .= '
            <div class="section-title">Finishing Customizations</div>
            <div class="card">';
            foreach ($sections['Finishing'] as $key => $value) {
                if ($key === '_text') continue;
                $displayKey = trim($key, '- ');
                $html .= '
                <div class="detail-row">
                    <span class="detail-label">' . htmlspecialchars($displayKey) . '</span>
                    <span class="detail-value">' . htmlspecialchars($value) . '</span>
                </div>';
            }
            $html .= '</div>';
        }
 
        if (isset($sections['Quantities']) && !empty($sections['Quantities'])) {
            $sampleText = isset($sections['Quantities']['Sample']) ? ' (Sample: ' . $sections['Quantities']['Sample'] . ')' : '';
            $html .= '
            <div class="section-title">Order Quantities' . htmlspecialchars($sampleText) . '</div>
            <div style="margin-bottom: 25px; text-align: center;">';
            foreach ($sections['Quantities'] as $key => $value) {
                if ($key === '_text' || strtolower($key) === 'sample') continue;
                $hasQtyClass = ((int)$value > 0) ? ' has-qty' : '';
                $html .= '
                <div class="qty-badge">
                    <span class="qty-size">' . htmlspecialchars($key) . '</span>
                    <span class="qty-val' . $hasQtyClass . '">' . htmlspecialchars($value) . '</span>
                </div>';
            }
            $html .= '
            </div>';
        }
 
        foreach ($sections as $secName => $secData) {
            if (in_array($secName, ['Header', 'Title', 'Order Details', 'Labels', 'Prints/Comments', 'Finishing', 'Quantities', 'General'])) {
                continue;
            }
            if (empty($secData)) continue;
            
            $html .= '
            <div class="section-title">' . htmlspecialchars($secName) . '</div>
            <div class="card">';
            if (is_array($secData)) {
                if (isset($secData['_text'])) {
                    foreach ($secData['_text'] as $textLine) {
                        $html .= '<p style="margin: 0 0 10px 0; color: #4b5563; font-size: 15px; line-height: 1.5;">' . htmlspecialchars($textLine) . '</p>';
                    }
                }
                foreach ($secData as $key => $value) {
                    if ($key === '_text') continue;
                    $html .= '
                    <div class="detail-row">
                        <span class="detail-label">' . htmlspecialchars($key) . '</span>
                        <span class="detail-value">' . htmlspecialchars($value) . '</span>
                    </div>';
                }
            } else {
                $html .= '<p style="margin: 0; color: #4b5563; font-size: 15px; line-height: 1.5;">' . htmlspecialchars($secData) . '</p>';
            }
            $html .= '</div>';
        }
 
        $html .= '
        </div>
        <div class="footer">
            This is an automated email from the custom design portal at Stitch Smart.<br>
            &copy; ' . date('Y') . ' Stitch Smart. All rights reserved.
        </div>
    </div>
</body>
</html>';
 
        return $html;
    }
}
