<?php
require_once BASE_PATH.'/app/services/ApiService.php';
require_once BASE_PATH.'/config/database.php';

class ChatController {
    private $apiService;

    public function __construct() {
        $this->apiService = new ApiService();
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Called by AJAX when user sends a message
    public function send() {
        error_reporting(E_ERROR);
        ini_set('display_errors', '0');
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userMessage = trim(strip_tags((string)($_POST['message'] ?? '')));
        $userMessage = mb_substr($userMessage, 0, 500);

        if(!$userMessage) {
            echo json_encode(['response' => 'Please type a message.']);
            return;
        }

        $sessionKey = 'chat_rate_limit';
        $now = time();
        $recentMessages = $_SESSION[$sessionKey] ?? [];
        $recentMessages = array_values(array_filter($recentMessages, fn($timestamp) => ($now - (int)$timestamp) < 60));
        if (count($recentMessages) >= 10) {
            echo json_encode(['response' => 'You are sending messages too quickly. Please wait a moment before trying again.']);
            return;
        }
        $recentMessages[] = $now;
        $_SESSION[$sessionKey] = $recentMessages;

        $sessionId = session_id() ?: 'default';
        $response = $this->apiService->sendMessageToChatbot($userMessage, $sessionId);
        
        if(isset($response['error'])) {
            echo json_encode(['response' => 'Sorry, the assistant is currently unavailable. Please try again later.']);
            return;
        }
        
        echo json_encode(['response' => $response['response'] ?? 'No response received.']);
    }

    // Called by AJAX when user clicks a product
    public function similarProducts() {
        error_reporting(E_ERROR);
        ini_set('display_errors', '0');
        header('Content-Type: application/json');
        
        $productId = (int)($_POST['product_id'] ?? 0);
        if($productId <= 0) {
            echo json_encode(['error' => 'Product ID missing']);
            return;
        }

        $response = $this->apiService->getSimilarProducts($productId);
        echo json_encode($response);
    }

    private function ensureHistoryTables()
    {
        // create user_chats if missing
        $res = $this->conn->query("SHOW TABLES LIKE 'user_chats'");
        if ($res && $res->num_rows === 0) {
            $this->conn->query("CREATE TABLE user_chats (
                id INT(11) NOT NULL AUTO_INCREMENT,
                user_id INT(11) NOT NULL,
                role VARCHAR(10) NOT NULL,
                message TEXT NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY(id),
                KEY user_id_idx (user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        $res2 = $this->conn->query("SHOW TABLES LIKE 'user_searches'");
        if ($res2 && $res2->num_rows === 0) {
            $this->conn->query("CREATE TABLE user_searches (
                id INT(11) NOT NULL AUTO_INCREMENT,
                user_id INT(11) NOT NULL,
                query VARCHAR(255) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY(id),
                KEY user_id_idx (user_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
    }

    // Save a chat message (role: 'user'|'bot') — only for logged-in users
    public function saveChat()
    {
        error_reporting(E_ERROR);
        ini_set('display_errors', '0');
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['customer_id'] ?? null;
        if (!$userId) {
            echo json_encode(['error' => 'Not logged in']);
            return;
        }

        $role = in_array($_POST['role'] ?? 'user', ['user', 'bot'], true) ? $_POST['role'] : 'user';
        $message = trim(strip_tags((string)($_POST['message'] ?? '')));
        $message = mb_substr($message, 0, 1000);
        if ($message === '') {
            echo json_encode(['error' => 'Empty message']);
            return;
        }

        $this->ensureHistoryTables();

        $stmt = $this->conn->prepare("INSERT INTO user_chats (user_id, role, message) VALUES (?, ?, ?)");
        if ($stmt === false) {
            echo json_encode(['error' => 'DB prepare failed']);
            return;
        }
        $stmt->bind_param('iss', $userId, $role, $message);
        $ok = $stmt->execute();
        if ($ok) echo json_encode(['success' => true]);
        else echo json_encode(['error' => 'DB insert failed']);
    }

    // Get recent chat history for logged-in user
    public function getChatHistory()
    {
        error_reporting(E_ERROR);
        ini_set('display_errors', '0');
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['customer_id'] ?? null;
        if (!$userId) { echo json_encode(['messages' => []]); return; }

        $this->ensureHistoryTables();

        $limit = 50;
        $stmt = $this->conn->prepare("SELECT role, message, created_at FROM user_chats WHERE user_id = ? ORDER BY id DESC LIMIT ?");
        if ($stmt === false) { echo json_encode(['messages' => []]); return; }
        $stmt->bind_param('ii', $userId, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $messages = [];
        while ($row = $res->fetch_assoc()) {
            $messages[] = $row;
        }
        // return in chronological order
        $messages = array_reverse($messages);
        echo json_encode(['messages' => $messages]);
    }

    // Save search query for logged-in user
    public function saveSearch()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['customer_id'] ?? null;
        if (!$userId) { echo json_encode(['error' => 'Not logged in']); return; }

        $query = trim(strip_tags((string)($_POST['query'] ?? '')));
        $query = mb_substr($query, 0, 255);
        if ($query === '') { echo json_encode(['error' => 'Empty query']); return; }

        $this->ensureHistoryTables();

        $stmt = $this->conn->prepare("INSERT INTO user_searches (user_id, query) VALUES (?, ?)");
        if ($stmt === false) { echo json_encode(['error' => 'DB prepare failed']); return; }
        $stmt->bind_param('is', $userId, $query);
        $ok = $stmt->execute();
        if ($ok) echo json_encode(['success' => true]); else echo json_encode(['error' => 'DB insert failed']);
    }

    // Get recent searches for logged-in user
    public function getSearchHistory()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['customer_id'] ?? null;
        if (!$userId) { echo json_encode(['searches' => []]); return; }

        $this->ensureHistoryTables();

        $limit = 20;
        $stmt = $this->conn->prepare("SELECT query, created_at FROM user_searches WHERE user_id = ? ORDER BY id DESC LIMIT ?");
        if ($stmt === false) { echo json_encode(['searches' => []]); return; }
        $stmt->bind_param('ii', $userId, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $searches = [];
        while ($row = $res->fetch_assoc()) $searches[] = $row;
        echo json_encode(['searches' => $searches]);
    }
}
?>
