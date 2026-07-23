<?php
class Warranty
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function createWarranty(int $orderId, ?int $userId, int $durationDays, string $terms): bool|string
    {
        $code = 'WAR-' . strtoupper(substr(uniqid(), -6));
        $expiresAt = date('Y-m-d H:i:s', strtotime("+$durationDays days"));

        $stmt = $this->conn->prepare("INSERT INTO warranty_cards (order_id, user_id, code, duration_days, terms, expires_at) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) return false;

        $stmt->bind_param('iisiss', $orderId, $userId, $code, $durationDays, $terms, $expiresAt);
        if ($stmt->execute()) {
            return $code;
        }
        return false;
    }

    public function getUserWarranties(int $userId): array
    {
        $stmt = $this->conn->prepare("
            SELECT w.*, o.invoice_no, o.total, o.created_at as order_date 
            FROM warranty_cards w 
            LEFT JOIN orders o ON w.order_id = o.id 
            WHERE w.user_id = ? 
            ORDER BY w.created_at DESC
        ");
        if (!$stmt) return [];

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllWarranties(): array
    {
        $stmt = $this->conn->prepare("
            SELECT w.*, o.invoice_no, o.customer_name 
            FROM warranty_cards w 
            LEFT JOIN orders o ON w.order_id = o.id 
            ORDER BY w.created_at DESC
        ");
        if (!$stmt) return [];
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function submitClaim(int $warrantyId, string $description, ?string $image = null): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO warranty_claims (warranty_id, issue_description, image_url) VALUES (?, ?, ?)");
        if (!$stmt) return false;

        $stmt->bind_param('iss', $warrantyId, $description, $image);
        return $stmt->execute();
    }

    public function getUserClaims(int $userId): array
    {
        $stmt = $this->conn->prepare("
            SELECT c.*, w.code, o.invoice_no 
            FROM warranty_claims c 
            JOIN warranty_cards w ON c.warranty_id = w.id 
            LEFT JOIN orders o ON w.order_id = o.id 
            WHERE w.user_id = ?
            ORDER BY c.created_at DESC
        ");
        if (!$stmt) return [];

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllClaims(): array
    {
        $stmt = $this->conn->prepare("
            SELECT c.*, w.code, w.user_id, o.customer_name, o.invoice_no 
            FROM warranty_claims c 
            JOIN warranty_cards w ON c.warranty_id = w.id 
            LEFT JOIN orders o ON w.order_id = o.id 
            ORDER BY c.created_at DESC
        ");
        if (!$stmt) return [];
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateClaimStatus(int $claimId, string $status, string $adminNotes): bool
    {
        // Safety check: ensure admin_notes column exists
        $checkCol = $this->conn->query("SHOW COLUMNS FROM warranty_claims LIKE 'admin_notes'");
        if ($checkCol && $checkCol->num_rows === 0) {
            $this->conn->query("ALTER TABLE warranty_claims ADD COLUMN admin_notes TEXT AFTER status");
        }

        $stmt = $this->conn->prepare("UPDATE warranty_claims SET status = ?, admin_notes = ? WHERE id = ?");
        if (!$stmt) return false;

        $stmt->bind_param('ssi', $status, $adminNotes, $claimId);
        return $stmt->execute();
    }
}
