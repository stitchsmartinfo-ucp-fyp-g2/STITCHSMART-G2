<?php

require_once BASE_PATH.'/config/database.php';
require_once BASE_PATH.'/app/models/settings.php';
require_once BASE_PATH.'/app/models/Product.php';
require_once BASE_PATH.'/app/models/ad_category.php';
require_once BASE_PATH.'/app/models/SchemaBootstrap.php';

require_once BASE_PATH . '/app/libraries/PHPMailer/src/Exception.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/PHPMailer.php';
require_once BASE_PATH . '/app/libraries/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ProductController {

    private $productModel;
    private $categoryModel;

    public function __construct(){
        $database = new Database();
        $db = $database->connect();

        $this->productModel = new Product($db);
        $this->categoryModel = new Category($db);
    }

    private function resolveRedirectUrl(string $redirectTo, int $productId): string
    {
        $defaultRedirect = url("product_show?id=" . $productId);

        if ($redirectTo === '') {
            return $defaultRedirect;
        }

        $safeRedirect = preg_replace('/[^A-Za-z0-9_=&?\-\/\.]/', '', $redirectTo);

        if ($safeRedirect === '') {
            return $defaultRedirect;
        }

        return url($safeRedirect);
    }

    
private function loadWebSettings() {
    $settingsModel = new Settings();
    $ws = $settingsModel->getWebSettings();
    return $ws;
}

public function index() {
    $search = isset($_GET['search']) ? trim((string)$_GET['search']) : null;
    $sort = isset($_GET['sort']) ? trim((string)$_GET['sort']) : null;
    $category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;

    $allowedSorts = ['low', 'high', 'stock'];
    if (!in_array($sort, $allowedSorts, true)) {
        $sort = null;
    }

    // Web settings
    $ws = $this->loadWebSettings();
    $webname = $ws['web_name'] ?? '';
    $webcontact = $ws['web_contact'] ?? '';
    $webmail = $ws['web_mail'] ?? '';
    $facebook = $ws['facebook'] ?? '';
    $instagram = $ws['instagram'] ?? '';
    $pinterest = $ws['pinterest'] ?? '';
    $linkdin = $ws['linkdin'] ?? '';
    $meta_description = $ws['meta_description'] ?? '';
    $global_theme = $ws['theme'] ?? 'theme-luxury';

    $category_name = null; 

    // Fetch products & save search for AI
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    if ($search) {
        $products = $this->productModel->searchProducts($search, $sort);
        $searchUserId = $_SESSION['customer_id'] ?? null;
        if ($searchUserId) {
            $this->productModel->logUserSearch($searchUserId, $search);
        }
    } elseif ($category_id) {
        $products = $this->productModel->getProductsByCategory($category_id);

        // Fetch category name safely
        $category = $this->categoryModel->getCategoryById($category_id);
        $category_name = $category['c_name'] ?? null;
    } else {
        $products = $this->productModel->getAllProducts();
    }

    $wishlistedProductIds = [];
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $customerId = $_SESSION['customer_id'] ?? null;
    if ($customerId) {
        $wishlistBootstrap = new SchemaBootstrap((new Database())->connect());
        $wishlistedProductIds = $wishlistBootstrap->getWishlistProductIdsForUser((int)$customerId);
    }

    // Total products
    $total_products = count($products);

    // Related products: only for single-product pages (don't mix here)
    $related_products = []; // leave empty for products listing

    // Categories for sidebar/filter
    $categories = $this->categoryModel->getCategoriesTree();

    // Load products view
    require BASE_PATH . '/app/views/User/products.php';
}
public function liveSearch(){

    $keyword = trim((string)($_GET['q'] ?? ''));
    $keyword = mb_substr($keyword, 0, 100);

    // Save search for logged-in users (AI tracking)
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $userId = $_SESSION['customer_id'] ?? null;
    
    // DEBUG LOG
    file_put_contents(BASE_PATH . '/search_debug.txt', date('Y-m-d H:i:s') . " - liveSearch called: keyword='$keyword', userId=" . var_export($userId, true) . ", SESSION=" . var_export($_SESSION, true) . "\n", FILE_APPEND);

    if ($userId && trim($keyword) !== '') {
        $this->productModel->logUserSearch((int)$userId, $keyword);
        file_put_contents(BASE_PATH . '/search_debug.txt', "Saved to DB: " . $this->productModel->conn->error . "\n", FILE_APPEND);
    }

    // Search for products
    $products = $this->productModel->searchProducts($keyword, null);

    $results = [];

    foreach($products as $p){
        $imgList = array_filter(array_map('trim', explode(',', $p['image_url'] ?? '')));
        $firstImg = !empty($imgList) ? ltrim(reset($imgList), '/') : 'pictures/default.png';
        $results[] = [
            'id' => $p['id'],
            'name' => $p['name'],
            'image' => $firstImg,
            'price' => $p['price'] ?? 0,
            'type' => 'product'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($results);
    exit;
}
public function show(){
    // Load web settings
    $ws = $this->loadWebSettings();
    $webname = $ws['web_name'] ?? ''; 
    $webcontact = $ws['web_contact'] ?? ''; 
    $webmail = $ws['web_mail'] ?? '';
    $facebook = $ws['facebook'] ?? ''; 
    $instagram = $ws['instagram'] ?? ''; 
    $pinterest = $ws['pinterest'] ?? ''; 
    $linkdin = $ws['linkdin'] ?? '';
    $meta_description = $ws['meta_description'] ?? '';
    $global_theme = $ws['theme'] ?? 'theme-luxury';

    // Categories for sidebar/menu
    $categories = $this->categoryModel->getCategoriesTree();

    // Get product ID from URL
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if($id <= 0){
        header("Location: " . url("") . "products");
        exit;
    }

    // Fetch single product (by ID first, fallback to article number)
    $product = $this->productModel->getProductById($id);
    if(!$product){
        $product = $this->productModel->getProductByArticleNumber($id);
    }
    if(!$product){
        // Provide a user-friendly error instead of abruptly dying
        require BASE_PATH . '/app/views/User/header.php';
        echo "<div style='text-align:center; padding:100px 20px; min-height: 50vh;'>";
        echo "<h2 style='color: var(--chat-text-main); font-size: 2em; margin-bottom: 20px;'>Product Not Found</h2>";
        echo "<p style='color: #4a5568;'>Sorry, the product you are looking for has been removed or is no longer available.</p>";
        echo "<a href='".url("") . "products' style='display:inline-block; margin-top:30px; padding:12px 24px; background:var(--chat-accent, #1a0f0a); color:#fff; text-decoration:none; border-radius:30px; font-weight: bold; transition: 0.3s;'>Return to Shop</a>";
        echo "</div>";
        require BASE_PATH . '/app/views/User/footer.php';
        exit;
    }

    if ((int)$product['quantity'] <= 0) {
        $this->sendRestockRequestMail($product);
    }

    // Log the product click (view) for AI recommendations
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $clickUserId = $_SESSION['customer_id'] ?? null;
    if ($clickUserId) {
        $this->productModel->logProductView($clickUserId, $product['id']);
    }

    // Get category name
    $category = $this->categoryModel->getCategoryById($product['parent_cat']);
    $category_name = $category['c_name'] ?? 'Unknown Category';

    // Fetch related products: AI-based using search history/clicks if logged in
    $related_products = [];
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $userId = $_SESSION['customer_id'] ?? null;
    
    if ($userId) {
        $related_products = $this->productModel->getAiRecommendedProducts($userId, $product['id'], $product['parent_cat'], 4);
        
        // If we have fewer than 4 items, backfill with products from the same category
        if (count($related_products) < 4) {
            $existing_ids = array_map(function($p) { return (int)$p['id']; }, $related_products);
            $existing_ids[] = (int)$product['id'];
            
            $cat_related = $this->productModel->getRelatedProducts($product['parent_cat'], $product['id'], 10);
            foreach ($cat_related as $cp) {
                if (count($related_products) >= 4) break;
                if (!in_array((int)$cp['id'], $existing_ids)) {
                    $related_products[] = $cp;
                    $existing_ids[] = (int)$cp['id'];
                }
            }
        }

        // If STILL fewer than 4 items (because category has few items), universal backfill from all categories
        if (count($related_products) < 4) {
            $existing_ids = array_map(function($p) { return (int)$p['id']; }, $related_products);
            $existing_ids[] = (int)$product['id'];
            
            $needed = 4 - count($related_products);
            $fallback_items = $this->productModel->getFallbackProducts($existing_ids, $needed);
            foreach ($fallback_items as $fp) {
                $related_products[] = $fp;
            }
        }
    }

    // Review data
    $reviews = $this->productModel->getProductReviews($product['id']);
    $reviewSummary = $this->productModel->getProductReviewSummary($product['id']);

    $canReview = false;
    $reviewNotice = null;
    $isWishlisted = false;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $userId = $_SESSION['customer_id'] ?? null;
    if ($userId) {
        $wishlistBootstrap = new SchemaBootstrap((new Database())->connect());
        $isWishlisted = $wishlistBootstrap->isWishlisted((int)$userId, (int)$product['id']);

        $purchased = $this->productModel->userHasPurchasedProduct($userId, $product['id']);
        $alreadyReviewed = $this->productModel->userHasReviewedProduct($userId, $product['id']);
        if ($purchased && !$alreadyReviewed) {
            $canReview = true;
        } elseif (!$purchased) {
            $reviewNotice = "Only customers who purchased this product can leave a review.";
        } else {
            $reviewNotice = "You have already submitted a review for this product.";
        }
    }

    // Load single product view
    require BASE_PATH . '/app/views/User/single-product.php';
}

public function toggleWishlist()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . url("") . "home");
        exit;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION['customer_id'] ?? null;
    if (empty($userId)) {
        $_SESSION['wishlist_error'] = "Please login to save products to your wishlist.";
        header("Location: " . url("") . "customer_login");
        exit;
    }

    $submittedToken = $_POST['csrf_token'] ?? '';
    $productId = (int)($_POST['product_id'] ?? 0);
    $redirectTo = trim((string)($_POST['redirect_to'] ?? ''));

    if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['wishlist_error'] = "Security token expired. The page refreshed; please try again.";
        $redirectUrl = $this->resolveRedirectUrl($redirectTo, $productId);
        header("Location: " . $redirectUrl);
        exit;
    }

    if ($productId <= 0) {
        $_SESSION['wishlist_error'] = "Invalid product selected.";
        header("Location: " . url("") . "home");
        exit;
    }

    $database = new Database();
    $db = $database->connect();
    $wishlistBootstrap = new SchemaBootstrap($db);

    $isWishlisted = $wishlistBootstrap->isWishlisted((int)$userId, $productId);
    if ($isWishlisted) {
        $wishlistBootstrap->removeWishlistItem((int)$userId, $productId);
        $_SESSION['wishlist_success'] = "Product removed from your wishlist.";
    } else {
        $wishlistBootstrap->addWishlistItem((int)$userId, $productId);
        $_SESSION['wishlist_success'] = "Product added to your wishlist.";
    }

    $redirectUrl = $this->resolveRedirectUrl($redirectTo, $productId);

    header("Location: " . $redirectUrl);
    exit;
}

public function customerWishlist()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION['customer_id'] ?? null;
    if (!$userId) {
        $_SESSION['wishlist_error'] = "Please login to view your wishlist.";
        header("Location: " . url("") . "customer_login");
        exit;
    }

    // Web settings
    $ws = $this->loadWebSettings();
    $webname = $ws['web_name'] ?? '';
    $webcontact = $ws['web_contact'] ?? '';
    $webmail = $ws['web_mail'] ?? '';
    $facebook = $ws['facebook'] ?? '';
    $instagram = $ws['instagram'] ?? '';
    $pinterest = $ws['pinterest'] ?? '';
    $linkdin = $ws['linkdin'] ?? '';
    $meta_description = $ws['meta_description'] ?? '';
    $global_theme = $ws['theme'] ?? 'theme-luxury';

    $database = new Database();
    $conn = $database->connect();
    $schemaBootstrap = new SchemaBootstrap($conn);
    $wishlistEntries = $schemaBootstrap->getWishlistEntriesForUser((int)$userId);

    require BASE_PATH . '/app/views/User/customer_wishlist.php';
}

public function compare()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $ws = $this->loadWebSettings();
    $webname = $ws['web_name'] ?? '';
    $webcontact = $ws['web_contact'] ?? '';
    $webmail = $ws['web_mail'] ?? '';
    $facebook = $ws['facebook'] ?? '';
    $instagram = $ws['instagram'] ?? '';
    $pinterest = $ws['pinterest'] ?? '';
    $linkdin = $ws['linkdin'] ?? '';
    $meta_description = $ws['meta_description'] ?? '';
    $global_theme = $ws['theme'] ?? 'theme-luxury';

    $categoriesResult = $this->categoryModel->getAllCategories();
    $categories = [];
    while ($row = $categoriesResult->fetch_assoc()) {
        $categories[] = $row;
    }

    $categoryProducts = [];
    $db = (new Database())->connect();

    foreach ($categories as $category) {
        // Collect current category and child subcategories recursively (1 level down)
        $catIds = [$category['c_id']];
        foreach ($categories as $sub) {
            if ($sub['parent_id'] == $category['c_id']) {
                $catIds[] = $sub['c_id'];
            }
        }
        
        $inClause = implode(',', array_map('intval', $catIds));
        
        // Fetch all products under this category branch along with average review rating & count
        $query = "SELECT p.*, 
                         c.c_name AS category_name,
                         c.parent_id AS category_parent_id,
                         parent_c.c_name AS main_category_name,
                         IFNULL(ROUND(pr.average_rating, 1), 0) AS rating,
                         IFNULL(pr.review_count, 0) AS review_count
                  FROM product p
                  LEFT JOIN category c ON p.parent_cat = c.c_id
                  LEFT JOIN category parent_c ON c.parent_id = parent_c.c_id AND c.parent_id != 0 AND c.parent_id != c.c_id
                  LEFT JOIN (
                      SELECT product_id, AVG(rating) AS average_rating, COUNT(*) AS review_count
                      FROM product_reviews
                      GROUP BY product_id
                  ) pr ON p.id = pr.product_id
                  WHERE p.parent_cat IN ($inClause) 
                  ORDER BY p.id ASC";
                  
        $res = $db->query($query);
        $products = [];
        if ($res) {
            while ($pRow = $res->fetch_assoc()) {
                if (!empty($pRow['main_category_name']) && !empty($pRow['category_name']) && $pRow['main_category_name'] !== $pRow['category_name']) {
                    $pRow['category_display_name'] = $pRow['main_category_name'] . ' / ' . $pRow['category_name'];
                } elseif (!empty($pRow['category_name'])) {
                    $pRow['category_display_name'] = $pRow['category_name'];
                } else {
                    $pRow['category_display_name'] = null;
                }
                $products[] = $pRow;
            }
        }
        $categoryProducts[$category['c_id']] = $products;
    }

    $selectedCategoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
    $selectedProductA = isset($_GET['productA']) ? (int)$_GET['productA'] : null;
    $selectedProductB = isset($_GET['productB']) ? (int)$_GET['productB'] : null;

    if (!$selectedCategoryId && $selectedProductA) {
        $productA = $this->productModel->getProductById($selectedProductA);
        if ($productA) {
            $selectedCategoryId = isset($productA['parent_cat']) ? (int)$productA['parent_cat'] : null;
        }
    }

    if (!$selectedCategoryId && $selectedProductB) {
        $productB = $this->productModel->getProductById($selectedProductB);
        if ($productB) {
            $selectedCategoryId = isset($productB['parent_cat']) ? (int)$productB['parent_cat'] : null;
        }
    }

    require BASE_PATH . '/app/views/User/product_compare.php';
}

public function saveReview()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: " . url("") . "home");
        exit;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_SESSION['customer_id'] ?? null;
    if (empty($userId)) {
        $_SESSION['review_error'] = "Please login to submit a product review.";
        header("Location: " . url("") . "customer_login");
        exit;
    }

    $submittedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $_SESSION['review_error'] = "Invalid security token. Please refresh the page and try again.";
        header("Location: " . url("product_show?id=" . (int)($_POST['product_id'] ?? 0)));
        exit;
    }

    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $comment = trim(strip_tags((string)($_POST['comment'] ?? '')));
    $comment = mb_substr($comment, 0, 1000);

    if ($productId <= 0 || $rating < 1 || $rating > 5 || $comment === '') {
        $_SESSION['review_error'] = "Please provide a valid rating and comment.";
        header("Location: " . url("product_show?id=" . $productId));
        exit;
    }

    if (!$this->productModel->userHasPurchasedProduct($userId, $productId)) {
        $_SESSION['review_error'] = "Only customers who bought this product can submit a review.";
        header("Location: " . url("product_show?id=" . $productId));
        exit;
    }

    if ($this->productModel->userHasReviewedProduct($userId, $productId)) {
        $_SESSION['review_error'] = "You have already submitted a review for this product.";
        header("Location: " . url("product_show?id=" . $productId));
        exit;
    }

    if ($this->productModel->addProductReview($userId, $productId, $rating, $comment)) {
        $_SESSION['review_success'] = "Thank you! Your review has been submitted.";
    } else {
        $_SESSION['review_error'] = "Unable to save your review. Please try again later.";
    }

    header("Location: " . url("product_show?id=" . $productId));
    exit;
}

public function quickRate()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $userId = $_SESSION['customer_id'] ?? 0;

    if ($userId <= 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Please log in to leave a review.']);
        exit;
    }

    if ($productId <= 0 || $rating < 1 || $rating > 5) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit;
    }

    if (!$this->productModel->userHasPurchasedProduct($userId, $productId)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'You must purchase this product and have it delivered to submit a rating.']);
        exit;
    }

    if ($this->productModel->userHasReviewedProduct($userId, $productId)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'You have already reviewed this product.']);
        exit;
    }

    if ($this->productModel->addProductReview($userId, $productId, $rating, "Quick Rating")) {
        $summary = $this->productModel->getProductReviewSummary($productId);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'average' => $summary['average'],
            'count' => $summary['count']
        ]);
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Failed to save rating.']);
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
        <div style='font-family:Arial;padding:20px;line-height:1.6;'>
            <h2 style='color:#c52c1e;'>Inventory Alert: Out of Stock ⚠️</h2>
            <p>Hello Admin,</p>
            <p>The following product has been flagged as <strong>Out of Stock</strong> because a user attempted to view or purchase it:</p>
            <table style='width:100%;border-collapse:collapse;margin-top:15px;margin-bottom:15px;'>
                <tr style='background:#f9f9f9;'>
                    <td style='padding:8px;border:1px solid #ddd;font-weight:bold;width:150px;'>Product Name:</td>
                    <td style='padding:8px;border:1px solid #ddd;'>{$product['name']}</td>
                </tr>
                <tr>
                    <td style='padding:8px;border:1px solid #ddd;font-weight:bold;'>Article Number:</td>
                    <td style='padding:8px;border:1px solid #ddd;'>{$product['article_number']}</td>
                </tr>
                <tr style='background:#f9f9f9;'>
                    <td style='padding:8px;border:1px solid #ddd;font-weight:bold;'>Product ID:</td>
                    <td style='padding:8px;border:1px solid #ddd;'>{$product['id']}</td>
                </tr>
                <tr>
                    <td style='padding:8px;border:1px solid #ddd;font-weight:bold;'>Price:</td>
                    <td style='padding:8px;border:1px solid #ddd;'>Rs. " . number_format($product['price']) . "</td>
                </tr>
                <tr style='background:#f9f9f9;'>
                    <td style='padding:8px;border:1px solid #ddd;font-weight:bold;'>Sizes Configured:</td>
                    <td style='padding:8px;border:1px solid #ddd;'>{$product['size']}</td>
                </tr>
            </table>
            <p>Please log in to the Admin Dashboard and restock this item as soon as possible to avoid losing potential sales.</p>
            <hr style='border:none;border-top:1px solid #eee;margin-top:20px;margin-bottom:20px;'>
            <p style='font-size:11px;color:#999;'>Stitch Smart Automatic Inventory System</p>
        </div>
        ";

        $mail->send();
        $_SESSION['notified_restock'][$product['id']] = true;
    } catch (Exception $e) {
        error_log('Restock Request Mail Error: ' . $mail->ErrorInfo);
    }
}
public function getProductById($id){

    $stmt = $this->conn->prepare("SELECT * FROM product WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}
}
