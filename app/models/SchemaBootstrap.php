<?php

class SchemaBootstrap
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
        try {
            $this->ensureInitialDatabaseImport();
            $this->ensureWishlistTableExists();
            $this->ensureEmailLogsTableExists();
            $this->ensureCartTableExists();
            $this->ensureJazzCashTableExists();
            $this->ensureCmsPagesExist();
        } catch (Throwable $e) {
            $msg = defined('APP_DEBUG') && APP_DEBUG
                ? 'Schema Bootstrap Exception: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine()
                : 'A database initialization error occurred. Please try again later.';
            die($msg);
        }
    }


    private function ensureInitialDatabaseImport(): void
    {
        $check = $this->conn->query("SHOW TABLES LIKE 'admin'");
        if ($check && $check->num_rows > 0) {
            return;
        }

        $sqlFiles = glob(__DIR__ . '/../../db/*.sql');
        if (empty($sqlFiles)) {
            $sqlFiles = glob(__DIR__ . '/../db/*.sql');
        }
        if (!empty($sqlFiles) && file_exists($sqlFiles[0])) {
            $sqlContent = file_get_contents($sqlFiles[0]);
            if ($sqlContent !== false && trim($sqlContent) !== '') {
                if ($this->conn->multi_query($sqlContent)) {
                    while ($this->conn->more_results() && $this->conn->next_result()) {
                        // flush multi_query results
                    }
                }
            }
        }
    }

    private function ensureCmsPagesExist(): void
    {
        $result = $this->conn->query("SHOW TABLES LIKE 'pages'");
        if (!$result || $result->num_rows === 0) {
            return;
        }
        $pages = [
            'about-us' => ['About Us', '<section class="container my-5"><h1>About Us</h1><p>Discover our mission to merge advanced technology with artisanal clothing craft, empowering you to design unique premium streetwear.</p></section>', 'About Stitch-Smart | Premium Personalized Streetwear', 'Discover our mission to merge advanced technology with artisanal clothing craft.', 'custom hoodies, design crewneck, customized clothing, streetwear brand'],
            'our-story' => ['Our Story', '<section class="container my-5"><h1>Our Story</h1><p>Stitch Smart brings quality craftsmanship, thoughtful design, and reliable delivery together for every customer.</p></section>', 'Our Story | Stitch Smart', 'Learn about the Stitch Smart story, values, and passion for custom apparel.', 'our story, Stitch Smart story, custom apparel, craftsmanship'],
            'how-to-order' => ['How to Order', '<section class="container my-5"><h1>How to Order</h1><p>Experiencing premium tailoring has never been easier. 1. Select your style, 2. Provide measurements, 3. Secure checkout, 4. Crafting & Delivery.</p></section>', 'How to Order | Stitch Smart Clothing', 'Learn how to easily place an order at Stitch Smart Clothing.', 'how to order online, shopping guide, place order clothing'],
            'shipping-and-delivery' => ['Shipping and Delivery', '<section class="container my-5"><h1>Shipping and Delivery</h1><p>Fast, reliable, and premium delivery services to ensure your tailored garments arrive in perfect condition, exactly when you expect them.</p></section>', 'Shipping & Delivery Policy | Stitch Smart Clothing', 'Explore Stitch Smart Clothing shipping and delivery policy.', 'shipping policy, delivery information, order shipping'],
            'payment-and-financing' => ['Payment & Financing', '<section class="container my-5"><h1>Payment & Financing</h1><p>Experience seamless, secure, and flexible payment options tailored for your convenience. Shop our premium collections with complete peace of mind.</p></section>', 'Payment & Financing | Stitch-Smart Secure Payments', 'Explore safe payment options including Credit/Debit card checkout.', 'easypaisa payment, secure clothing check, interest free installments'],
            'product-advice' => ['Product Advice', '<section class="container my-5"><h1>Expert Product Advice</h1><p>Make informed choices with our comprehensive guides. From finding the perfect fit to caring for premium fabrics, we are here to help you elevate your wardrobe.</p></section>', 'Product Advice & Sizing Guide | Stitch-Smart Clothing care', 'Expert advice on custom fits, fabric qualities, and maintenance tips.', 'clothing size guide, oversize hoodie wash, cotton fabric care'],
            'terms-and-condition' => ['Terms & Conditions', '<section class="container my-5"><h1>Terms & Conditions</h1><p>Welcome to Stitch Smart. By accessing our platform and placing an order, you agree to comply with our standard terms and conditions of service.</p></section>', 'Terms & Conditions | Stitch Smart', 'Read our standard terms and conditions.', 'terms and conditions, legal, service terms']
        ];
        foreach ($pages as $slug => $data) {
            $check = $this->conn->prepare("SELECT id FROM pages WHERE slug = ? LIMIT 1");
            if ($check) {
                $check->bind_param("s", $slug);
                $check->execute();
                $res = $check->get_result();
                if ($res->num_rows === 0) {
                    $ins = $this->conn->prepare("INSERT INTO pages (title, slug, content, meta_title, meta_description, meta_keywords, is_published, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 1, NOW(), NOW())");
                    if ($ins) {
                        $ins->bind_param("ssssss", $data[0], $slug, $data[1], $data[2], $data[3], $data[4]);
                        $ins->execute();
                        $ins->close();
                    }
                }
                $check->close();
            }
        }
    }

    private function ensureJazzCashTableExists(): void
    {
        $result = $this->conn->query("SHOW TABLES LIKE 'jazzcash_accounts'");
        if (!$result || $result->num_rows === 0) {
            $this->conn->query(
                "CREATE TABLE jazzcash_accounts (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    mobile VARCHAR(15) NOT NULL UNIQUE,
                    mpin VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
            );
        }
    }

    private function ensureWishlistTableExists(): void
    {
        $result = $this->conn->query("SHOW TABLES LIKE 'wishlists'");

        if (!$result || $result->num_rows === 0) {
            $this->conn->query(
                "CREATE TABLE wishlists (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT UNSIGNED NOT NULL,
                    product_id INT NOT NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    UNIQUE KEY uniq_user_product (user_id, product_id),
                    KEY idx_user_id (user_id),
                    KEY idx_product_id (product_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
            );
        }
    }

    private function ensureEmailLogsTableExists(): void
    {
        $result = $this->conn->query("SHOW TABLES LIKE 'email_logs'");

        if (!$result || $result->num_rows === 0) {
            $this->conn->query(
                "CREATE TABLE email_logs (
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    recipient_email VARCHAR(255) NOT NULL,
                    subject VARCHAR(255) NOT NULL,
                    template_name VARCHAR(100) DEFAULT NULL,
                    status ENUM('queued', 'sent', 'failed') NOT NULL DEFAULT 'queued',
                    error_message TEXT DEFAULT NULL,
                    sent_at DATETIME DEFAULT NULL,
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                    KEY idx_status_created (status, created_at),
                    KEY idx_recipient_email (recipient_email)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
            );
        }
    }

    private function ensureCartTableExists(): void
    {
        $result = $this->conn->query("SHOW TABLES LIKE 'cart_items'");

        if (!$result || $result->num_rows === 0) {
            $this->conn->query(
                "CREATE TABLE cart_items (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    user_id INT UNSIGNED NOT NULL,
                    product_id INT NOT NULL,
                    qty INT NOT NULL DEFAULT 1,
                    size VARCHAR(100) DEFAULT '',
                    fabric VARCHAR(100) DEFAULT '',
                    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    KEY idx_user_id (user_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;"
            );
        }
    }

    public function syncCartToDb(int $userId, array $cart): bool
    {
        $this->ensureCartTableExists();

        $stmtDel = $this->conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
        if (!$stmtDel) {
            return false;
        }
        $stmtDel->bind_param('i', $userId);
        $stmtDel->execute();
        $stmtDel->close();

        if (empty($cart)) {
            return true;
        }

        $stmtIns = $this->conn->prepare("INSERT INTO cart_items (user_id, product_id, qty, size, fabric) VALUES (?, ?, ?, ?, ?)");
        if (!$stmtIns) {
            return false;
        }

        foreach ($cart as $productId => $item) {
            $qty = (int)($item['qty'] ?? 1);
            $size = $item['size'] ?? '';
            $fabric = $item['fabric'] ?? '';
            $stmtIns->bind_param('iiiss', $userId, $productId, $qty, $size, $fabric);
            $stmtIns->execute();
        }
        $stmtIns->close();

        return true;
    }

    public function loadCartFromDb(int $userId): array
    {
        $this->ensureCartTableExists();

        $sql = "
            SELECT c.product_id, c.qty, c.size, c.fabric,
                   p.name, p.price, p.sale_discount_percent, p.image_url
            FROM cart_items c
            LEFT JOIN product p ON p.id = c.product_id
            WHERE c.user_id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return [];
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart = [];

        while ($row = $result->fetch_assoc()) {
            $productId = (int)$row['product_id'];
            $basePrice = (float)($row['price'] ?? 0.0);
            $discount = max(0, (int)($row['sale_discount_percent'] ?? 0));
            $finalPrice = ($discount > 0) ? round($basePrice * (1 - ($discount / 100)), 2) : $basePrice;

            $cart[$productId] = [
                'id' => $productId,
                'name' => $row['name'] ?? 'Unknown Product',
                'price' => $finalPrice,
                'old_price' => $basePrice,
                'discount_percent' => $discount,
                'image' => $row['image_url'] ?? '',
                'qty' => (int)$row['qty'],
                'size' => $row['size'],
                'fabric' => $row['fabric']
            ];
        }

        $stmt->close();
        return $cart;
    }

    public function addWishlistItem(int $userId, int $productId): bool
    {
        $this->ensureWishlistTableExists();

        $stmt = $this->conn->prepare("INSERT INTO wishlists (user_id, product_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ii', $userId, $productId);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function removeWishlistItem(int $userId, int $productId): bool
    {
        $this->ensureWishlistTableExists();

        $stmt = $this->conn->prepare("DELETE FROM wishlists WHERE user_id = ? AND product_id = ?");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ii', $userId, $productId);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function isWishlisted(int $userId, int $productId): bool
    {
        $this->ensureWishlistTableExists();

        $stmt = $this->conn->prepare("SELECT id FROM wishlists WHERE user_id = ? AND product_id = ? LIMIT 1");
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ii', $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $isWishlisted = $result->num_rows > 0;
        $stmt->close();

        return $isWishlisted;
    }

    public function getWishlistEntries(): array
    {
        $this->ensureWishlistTableExists();

        $sql = "
            SELECT w.id, w.user_id, w.product_id, w.created_at,
                   COALESCE(u.name, 'Unknown Customer') AS customer_name,
                   COALESCE(u.email, 'Unknown Customer') AS customer_email,
                   COALESCE(p.name, 'Unknown Product') AS product_name,
                   COALESCE(p.article_number, 'N/A') AS article_number,
                   COALESCE(p.image_url, '') AS image_url,
                   COALESCE(p.price, 0) AS price,
                   COALESCE(p.quantity, 0) AS quantity,
                   COALESCE(p.parent_cat, 0) AS parent_cat
            FROM wishlists w
            LEFT JOIN users u ON u.id = w.user_id
            LEFT JOIN product p ON p.id = w.product_id
            ORDER BY w.created_at DESC
        ";

        $result = $this->conn->query($sql);
        $entries = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $entries[] = $row;
            }
        }

        return $entries;
    }

    public function getWishlistEntriesForUser(int $userId): array
    {
        $this->ensureWishlistTableExists();

        $stmt = $this->conn->prepare(
            "SELECT w.id, w.user_id, w.product_id, w.created_at,
                    COALESCE(u.name, 'Unknown Customer') AS customer_name,
                    COALESCE(u.email, 'Unknown Customer') AS customer_email,
                    COALESCE(p.name, 'Unknown Product') AS product_name,
                    COALESCE(p.article_number, 'N/A') AS article_number,
                    COALESCE(p.image_url, '') AS image_url,
                    COALESCE(p.price, 0) AS price,
                    COALESCE(p.quantity, 0) AS quantity,
                    COALESCE(p.parent_cat, 0) AS parent_cat
             FROM wishlists w
             LEFT JOIN users u ON u.id = w.user_id
             LEFT JOIN product p ON p.id = w.product_id
             WHERE w.user_id = ?
             ORDER BY w.created_at DESC"
        );

        if (!$stmt) {
            return [];
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $entries = [];

        while ($row = $result->fetch_assoc()) {
            $entries[] = $row;
        }

        $stmt->close();

        return $entries;
    }

    public function getWishlistProductIdsForUser(int $userId): array
    {
        $this->ensureWishlistTableExists();

        $stmt = $this->conn->prepare("SELECT product_id FROM wishlists WHERE user_id = ?");
        if (!$stmt) {
            return [];
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $productIds = [];

        while ($row = $result->fetch_assoc()) {
            $productIds[] = (int) $row['product_id'];
        }

        $stmt->close();

        return $productIds;
    }

    public function logEmail(string $recipientEmail, string $subject, string $status = 'queued', ?string $templateName = null, ?string $errorMessage = null): bool
    {
        $this->ensureEmailLogsTableExists();

        $stmt = $this->conn->prepare(
            "INSERT INTO email_logs (recipient_email, subject, template_name, status, error_message) VALUES (?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            return false;
        }

        $safeTemplateName = $templateName ?? '';
        $safeErrorMessage = $errorMessage ?? '';

        $stmt->bind_param('sssss', $recipientEmail, $subject, $safeTemplateName, $status, $safeErrorMessage);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
}
