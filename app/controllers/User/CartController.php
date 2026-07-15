<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';
require_once BASE_PATH.'/app/models/settings.php';

require_once BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CartController {

    private $productModel;
    private $categoryModel;


    public function __construct(){
        $database = new Database();
        $db = $database->connect();

        $this->productModel = new Product($db);
         $this->categoryModel = new Category($db);
    }

    public function add(){

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $product_id = $_POST['product_id'] ?? null;
    $qty = (int)($_POST['qty'] ?? 1);
    $size = $_POST['size'] ?? '';
    $fabric = $_POST['fabric'] ?? '';

    if(!$product_id){
        die("Invalid Product");
    }

    $product = $this->productModel->getProductById($product_id);

    if(!$product){
        die("Product not found");
    }

    if (empty($size) && !empty($product['size'])) {
        $parts = explode(',', $product['size']);
        foreach ($parts as $p) {
            $p = trim($p);
            if (empty($p)) continue;
            $sub = explode(':', $p);
            $sz = trim($sub[0]);
            $stk = (count($sub) === 2) ? (int)trim($sub[1]) : (int)$product['quantity'];
            if ($stk > 0) {
                $size = $sz;
                break;
            }
        }
    }

    // Out of Stock check
    if ((int)$product['quantity'] <= 0) {
        $this->sendRestockRequestMail($product);
        $_SESSION['cart_error'] = "The product '" . $product['name'] . "' is currently out of stock. We have automatically notified the admin to restock it.";
        header("Location: " . url("product_show?id=" . $product_id));
        exit;
    }

    $discount = max(0, (int)($product['sale_discount_percent'] ?? 0));
    $basePrice = (float)$product['price'];
    $finalPrice = ($discount > 0) ? round($basePrice * (1 - ($discount / 100)), 2) : $basePrice;

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    if(isset($_SESSION['cart'][$product_id])){
        $newQty = $_SESSION['cart'][$product_id]['qty'] + $qty;
        if($newQty > $product['quantity']){
            $_SESSION['cart_error'] = "We only have " . $product['quantity'] . " units in stock for this product.";
            header("Location: " . url("product_show?id=" . $product_id));
            exit;
        }
        $_SESSION['cart'][$product_id]['qty'] = $newQty;
        $_SESSION['cart'][$product_id]['price'] = $finalPrice;
        $_SESSION['cart'][$product_id]['old_price'] = $basePrice;
        $_SESSION['cart'][$product_id]['discount_percent'] = $discount;
        if (!empty($size)) $_SESSION['cart'][$product_id]['size'] = $size;
        if (!empty($fabric)) $_SESSION['cart'][$product_id]['fabric'] = $fabric;
    } else {
        if($qty > $product['quantity']){
            $_SESSION['cart_error'] = "We only have " . $product['quantity'] . " units in stock for this product.";
            header("Location: " . url("product_show?id=" . $product_id));
            exit;
        }
        $_SESSION['cart'][$product_id] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $finalPrice,
            'old_price' => $basePrice,
            'discount_percent' => $discount,
            'image' => $product['image_url'],
            'qty' => $qty,
            'size' => $size,
            'fabric' => $fabric
        ];
    }

    $_SESSION['cart_success'] = "Added '" . $product['name'] . "' to your cart successfully!";

    if (isset($_SESSION['customer_id'])) {
        require_once BASE_PATH . '/app/models/SchemaBootstrap.php';
        $schemaBootstrap = new SchemaBootstrap((new Database())->connect(), false);
        $schemaBootstrap->syncCartToDb((int)$_SESSION['customer_id'], $_SESSION['cart']);
    }

    $redirectTo = trim((string)($_POST['redirect_to'] ?? ''));
    if (!empty($redirectTo)) {
        header("Location: " . url($redirectTo));
    } else {
        header("Location: " . url("") . "cart");
    }
    exit;
}

private function sendRestockRequestMail($product)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Prevent sending duplicate emails per session
    if (isset($_SESSION['notified_restock'][$product['id']])) {
        return;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->Timeout = 15;
        $mail->isSMTP();
        $mail->Host     = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port     = MAIL_PORT;

        $mail->setFrom(MAIL_USERNAME, 'Stock Restock Alert');
        $mail->addAddress(MAIL_USERNAME, 'Stitch Smart Admin');

        $mail->isHTML(true);
        $mail->Subject = "Restock Needed: " . $product['name'] . " (Out of Stock)";

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
                            URGENT RESTOCK REQUEST
                        </span>
                    </div>

                    <h2 style='color: #1a1a1a; margin-top: 0; font-size: 20px;'>Hello Admin,</h2>
                    <p style='font-size: 16px; line-height: 1.6; color: #5c4335;'>
                        A customer just attempted to purchase the following product, but it is currently flagged as <strong>Out of Stock</strong>.
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
                                <td style='padding: 15px 0 5px 0; color: #7a6253; font-weight: 600;'>Sizes Configured</td>
                                <td style='padding: 15px 0 5px 0; color: #1a1a1a; font-weight: bold; text-align: right;'>{$product['size']}</td>
                            </tr>
                        </table>
                    </div>

                    <p style='font-size: 15px; line-height: 1.6; color: #5c4335;'>
                        Please log in to the <a href='#' style='color: #c19a4e; text-decoration: none; font-weight: bold;'>Admin Dashboard</a> and restock this item as soon as possible to avoid losing potential sales.
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
        $_SESSION['notified_restock'][$product['id'] ] = true;
    } catch (Exception $e) {
        error_log('Restock Request Mail Error: ' . $mail->ErrorInfo);
    }
}

    public function index(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->refreshCartPrices();

        $categories = $this->categoryModel->getCategoriesTree();
        $settingsModel = new Settings();
        $ws = $settingsModel->getWebSettings();
        $webname = $ws['web_name'] ?? ''; $webcontact = $ws['web_contact'] ?? ''; $webmail = $ws['web_mail'] ?? '';
        $facebook = $ws['facebook'] ?? ''; $instagram = $ws['instagram'] ?? ''; $pinterest = $ws['pinterest'] ?? ''; $linkdin = $ws['linkdin'] ?? '';
        $meta_description = $ws['meta_description'] ?? '';
        $global_theme = $ws['theme'] ?? 'theme-default';

        $cart = $_SESSION['cart'] ?? [];

        require BASE_PATH . '/app/views/User/cart.php';
    }

    public function remove(){

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id = $_GET['id'] ?? null;

        if($id && isset($_SESSION['cart'][$id])){
            unset($_SESSION['cart'][$id]);
        }

        if (isset($_SESSION['customer_id'])) {
            require_once BASE_PATH . '/app/models/SchemaBootstrap.php';
            $schemaBootstrap = new SchemaBootstrap((new Database())->connect(), false);
            $schemaBootstrap->syncCartToDb((int)$_SESSION['customer_id'], $_SESSION['cart'] ?? []);
        }

        header("Location: " . url("") . "cart");
        exit;
    }
    public function update(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id = $_GET['id'] ?? null;
        $action = $_GET['action'] ?? 'add';

        if($id && isset($_SESSION['cart'][$id])){
            $product = $this->productModel->getProductById($id);
            if($action === 'add'){
                if(($_SESSION['cart'][$id]['qty'] + 1) > $product['quantity']){
                     // Just don't increment if stock exceeded
                } else {
                    $_SESSION['cart'][$id]['qty']++;
                }
            } else if($action === 'minus'){
                $_SESSION['cart'][$id]['qty']--;
                if($_SESSION['cart'][$id]['qty'] <= 0){
                    unset($_SESSION['cart'][$id]);
                }
            }
        }

        $this->refreshCartPrices();

        if (isset($_SESSION['customer_id'])) {
            require_once BASE_PATH . '/app/models/SchemaBootstrap.php';
            $schemaBootstrap = new SchemaBootstrap((new Database())->connect(), false);
            $schemaBootstrap->syncCartToDb((int)$_SESSION['customer_id'], $_SESSION['cart'] ?? []);
        }

        header("Location: " . url("") . "cart");
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
