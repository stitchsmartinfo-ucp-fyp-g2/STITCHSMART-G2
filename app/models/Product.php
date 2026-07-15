<?php
require_once __DIR__ . '/../../config/database.php';
class Product {

    public $conn;
    private $table = "product";

    public function __construct($db){
        $this->conn = $db;
    }


  public function getCategories($parent_id = 0){
    $stmt = $this->conn->prepare(
        "SELECT * FROM category WHERE parent_id=? ORDER BY c_name ASC"
    );
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $categories = [];
    while($row = $result->fetch_assoc()){
        // recursively get children
        $row['children'] = $this->getCategories($row['c_id']);
        $categories[] = $row;
    }
    return $categories;
}

    // get child categories
    public function getSubCategories($parent_id){

        $stmt = $this->conn->prepare(
            "SELECT * FROM category WHERE parent_id=? ORDER BY c_name ASC"
        );

        $stmt->bind_param("i",$parent_id);
        $stmt->execute();

        $result = $stmt->get_result();

        $cats = [];

        while($row = $result->fetch_assoc()){
            $cats[] = $row;
        }

        return $cats;
    }

   
// Auto fix sizes if quantity > 0 but sizes sum to 0
public function autoFixProductSizes(&$product) {
    if (!$product || !isset($product['quantity'])) return;
    $q = (int)$product['quantity'];
    if ($q > 0) {
        $size_str = $product['size'] ?? '';
        $sum = 0;
        if (preg_match_all('/(XS|S|L|XL):\s*(\d+)/i', $size_str, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $sum += (int)$match[2];
            }
        }
        if ($sum === 0 || empty(trim($size_str))) {
            $xs = (int)floor($q / 4);
            $s = (int)floor($q / 4);
            $l = (int)floor($q / 4);
            $xl = $q - ($xs + $s + $l);
            $new_size = "XS:{$xs}, S:{$s}, L:{$l}, XL:{$xl}";
            $product['size'] = $new_size;
            if (isset($product['id'])) {
                $id = (int)$product['id'];
                $up_stmt = $this->conn->prepare("UPDATE product SET size=? WHERE id=?");
                if ($up_stmt) {
                    $up_stmt->bind_param("si", $new_size, $id);
                    $up_stmt->execute();
                }
            }
        }
    }
}

// Auto fix SEO details according to SEO best practices if missing or generic
public function autoFixProductSEO(&$product) {
    if (!$product || !isset($product['name'])) return;
    $name = trim((string)$product['name']);
    $desc = trim(strip_tags((string)($product['description'] ?? '')));
    if (empty($product['meta_title']) || $product['meta_title'] === '0') {
        $product['meta_title'] = $name . ' | Buy Online at Stitch Smart';
    }
    if (empty($product['meta_description']) || $product['meta_description'] === '0') {
        $product['meta_description'] = mb_substr($desc !== '' ? $desc : ($name . ' - Premium quality fashion apparel crafted with care.'), 0, 160);
    }
    if (empty($product['meta_keywords']) || $product['meta_keywords'] === '0' || $product['meta_keywords'] === 'quality, design, trending, fashion, premium') {
        $cleanWords = array_filter(array_map('trim', explode(' ', preg_replace('/[^a-zA-Z0-9\s]/', '', $name))));
        $keywords = array_unique(array_merge($cleanWords, ['fashion', 'apparel', 'Stitch Smart', 'online shopping', 'Pakistan']));
        $product['meta_keywords'] = implode(', ', array_slice($keywords, 0, 8));
    }
    if (empty($product['slug'])) {
        $product['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    }
}

public function fixAllZeroSizesInDB() {
    $res = $this->conn->query("SELECT id, quantity, size FROM product WHERE quantity > 0");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $this->autoFixProductSizes($row);
        }
    }
}

// Auto fix images by filtering out paths that do not exist on disk
public function autoFixProductImages(&$product) {
    if (!$product || empty($product['image_url'])) return;
    
    $images = explode(',', $product['image_url']);
    $validImages = [];
    $changed = false;
    $basePath = defined('BASE_PATH') ? BASE_PATH : dirname(dirname(__DIR__));
    
    foreach ($images as $img) {
        $img = trim($img);
        if (empty($img)) {
            $changed = true;
            continue;
        }
        $fullPath = $basePath . '/public/' . $img;
        if (file_exists($fullPath)) {
            $validImages[] = $img;
        } else {
            $changed = true;
        }
    }
    
    if ($changed) {
        if (empty($validImages)) {
            $cleanImages = array_filter(array_map('trim', $images));
            $new_image_url = !empty($cleanImages) ? reset($cleanImages) : '';
        } else {
            $new_image_url = implode(',', $validImages);
        }
        
        $product['image_url'] = $new_image_url;
        
        if (isset($product['id'])) {
            $id = (int)$product['id'];
            $up_stmt = $this->conn->prepare("UPDATE product SET image_url=? WHERE id=?");
            if ($up_stmt) {
                $up_stmt->bind_param("si", $new_image_url, $id);
                $up_stmt->execute();
            }
        }
    }
}

// get single product
public function getProductById($id){
    $stmt = $this->conn->prepare("SELECT * FROM product WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $this->autoFixProductSizes($product);
    $this->autoFixProductSEO($product);
    $this->autoFixProductImages($product);
    return $product;
}
//get product by categories
public function getProductsByCategory($category_id){

    $stmt = $this->conn->prepare(
        "SELECT * FROM product WHERE parent_cat=? ORDER BY id ASC"
    );

    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}
public function getCategoryName($category_id){

    $stmt = $this->conn->prepare(
        "SELECT c_name FROM category WHERE c_id = ?"
    );

    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
        return $row['c_name'];
    }

    return null;
}
// update product
public function updateProduct($data){
    $stmt = $this->conn->prepare("
        UPDATE product SET
        article_number=?, name=?, description=?, details=?, image_url=?, size=?, price=?, parent_cat=?,
        meta_title=?, meta_description=?, meta_keywords=?, slug=?, quantity=?
        WHERE id=?
    ");
    $stmt->bind_param(
        "sssssssissssii",
        $data['article_number'],
        $data['name'],
        $data['description'],
        $data['details'],
        $data['image_url'],
        $data['size'],
        $data['price'],
        $data['parent_cat'],
        $data['meta_title'],
        $data['meta_description'],
        $data['meta_keywords'],
       
        $data['slug'],
        $data['quantity'],
        $data['id']
    );
    ApiService::syncProduct($data);
    return $stmt->execute();

}

public function createProduct($data){
    $stmt = $this->conn->prepare("
        INSERT INTO product
        (article_number,Fabric_Type, name, description, details, image_url, img2, img3, document, size, price, parent_cat,
        meta_title, meta_description, meta_keywords,  slug, Designing, quantity)
        VALUES (?, ?, ?, ?, ?, ?, '', '', '', ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if(!$stmt){
        die("Prepare failed: " . $this->conn->error);
    }

    // Bind parameters (s = string, i = int)
    $stmt->bind_param(
        "sssssssssissssi",
        $data['article_number'],
         $data['Fabric_Type'],
        $data['name'],
        $data['description'],
        $data['details'],
        $data['image_url'],
        $data['size'],
        $data['price'],
        $data['parent_cat'],
        $data['meta_title'],
        $data['meta_description'],
        $data['meta_keywords'],
       
        $data['slug'],
         $data['Designing'],
          $data['quantity']
    );

    return $stmt->execute();
}

public function isArticleNumberUnique($article_number) {
    $stmt = $this->conn->prepare("SELECT id FROM product WHERE article_number = ? LIMIT 1");
    $stmt->bind_param("s", $article_number);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows === 0;
}
public function toggleFeatured($id, $status)
{
    $stmt = $this->conn->prepare("
        UPDATE product 
        SET featured = ? 
        WHERE id = ?
    ");

    $stmt->bind_param("ii", $status, $id);
    return $stmt->execute();
}

private function ensureSaleDiscountColumnExists()
{
    $check = $this->conn->query("SHOW COLUMNS FROM product LIKE 'sale_discount_percent'");

    if ($check && $check->num_rows === 0) {
        $this->conn->query("ALTER TABLE product ADD COLUMN sale_discount_percent INT NOT NULL DEFAULT 20 AFTER featured");
    }
}

public function setSaleDiscount($id, $discountPercent)
{
    $this->ensureSaleDiscountColumnExists();

    $stmt = $this->conn->prepare("
        UPDATE product
        SET sale_discount_percent = ?
        WHERE id = ?
    ");

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("ii", $discountPercent, $id);
    return $stmt->execute();
}
public function getProductsOnSale()
{
    $this->ensureSaleDiscountColumnExists();

    $stmt = $this->conn->prepare(
        "SELECT * FROM product WHERE sale_discount_percent > 0 AND (featured IS NULL OR featured = 0) ORDER BY id DESC"
    );
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}

public function getSaleProductsCount()
{
    $this->ensureSaleDiscountColumnExists();

    $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM product WHERE sale_discount_percent > 0 AND (featured IS NULL OR featured = 0)");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'] ?? 0;
}

public function getSaleProductsPaginated($limit, $offset)
{
    $this->ensureSaleDiscountColumnExists();

    $stmt = $this->conn->prepare(
        "SELECT * FROM product WHERE sale_discount_percent > 0 AND (featured IS NULL OR featured = 0) ORDER BY id DESC LIMIT ? OFFSET ?"
    );
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}

public function getProductsNotOnSale()
{
    $this->ensureSaleDiscountColumnExists();

    // Show products that are NOT actively on sale (discount <= 5% or NULL)
    $stmt = $this->conn->prepare(
        "SELECT * FROM product WHERE (sale_discount_percent IS NULL OR sale_discount_percent <= 5) ORDER BY id DESC"
    );
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}

public function getFeaturedProducts($limit, $offset){

    $stmt = $this->conn->prepare(
        "SELECT * FROM product WHERE featured = 1 AND (sale_discount_percent IS NULL OR sale_discount_percent = 0) ORDER BY id DESC LIMIT ? OFFSET ?"
    );

    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();

    $result = $stmt->get_result();

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}

private function resolveProductSort($sort, $defaultOrder = 'id ASC'){
    $sort = is_string($sort) ? strtolower(trim($sort)) : '';

    $allowedOrders = [
        'low' => 'price ASC',
        'high' => 'price DESC',
        'stock' => 'quantity DESC',
        'newest' => 'id DESC',
    ];

    if ($sort === '') {
        return $defaultOrder;
    }

    return $allowedOrders[$sort] ?? $defaultOrder;
}

public function getFeaturedProductsCount(){
    $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM product WHERE featured = 1 AND (sale_discount_percent IS NULL OR sale_discount_percent = 0)");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'];
}
    public function getAllProductsForAI(){

    $sql = "SELECT 
                p.id,
                p.article_number,
                p.name,
                p.description,
                p.details,
                p.price,
                p.size,
                p.image_url,
                p.Fabric_Type as fabric_type,
                p.Designing as designing,
                p.parent_cat,
                p.slug,
                p.quantity,
                c.c_name as category,
                c.c_id as category_id,
                IFNULL(ROUND(pr.average_rating, 1), 0) AS rating,
                IFNULL(pr.review_count, 0) AS review_count
            FROM product p
            INNER JOIN category c ON p.parent_cat = c.c_id AND c.c_id IS NOT NULL
            LEFT JOIN (
                SELECT product_id, AVG(rating) AS average_rating, COUNT(*) AS review_count
                FROM product_reviews
                GROUP BY product_id
            ) pr ON p.id = pr.product_id
            WHERE p.name != '' AND p.name IS NOT NULL
            AND p.price > 0
            AND c.c_name != '' AND c.c_name IS NOT NULL
            ORDER BY p.id ASC";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}

public function getAllProductsPaginated($limit, $offset){

    $stmt = $this->conn->prepare(
        "SELECT * FROM product ORDER BY id DESC LIMIT ? OFFSET ?"
    );

    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();

    $result = $stmt->get_result();

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}


public function getAllProductsCount(){
    $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM product");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total'];
}
public function getProductBySlug($slug){

    $stmt = $this->conn->prepare("SELECT id FROM product WHERE slug=? LIMIT 1");
    $stmt->bind_param("s", $slug);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}
    // delete product
public function deleteProduct($id){

    $stmt = $this->conn->prepare("DELETE FROM product WHERE id=?");
    $stmt->bind_param("i",$id);

    return $stmt->execute();
}
public function searchProducts($keyword, $sort = null){
    $order = $this->resolveProductSort($sort, 'id ASC');
    $kw = trim((string)$keyword);
    if ($kw === '') {
        return [];
    }

    $params = [];
    $types = "";

    if (mb_strlen($kw) <= 2) {
        $likes = [
            "p.name LIKE ?",
            "p.article_number LIKE ?",
            "p.meta_title LIKE ?",
            "p.meta_keywords LIKE ?",
            "c.c_name LIKE ?"
        ];
        $whereClause = implode(" OR ", $likes);
        
        $kwStart = $kw . "%";
        $kwContains = "%" . $kw . "%";
        
        // 5 WHERE params
        for ($i = 0; $i < 5; $i++) {
            $params[] = $kwContains;
            $types .= "s";
        }
        // 3 ORDER BY params for exact/prefix relevance
        $params[] = $kw;
        $params[] = $kwStart;
        $params[] = $kwStart;
        $types .= "sss";

        $sql = "SELECT DISTINCT p.* FROM product p 
                LEFT JOIN category c ON p.parent_cat = c.c_id 
                WHERE ($whereClause) 
                ORDER BY CASE 
                    WHEN p.name = ? THEN 1 
                    WHEN p.name LIKE ? THEN 2 
                    WHEN p.article_number LIKE ? THEN 3 
                    ELSE 4 
                END, p.$order LIMIT 30";
    } else {
        $words = explode(' ', $kw);
        $ai_keywords = [];
        foreach ($words as $w) {
            $w = trim($w);
            if (mb_strlen($w) >= 1) {
                $ai_keywords[] = $w;
            }
        }
        if (empty($ai_keywords)) {
            $ai_keywords = [$kw];
        }

        $likes = [];
        foreach ($ai_keywords as $term) {
            $likes[] = "(p.name LIKE ? OR p.description LIKE ? OR p.meta_title LIKE ? OR p.meta_keywords LIKE ? OR p.article_number LIKE ? OR c.c_name LIKE ?)";
            $termContains = "%" . $term . "%";
            for ($i = 0; $i < 6; $i++) {
                $params[] = $termContains;
                $types .= "s";
            }
        }
        $whereClause = implode(" OR ", $likes);

        // 3 ORDER BY params
        $params[] = $kw;
        $params[] = $kw . "%";
        $params[] = "%" . $kw . "%";
        $types .= "sss";

        $sql = "SELECT DISTINCT p.* FROM product p 
                LEFT JOIN category c ON p.parent_cat = c.c_id 
                WHERE ($whereClause) 
                ORDER BY CASE 
                    WHEN p.name = ? THEN 1 
                    WHEN p.name LIKE ? THEN 2 
                    WHEN p.name LIKE ? THEN 3 
                    ELSE 4 
                END, p.$order LIMIT 50";
    }

    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        error_log("Search prepare error: " . $this->conn->error);
        return [];
    }

    $stmt->bind_param($types, ...$params);
    $result_exec = $stmt->execute();
    if (!$result_exec) {
        error_log("Search execute error: " . $stmt->error);
        return [];
    }

    $result = $stmt->get_result();
    $products = [];
    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }
    return $products;
}
public function getAllProducts($sort = null){

    $order = $this->resolveProductSort($sort, 'id ASC');

    $stmt = $this->conn->prepare("SELECT * FROM product ORDER BY $order");
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];

    while($row = $result->fetch_assoc()){
        $products[] = $row;
    }

    return $products;
}
// Log user search query
public function logUserSearch($userId, $query) {
    if (empty(trim($query))) return;
    
    $res = $this->conn->query("SHOW TABLES LIKE 'user_searches'");
    if ($res && $res->num_rows === 0) {
        $this->conn->query("CREATE TABLE user_searches (
            id INT(11) NOT NULL AUTO_INCREMENT,
            user_id INT(11) NOT NULL,
            query VARCHAR(255) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY(id),
            KEY user_id_idx (user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }
    
    $stmt = $this->conn->prepare("INSERT INTO user_searches (user_id, query) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("is", $userId, $query);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $this->conn->commit();
    } else {
        throw new Exception("Prepare failed: " . $this->conn->error);
    }
}

// Log product clicks (views)
public function logProductView($userId, $productId) {
    if ($productId <= 0) return;
    
    $res = $this->conn->query("SHOW TABLES LIKE 'user_product_views'");
    if ($res && $res->num_rows === 0) {
        $this->conn->query("CREATE TABLE user_product_views (
            id INT(11) NOT NULL AUTO_INCREMENT,
            user_id INT(11) NOT NULL,
            product_id INT(11) NOT NULL,
            viewed_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY(id),
            KEY user_id_idx (user_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }
    
    $stmt = $this->conn->prepare("INSERT INTO user_product_views (user_id, product_id) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
    }
}

// Fetch AI recommended products based on user search history and clicks, restricted by category
public function getAiRecommendedProducts($userId, $exclude_id, $category_id = null, $limit = 4){
    // Ensure history tables exist just in case
    $this->logUserSearch($userId, 'init'); 
    $this->logProductView($userId, 0);
    
    $keywords = [];

    // 1. Get Keywords from Searches
    $stmt = $this->conn->prepare("SELECT query FROM user_searches WHERE user_id = ? AND query != 'init' ORDER BY id DESC LIMIT 5");
    if ($stmt) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $words = explode(' ', $row['query']);
            foreach ($words as $word) {
                $word = trim($word);
                if (strlen($word) > 2) $keywords[] = $word;
            }
        }
    }
    
    // 2. Get Keywords from Product Clicks (Views)
    $stmt2 = $this->conn->prepare("SELECT p.name, p.meta_keywords FROM user_product_views v JOIN product p ON v.product_id = p.id WHERE v.user_id = ? ORDER BY v.id DESC LIMIT 5");
    if ($stmt2) {
        $stmt2->bind_param("i", $userId);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        while ($row = $res2->fetch_assoc()) {
            // Extract from name
            $name_words = explode(' ', $row['name']);
            foreach ($name_words as $w) {
                $w = trim($w);
                if (strlen($w) > 3) $keywords[] = $w;
            }
            // Extract from tags
            if (!empty($row['meta_keywords'])) {
                $tags = is_string($row['meta_keywords']) ? json_decode($row['meta_keywords'], true) : [];
                if (!$tags) $tags = explode(',', $row['meta_keywords']);
                if (is_array($tags)) {
                    foreach ($tags as $t) {
                        $t = trim($t);
                        if (strlen($t) > 2) $keywords[] = $t;
                    }
                }
            }
        }
    }
    
    $keywords = array_unique($keywords);
    
    if (empty($keywords)) {
        return []; // No history or clicks, fallback
    }
    
    // Construct search query for AI-based recommendation
    $likes = [];
    $params = [];
    $types = "";
    
    foreach ($keywords as $kw) {
        $likes[] = "(name LIKE ? OR description LIKE ? OR details LIKE ?)";
        $params[] = "%" . $kw . "%";
        $params[] = "%" . $kw . "%";
        $params[] = "%" . $kw . "%";
        $types .= "sss";
    }
    
    $whereClause = implode(" OR ", $likes);
    
    $sql = "SELECT * FROM product WHERE ($whereClause) AND id != ?";
    $params[] = $exclude_id;
    $types .= "i";
    
    if ($category_id !== null) {
        $sql .= " AND parent_cat = ?";
        $params[] = $category_id;
        $types .= "i";
    }
    
    $sql .= " ORDER BY RAND() LIMIT ?";
    $params[] = $limit;
    $types .= "i";
    
    $stmt3 = $this->conn->prepare($sql);
    if (!$stmt3) return [];
    
    $stmt3->bind_param($types, ...$params);
    $stmt3->execute();
    $result = $stmt3->get_result();
    
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    
    return $products;
}

// Fetch related products
public function getRelatedProducts($category_id, $exclude_id, $limit = 4){
    $stmt = $this->conn->prepare(
        "SELECT * FROM product WHERE parent_cat=? AND id != ? ORDER BY RAND() LIMIT ?"
    );
    $stmt->bind_param("iii", $category_id, $exclude_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $related = [];
    while($row = $result->fetch_assoc()){
        $related[] = $row;
    }

    return $related;
}

// Fetch fallback products from across all categories to guarantee complete grid display
public function getFallbackProducts($exclude_ids = [], $limit = 4) {
    if (empty($exclude_ids)) {
        $exclude_ids = [0];
    }
    $placeholders = implode(',', array_fill(0, count($exclude_ids), '?'));
    $types = str_repeat('i', count($exclude_ids)) . 'i';
    $params = array_merge($exclude_ids, [$limit]);

    $stmt = $this->conn->prepare("SELECT * FROM product WHERE id NOT IN ($placeholders) ORDER BY RAND() LIMIT ?");
    if (!$stmt) return [];
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $fallback = [];
    while ($row = $result->fetch_assoc()) {
        $fallback[] = $row;
    }
    return $fallback;
}
    public function reduceStock($productId, $qty)
    {
        $stmt = $this->conn->prepare(
            "UPDATE product SET quantity = quantity - ? WHERE id = ? AND quantity >= ?"
        );

        $stmt->bind_param("iii", $qty, $productId, $qty);

        return $stmt->execute();
    }

    public function increaseStock($productId, $qty)
    {
        $stmt = $this->conn->prepare(
            "UPDATE product SET quantity = quantity + ? WHERE id = ?"
        );
        $stmt->bind_param("ii", $qty, $productId);
        return $stmt->execute();
    }

    public function getProductByArticleNumber($articleNumber) {
        $stmt = $this->conn->prepare("SELECT * FROM product WHERE article_number = ?");
        $stmt->bind_param("s", $articleNumber);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();
        if ($product) {
            $this->autoFixProductSizes($product);
            $this->autoFixProductSEO($product);
        }
        return $product;
    }

    private function ensureReviewTableExists() {
        $result = $this->conn->query("SHOW TABLES LIKE 'product_reviews'");
        if ($result && $result->num_rows === 0) {
            $this->conn->query("CREATE TABLE product_reviews (
                id INT(11) NOT NULL AUTO_INCREMENT,
                user_id INT(11) NOT NULL,
                product_id INT(11) NOT NULL,
                rating TINYINT(1) NOT NULL,
                comment TEXT,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                PRIMARY KEY(id),
                KEY idx_product_id (product_id),
                KEY idx_user_product (user_id, product_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
    }

    public function getProductReviews($productId) {
        $this->ensureReviewTableExists();
        $stmt = $this->conn->prepare(
            "SELECT pr.*, u.name AS reviewer_name
             FROM product_reviews pr
             LEFT JOIN users u ON u.id = pr.user_id
             WHERE pr.product_id = ?
             ORDER BY pr.created_at DESC"
        );
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        return $reviews;
    }

    public function getProductReviewSummary($productId) {
        $this->ensureReviewTableExists();
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) AS review_count, IFNULL(AVG(rating), 0) AS average_rating
             FROM product_reviews
             WHERE product_id = ?"
        );
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return [
            'count' => (int)$row['review_count'],
            'average' => round((float)$row['average_rating'], 1)
        ];
    }

    public function userHasReviewedProduct($userId, $productId) {
        $this->ensureReviewTableExists();
        $stmt = $this->conn->prepare(
            "SELECT id FROM product_reviews WHERE user_id = ? AND product_id = ? LIMIT 1"
        );
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function addProductReview($userId, $productId, $rating, $comment) {
        $this->ensureReviewTableExists();
        $stmt = $this->conn->prepare(
            "INSERT INTO product_reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iiis", $userId, $productId, $rating, $comment);
        return $stmt->execute();
    }

    public function userHasPurchasedProduct($userId, $productId) {
        $stmt = $this->conn->prepare(
            "SELECT oi.id
             FROM orders o
             INNER JOIN order_items oi ON o.id = oi.order_id
             WHERE o.user_id = ? AND oi.product_id = ? AND o.status = 'Delivered'
             LIMIT 1"
        );
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function getDeliveredProductIdsForUser($userId) {
        $stmt = $this->conn->prepare(
            "SELECT DISTINCT oi.product_id
             FROM orders o
             INNER JOIN order_items oi ON o.id = oi.order_id
             WHERE o.user_id = ? AND o.status = 'Delivered'"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $ids = [];
        while ($row = $result->fetch_assoc()) {
            $ids[] = (int)$row['product_id'];
        }
        return $ids;
    }

    public function getReviewedProductIdsForUser($userId) {
        $this->ensureReviewTableExists();
        $stmt = $this->conn->prepare(
            "SELECT DISTINCT product_id
             FROM product_reviews
             WHERE user_id = ?"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $ids = [];
        while ($row = $result->fetch_assoc()) {
            $ids[] = (int)$row['product_id'];
        }
        return $ids;
    }
}
