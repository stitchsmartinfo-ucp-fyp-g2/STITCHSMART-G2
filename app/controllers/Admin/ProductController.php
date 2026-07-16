<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';
require_once BASE_PATH.'/app/models/NewsletterSubscriber.php';
require_once BASE_PATH.'/app/services/ApiService.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ProductController{

    private $productModel;
      private $categoryModel; // make sure this is declared
  

    public function __construct(){

        $database = new Database();
        $db = $database->connect();

        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db); // initialize it
    }

    public function create(){
        $top_categories = $this->categoryModel->getCategoriesTree();

        $data['title'] = 'Add Product';
        $data['theme'] = $_SESSION['theme'] ?? 'theme-default';
        $data['view'] = 'admin/add_product.php';
        $data['top_categories'] = $top_categories;

        extract($data);
        require BASE_PATH . '/app/views/admin/layout.php';
    }

   public function index(){
    $this->productModel->fixAllZeroSizesInDB();
    $products = $this->productModel->getAllProducts();

    $data['title'] = 'Products';
    $data['theme'] = $_SESSION['theme'] ?? 'theme-default';
    $data['view'] = 'admin/admin_products.php';
    $data['products'] = $products;

    extract($data); 

    require BASE_PATH.'/app/views/admin/layout.php';
}
public function feature()
{
    if (!isset($_GET['id'])) {
        header("Location: " . url("") . "admin_products");
        exit;
    }

    $id = (int) $_GET['id'];
    $product = $this->productModel->getProductById($id);

    if (!$product) {
        die("Product not found");
    }

    $isFeatured = (int) ($product['featured'] ?? 0) === 1;
    $newStatus = $isFeatured ? 0 : 1;
    $this->productModel->toggleFeatured($id, $newStatus);

    if ($newStatus) {
        $_SESSION['flash'] = "✅ Product marked as Featured ⭐";
    } else {
        $_SESSION['flash'] = "❌ Product removed from Featured";
    }

    header("Location: " . url("") . "admin_feature_products");
    exit;
}

public function featureIndex()
{
    $allProducts = $this->productModel->getAllProducts();
    
    $featuredProducts = [];
    $nonFeaturedProducts = [];
    
    foreach ($allProducts as $p) {
        if ((int)$p['featured'] === 1) {
            $featuredProducts[] = $p;
        } else {
            $nonFeaturedProducts[] = $p;
        }
    }

    $data['title'] = 'Featured Products';
    $data['theme'] = $_SESSION['theme'] ?? 'theme-default';
    $data['view'] = 'admin/admin_feature_products.php';
    $data['products'] = $featuredProducts;
    $data['available_products'] = $nonFeaturedProducts;

    extract($data);
    require BASE_PATH . '/app/views/admin/layout.php';
}

    public function saleIndex()
    {
        $products = $this->productModel->getAllProducts();

        $data['title'] = 'Sale Products';
        $data['theme'] = $_SESSION['theme'] ?? 'theme-default';
        $data['view'] = 'admin/admin_sale_products.php';
        $data['products'] = $products;

        extract($data);
        require BASE_PATH . '/app/views/admin/layout.php';
    }

    public function toggleSale()
    {
        $id = isset($_POST['id']) ? (int) $_POST['id'] : (isset($_GET['id']) ? (int) $_GET['id'] : 0);

        if ($id <= 0) {
            header("Location: " . url("") . "admin_sale_products");
            exit;
        }

        $product = $this->productModel->getProductById($id);

        if (!$product) {
            die("Product not found");
        }

        $saleAction = $_POST['sale_action'] ?? 'add';
        $currentSaleDiscount = (int) ($product['sale_discount_percent'] ?? 0);
        $isFeatured = (int) ($product['featured'] ?? 0) === 1;

        $discountPercent = null;
        if (isset($_POST['discount']) && $_POST['discount'] !== '') {
            $discountPercent = filter_var($_POST['discount'], FILTER_VALIDATE_INT);
        } elseif (isset($_GET['discount']) && $_GET['discount'] !== '') {
            $discountPercent = filter_var($_GET['discount'], FILTER_VALIDATE_INT);
        }

        if ($saleAction === 'remove') {
            $this->productModel->setSaleDiscount($id, 0);
            $this->productModel->toggleFeatured($id, 0);
            $_SESSION['flash'] = "Product removed from Sale ✅";
            header("Location: " . url("") . "admin_sale_products?last_discount=" . (int)$discountPercent);
            exit;
        }

        if ($discountPercent === false) {
            $discountPercent = $currentSaleDiscount > 0 ? $currentSaleDiscount : 20;
        }

        $discountPercent = max(0, min(100, (int) $discountPercent));
        $this->productModel->setSaleDiscount($id, $discountPercent);

        $_SESSION['flash'] = $discountPercent > 0 ? "Product added to Sale ✅" : "Product removed from Sale ✅";

        header("Location: " . url("") . "admin_sale_products?last_discount=" . (int)$discountPercent);
        exit;
    }

    public function store() {
        $errors = [];
        $imagePaths = [];

        $name = trim($_POST['pname'] ?? '');
        $art = trim($_POST['art'] ?? '');
        $desc = trim($_POST['pdesc'] ?? '');
        $details = trim($_POST['details'] ?? '');
        $price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_FLOAT);
        $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : 0;
        
        // Handle Sizes and Quantities
        $qty_xs = (int)($_POST['qty_xs'] ?? 0);
        $qty_s = (int)($_POST['qty_s'] ?? 0);
        $qty_l = (int)($_POST['qty_l'] ?? 0);
        $qty_xl = (int)($_POST['qty_xl'] ?? 0);
        
        $total_qty = $qty_xs + $qty_s + $qty_l + $qty_xl;
        $sizes_str = "XS:{$qty_xs}, S:{$qty_s}, L:{$qty_l}, XL:{$qty_xl}";
        
        // Handle Design Yourself toggle
        $designing = isset($_POST['Designing']) ? 'Yes' : 'No';

        if (empty($name)) {
            $errors['pname'] = "Fill the Product Name field.";
        }
        if (empty($art)) {
            $errors['art'] = "Fill the Article Number field.";
        } elseif (!preg_match('/^[a-zA-Z0-9-]+$/', $art)) {
            $errors['art'] = "Article Number must be alphanumeric.";
        } elseif (!$this->productModel->isArticleNumberUnique($art)) {
            $errors['art'] = "Article Number already exists.";
        }
        
        if (empty($desc)) {
            $errors['pdesc'] = "Fill the Description field.";
        }
        if (empty($details)) {
            $errors['details'] = "Fill the Details field.";
        }
        if ($price === false || $price <= 0) {
            $errors['price'] = "Price must be a positive number.";
        }
        if ($parent_id <= 0) {
            $errors['parent_id'] = "Select a category.";
        }

        $hasImageUpload = false;
        if (isset($_FILES['bimage']['name'])) {
            $fileNames = is_array($_FILES['bimage']['name']) ? $_FILES['bimage']['name'] : [$_FILES['bimage']['name']];
            $validFileNames = array_filter(array_map('trim', $fileNames));
            $hasImageUpload = count($validFileNames) > 0;
            if (count($validFileNames) > 3) {
                $errors['bimage'] = "You can only upload a maximum of 3 product images.";
                $hasImageUpload = false;
            }
        }

        if ($hasImageUpload) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            $uploadDir = BASE_PATH . '/public/pictures/products/';
            $files = $_FILES['bimage'];

            $names = is_array($files['name']) ? $files['name'] : [$files['name']];
            $types = is_array($files['type']) ? $files['type'] : [$files['type']];
            $tmpNames = is_array($files['tmp_name']) ? $files['tmp_name'] : [$files['tmp_name']];
            $errorsArr = is_array($files['error']) ? $files['error'] : [$files['error']];
            $sizes = is_array($files['size']) ? $files['size'] : [$files['size']];

            $validUploads = [];
            foreach ($names as $index => $fileName) {
                if (empty($fileName)) {
                    continue;
                }

                $fileType = $types[$index] ?? '';
                $fileSize = $sizes[$index] ?? 0;
                $fileError = $errorsArr[$index] ?? UPLOAD_ERR_NO_FILE;
                $tmpName = $tmpNames[$index] ?? '';

                if (!in_array($fileType, $allowed_types)) {
                    $errors['bimage'] = "Invalid image type for {$fileName}. Only JPG, JPEG, and PNG are allowed.";
                    continue;
                }
                if ($fileSize > 10 * 1024 * 1024) {
                    $errors['bimage'] = "Image size for {$fileName} must be less than 10MB.";
                    continue;
                }
                if ($fileError !== UPLOAD_ERR_OK) {
                    $errors['bimage'] = "Error uploading {$fileName}.";
                    continue;
                }

                $validUploads[] = [
                    'name' => $fileName,
                    'tmp_name' => $tmpName
                ];
            }

            if (count($validUploads) < 1 && !isset($errors['bimage'])) {
                $errors['bimage'] = "Please upload at least 1 product image.";
            }

            if (empty($errors)) {
                foreach ($validUploads as $upload) {
                    $imageName = time() . '_' . uniqid() . '_' . basename($upload['name']);
                    $relativePath = 'pictures/products/' . $imageName;
                    if (move_uploaded_file($upload['tmp_name'], $uploadDir . $imageName)) {
                        $imagePaths[] = $relativePath;
                    } else {
                        $errors['bimage'] = "Failed to save image {$upload['name']}";
                    }
                }
            }

            if (empty($errors)) {
                $image = implode(',', $imagePaths);
            }
        } elseif (!isset($errors['bimage'])) {
            $errors['bimage'] = "Please upload at least 1 product image.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            header("Location: " . url("") . "add_product");
            exit;
        }

        $slug = $this->productModel->generateUniqueSlug($name);
        
        $meta_title = trim($_POST['meta_title'] ?? '');
        if (empty($meta_title)) {
            $meta_title = $name . ' | Stitch Smart';
        }
        $meta_description = trim($_POST['meta_desc'] ?? '');
        if (empty($meta_description)) {
            $meta_description = "Shop " . $name . " online at Stitch Smart. Enjoy premium quality fabric, modern tailored fit, and exceptional durability.";
        }
        $meta_keywords = trim($_POST['meta_keywords'] ?? '');
        if (empty($meta_keywords)) {
            $meta_keywords = $name . ", Stitch Smart, premium clothing, tailored wear";
        }

        $data = [
            'article_number' => $art,
            'name' => $name,
            'description' => $desc,
            'details' => $_POST['details'],
            'image_url' => $image,
            'size' => $sizes_str,
            'Fabric_Type' => '', // Removed from form
            'Designing' => $designing,
            'price' => $price,
            'parent_cat' => $parent_id,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'quantity' => $total_qty,
            'slug' => $slug
        ];

        if ($this->productModel->createProduct($data)) {
            $productData = $this->productModel->getProductBySlug($slug);
            if ($productData) {
                $data['id'] = $productData['id'];
                ApiService::syncProduct($data);
            }
            $this->sendNewProductAnnouncement($data);
        }

        header("Location: " . url("") . "admin_products");
        exit;
    }

// show edit form
    public function edit($id){
        $this->productModel->fixAllZeroSizesInDB();
        $product = $this->productModel->getProductById($id);
        if(!$product){
            die("Product not found");
        }
$top_categories = $this->categoryModel->getCategoriesTree();

        $data['title'] = 'Edit Product';
$data['theme'] = $_SESSION['theme'] ?? 'theme-default';
$data['view'] = 'admin/edit_product.php';
$data['product'] = $product;
$data['top_categories'] = $top_categories;
extract($data); 
require BASE_PATH.'/app/views/admin/layout.php';
    }

    // update product
    public function update(){
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $id = (int)$_POST['id'];
            $errors = [];
            
            // Basic Info
            $name = htmlspecialchars(trim($_POST['pname']));
            $art = htmlspecialchars(trim($_POST['art']));
            $desc = htmlspecialchars(trim($_POST['pdesc']));
            $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
            $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : 0;
            
            // Sizes & Qty
            if (isset($_POST['qty_xs']) || isset($_POST['qty_s']) || isset($_POST['qty_l']) || isset($_POST['qty_xl'])) {
                $qty_xs = (int)($_POST['qty_xs'] ?? 0);
                $qty_s = (int)($_POST['qty_s'] ?? 0);
                $qty_l = (int)($_POST['qty_l'] ?? 0);
                $qty_xl = (int)($_POST['qty_xl'] ?? 0);
                $total_qty = $qty_xs + $qty_s + $qty_l + $qty_xl;
                $sizes_str = "XS:{$qty_xs}, S:{$qty_s}, L:{$qty_l}, XL:{$qty_xl}";
            } elseif (isset($_POST['quantity'])) {
                $total_qty = (int)$_POST['quantity'];
                $sizes_str = $_POST['size'] ?? '';
            } else {
                $total_qty = 0;
                $sizes_str = "XS:0, S:0, L:0, XL:0";
            }

            $product = $this->productModel->getProductById($id);
            if(!$product) die("Product not found");

            // Validation
            if (empty($name)) $errors[] = "Product Name is required.";
            if (empty($art)) $errors[] = "Article Number is required.";
            if ($price === false || $price <= 0) $errors[] = "Price must be a positive number.";
            if ($parent_id <= 0) $errors[] = "Category is required.";

            // Unique Article Number check (only if changed)
            if ($art !== $product['article_number']) {
                if (!$this->productModel->isArticleNumberUnique($art)) {
                    $errors[] = "Article Number already exists.";
                }
            }

            $image = $product['image_url'];
            $hasImageUpload = false;
            if (isset($_FILES['bimage']['name'])) {
                $fileNames = is_array($_FILES['bimage']['name']) ? $_FILES['bimage']['name'] : [$_FILES['bimage']['name']];
                $validFileNames = array_filter(array_map('trim', $fileNames));
                $hasImageUpload = count($validFileNames) > 0;
                if (count($validFileNames) > 3) {
                    $errors[] = "You can only upload a maximum of 3 product images.";
                    $hasImageUpload = false;
                }
            }

            // handle new image upload
            if ($hasImageUpload) {
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                $uploadDir = BASE_PATH . '/public/pictures/products/';
                $files = $_FILES['bimage'];

                $names = is_array($files['name']) ? $files['name'] : [$files['name']];
                $types = is_array($files['type']) ? $files['type'] : [$files['type']];
                $tmpNames = is_array($files['tmp_name']) ? $files['tmp_name'] : [$files['tmp_name']];
                $errorsArr = is_array($files['error']) ? $files['error'] : [$files['error']];
                $sizes = is_array($files['size']) ? $files['size'] : [$files['size']];

                $validUploads = [];
                foreach ($names as $index => $fileName) {
                    if (empty($fileName)) {
                        continue;
                    }

                    $fileType = $types[$index] ?? '';
                    $fileSize = $sizes[$index] ?? 0;
                    $fileError = $errorsArr[$index] ?? UPLOAD_ERR_NO_FILE;
                    $tmpName = $tmpNames[$index] ?? '';

                    if (!in_array($fileType, $allowed_types)) {
                        $errors[] = "Invalid image type for {$fileName}. JPG, PNG, and WEBP allowed.";
                        continue;
                    }
                    if ($fileSize > 10 * 1024 * 1024) {
                        $errors[] = "Image size for {$fileName} must be less than 10MB.";
                        continue;
                    }
                    if ($fileError !== UPLOAD_ERR_OK) {
                        $errors[] = "Error uploading {$fileName}.";
                        continue;
                    }

                    $validUploads[] = [
                        'name' => $fileName,
                        'tmp_name' => $tmpName
                    ];
                }

                if (!empty($validUploads) && count($validUploads) < 1) {
    $errors[] = "Please upload at least 1 product image.";
}

                if (empty($errors) && !empty($validUploads)) {
                    $imagePaths = [];
                    foreach ($validUploads as $upload) {
                        $imageName = time() . '_' . uniqid() . '_' . basename($upload['name']);
                        $relativePath = 'pictures/products/' . $imageName;
                        if (move_uploaded_file($upload['tmp_name'], $uploadDir . $imageName)) {
                            $imagePaths[] = $relativePath;
                        } else {
                            $errors[] = "Failed to save image {$upload['name']}.";
                        }
                    }

                    if (empty($errors)) {
                        $oldImages = array_filter(array_map('trim', explode(',', $image)));
                        foreach ($oldImages as $oldImage) {
                            if ($oldImage && file_exists(BASE_PATH . '/public/' . $oldImage)) {
                                @unlink(BASE_PATH . '/public/' . $oldImage);
                            }
                        }
                        $image = implode(',', $imagePaths);
                    }
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: " . url("") . "edit_product?id=" . $id);
                exit;
            }

            $slug = $this->productModel->generateUniqueSlug($name, (int)$id);

            $meta_title = trim($_POST['meta_title'] ?? '');
            if (empty($meta_title)) {
                $meta_title = $name . ' | Stitch Smart';
            }
            $meta_description = trim($_POST['meta_desc'] ?? '');
            if (empty($meta_description)) {
                $meta_description = "Shop " . $name . " online at Stitch Smart. Enjoy premium quality fabric, modern tailored fit, and exceptional durability.";
            }
            $meta_keywords = trim($_POST['meta_keywords'] ?? '');
            if (empty($meta_keywords)) {
                $meta_keywords = $name . ", Stitch Smart, premium clothing, tailored wear";
            }

            $data = [
                'id' => $id,
                'article_number' => $art,
                'name' => $name,
                'description' => $desc,
                'details' => $_POST['details'],
                'image_url' => $image,
                'size' => $sizes_str,
                'Fabric_Type' => $_POST['Fabric_Type'] ?? '',
                'Designing' => $_POST['Designing'] ?? 'No',
                'price' => $price,
                'parent_cat' => $parent_id,
                'meta_title' => $meta_title,
                'meta_description' => $meta_description,
                'meta_keywords' => $meta_keywords,
                'quantity' => $total_qty,
                'slug' => $slug,
                'color_id' => $_POST['color_id'] ?? 0
            ];

            $this->productModel->updateProduct($data);
            ApiService::syncProduct();

            // ── Stock Alert Emails ─────────────────────────────────────
            // Only alert if quantity was actually changed to a low/zero level
            $oldQty = (int)($product['quantity'] ?? 0);
            $newQty = $total_qty;

            if ($newQty <= 0) {
                // Out of stock
                $this->sendStockAlertMail($data, $newQty, 'out_of_stock');
            } elseif ($newQty <= 10) {
                // Low stock — only email if admin is setting it low (not restocking)
                if ($newQty < $oldQty || $oldQty == 0) {
                    $this->sendStockAlertMail($data, $newQty, 'low_stock');
                }
            }
            // ──────────────────────────────────────────────────────────

            $_SESSION['success'] = "Product updated successfully!";
            header("Location: ".url("") . "admin_products");
            exit;
        }
    }
// JSON QUERY
    public function exportJSON(){

    $products = $this->productModel->getAllProductsForAI();

    header('Content-Type: application/json');
    echo json_encode($products, JSON_PRETTY_PRINT);

    exit;
}

    private function sendNewProductAnnouncement($product)
    {
        $subscriberModel = new NewsletterSubscriber();
        $subscribers = $subscriberModel->getAll();

        if (!empty($subscribers)) {
            try {
                $mail = new PHPMailer(true);
                $mail->Timeout = 5;
                $mail->isSMTP();
                $mail->Host = MAIL_HOST;
                $mail->SMTPAuth = true;
                $mail->AuthType = 'LOGIN';
                $mail->Username = MAIL_USERNAME;
                $mail->Password = MAIL_PASSWORD;
                $mail->SMTPSecure = MAIL_ENCRYPTION;
                $mail->Port = MAIL_PORT;

                $mail->setFrom(MAIL_FROM_ADDRESS, APP_NAME);
                $mail->addAddress(MAIL_FROM_ADDRESS); // Primary to us, BCC to subscribers
                
                foreach ($subscribers as $subscriberEmail) {
                    $mail->addBCC($subscriberEmail);
                }
                
                $mail->isHTML(true);
                $mail->Subject = "New Product Launched: {$product['name']}";
                $mail->Body = "
                    <div style='font-family:Arial,sans-serif;padding:20px;color:#111;'>
                        <h2>New Arrival Alert</h2>
                        <p>We have just added a new product to StitchSmart:</p>
                        <p><strong>{$product['name']}</strong></p>
                        <p>Price: Rs {$product['price']}</p>
                        <p>{$product['details']}</p>
                        <p><a href='" . url("product_show?id={$product['id']}") . "' style='color:#c19a4e;'>View product now</a></p>
                        <hr>
                        <p>Thank you for staying with us.</p>
                    </div>
                ";
                $mail->AltBody = "New Arrival: {$product['name']} is now available for Rs {$product['price']}.";
                $mail->send();
            } catch (Exception $e) {
                // log or ignore error so it doesn't crash the product creation
            }
        }

        $this->sendAdminNewProductAlert($product, count($subscribers));
    }

    private function sendAdminNewProductAlert($product, $count)
    {
        try {
            $mail = new PHPMailer(true);
        $mail->Timeout = 15;
            $mail->isSMTP();
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'LOGIN';
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;
            $mail->SMTPSecure = MAIL_ENCRYPTION;
            $mail->Port = MAIL_PORT;

            $mail->setFrom(MAIL_FROM_ADDRESS, APP_NAME . ' Notifications');
            $mail->addAddress(MAIL_FROM_ADDRESS);
            $mail->isHTML(true);
            $mail->Subject = 'New product added: ' . $product['name'];
            $mail->Body = "
                <div style='font-family:Arial,sans-serif;padding:20px;color:#111;'>
                    <h2>New product published</h2>
                    <p>Product: <strong>{$product['name']}</strong></p>
                    <p>Price: Rs {$product['price']}</p>
                    <p>Subscribers notified: {$count}</p>
                </div>
            ";
            $mail->AltBody = 'New product added: ' . $product['name'] . ' (notified ' . $count . ' subscribers).';
            $mail->send();
        } catch (Exception $e) {
            error_log('Admin product alert mail error: ' . $mail->ErrorInfo);
        }
    }

    private function sendStockAlertMail($product, $remainingQty, $type)
    {
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

            $mail->setFrom(MAIL_FROM_ADDRESS, 'StitchSmart Stock Alert');
            $mail->addAddress(MAIL_FROM_ADDRESS);
            $mail->isHTML(true);

            $productName   = htmlspecialchars($product['name'] ?? '');
            $articleNumber = htmlspecialchars($product['article_number'] ?? '');
            $productId     = (int)($product['id'] ?? 0);
            $productPrice  = number_format((float)($product['price'] ?? 0));

            if ($type === 'out_of_stock') {
                $mail->Subject = 'Out of Stock (Admin Update): ' . $productName;
                $badgeStyle    = 'background-color: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.3);';
                $badgeText     = 'OUT OF STOCK — ADMIN UPDATE';
                $headingColor  = '#dc3545';
                $stockColor    = '#dc3545';
                $stockText     = '0 Units';
                $bodyText      = 'The following product has been manually set to <strong>Out of Stock</strong> via the Admin Dashboard.';
            } else {
                $mail->Subject = 'Low Stock Warning (Admin Update): ' . $productName;
                $badgeStyle    = 'background-color: rgba(205, 154, 72, 0.15); color: #c19a4e; border: 1px solid rgba(193, 154, 78, 0.4);';
                $badgeText     = 'LOW STOCK WARNING — ADMIN UPDATE';
                $headingColor  = '#c19a4e';
                $stockColor    = '#c19a4e';
                $stockText     = $remainingQty . ' Units';
                $bodyText      = 'The following product has been manually updated to a <strong>Low Stock</strong> level (&le; 10 units) via the Admin Dashboard.';
            }

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
                            <span style='display: inline-block; {$badgeStyle} padding: 8px 16px; border-radius: 50px; font-weight: bold; font-size: 13px; letter-spacing: 1px;'>
                                {$badgeText}
                            </span>
                        </div>

                        <h2 style='color: #1a1a1a; margin-top: 0; font-size: 20px;'>Hello Admin,</h2>
                        <p style='font-size: 16px; line-height: 1.6; color: #5c4335;'>{$bodyText}</p>

                        <div style='background-color: #fcf8f2; border: 1px solid rgba(193, 154, 78, 0.3); border-radius: 8px; padding: 25px; margin: 30px 0;'>
                            <table style='width: 100%; border-collapse: collapse;'>
                                <tr>
                                    <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600; width: 40%;'>Product Name</td>
                                    <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>{$productName}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600;'>Article Number</td>
                                    <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>{$articleNumber}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600;'>Product ID</td>
                                    <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>{$productId}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #7a6253; font-weight: 600;'>Price</td>
                                    <td style='padding: 10px 0; border-bottom: 1px solid rgba(193, 154, 78, 0.15); color: #1a1a1a; font-weight: 700; text-align: right;'>Rs. {$productPrice}</td>
                                </tr>
                                <tr>
                                    <td style='padding: 15px 0 5px 0; color: #7a6253; font-weight: 600;'>Updated Stock</td>
                                    <td style='padding: 15px 0 5px 0; color: {$stockColor}; font-weight: bold; text-align: right; font-size: 18px;'>{$stockText}</td>
                                </tr>
                            </table>
                        </div>

                        <p style='font-size: 15px; line-height: 1.6; color: #5c4335;'>
                            This alert was triggered by a manual inventory update from the Admin Panel.
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
            error_log('Admin Stock Alert Mail Error: ' . $mail->ErrorInfo);
        }
    }

    // delete product
    public function delete(){

        if(isset($_GET['id'])){

            $id=$_GET['id'];

            $this->productModel->deleteProduct($id);

            ApiService::syncProduct();

            header("Location: ".url("") . "admin_products");
        }
    }

}
