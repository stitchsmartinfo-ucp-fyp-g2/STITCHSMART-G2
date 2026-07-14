<?php
// Load config and database first so env constants are available
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../app/models/SchemaBootstrap.php";
require_once __DIR__ . "/../app/core/Router.php";

// public/index.php
define('BASE_PATH', realpath(__DIR__ . '/..'));  // points to project root FYP-UMT

$cookieSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $cookieSecure,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start(); // start session for admin login or user login

$database = new Database();
$conn = $database->connect();
(new SchemaBootstrap($conn));

// Load site-wide web settings so views can read selected theme
require_once __DIR__ . '/../app/models/settings.php';
$settingsModel = new Settings();
$ws = $settingsModel->getWebSettings();
$global_theme = $ws['theme'] ?? 'theme-default';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$sessionTimeoutSeconds = (int) env('SESSION_TIMEOUT_SECONDS', 1800);
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}

if ((time() - (int) $_SESSION['last_activity']) > $sessionTimeoutSeconds) {
    $hadAdminSession = !empty($_SESSION['admin_logged_in']);
    $hadCustomerSession = !empty($_SESSION['customer_logged_in']);
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    session_destroy();
    session_start();
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['last_activity'] = time();
    $_SESSION['session_expired'] = true;
    $_SESSION['session_expired_just_now'] = true; // Flag to skip CSRF on login form
    if ($hadAdminSession) {
        $_SESSION['login_error'] = 'Your session expired due to inactivity. Please log in again.';
        header('Location: ' . url('admin_login'));
        exit;
    }

    if ($hadCustomerSession) {
        $_SESSION['login_error'] = 'Your session expired due to inactivity. Please log in again.';
        header('Location: ' . url('customer_login'));
        exit;
    }
} else {
    $_SESSION['last_activity'] = time();
}

// Get page from URL (default to 'home')
$page = $_GET['page'] ?? 'home';

// Clean-URL Redirect: Eliminate index.php, ?page=, and page?slug= from the browser address bar
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !isset($_GET['ajax'])) {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (str_contains($uri, 'index.php') || str_contains($uri, '?page=') || str_contains($uri, '&page=') || str_contains($uri, 'page?slug=') || str_contains($uri, 'page&slug=')) {
        $cleanUrl = '';
        if ($page === 'page' && !empty($_GET['slug'])) {
            $cleanUrl = url($_GET['slug']);
        } elseif ($page === 'home' || $page === '') {
            $cleanUrl = url('');
        } else {
            $params = $_GET;
            unset($params['page']);
            $query = !empty($params) ? '?' . http_build_query($params) : '';
            $cleanUrl = url($page . $query);
        }
        if (!empty($cleanUrl)) {
            header('Location: ' . $cleanUrl, true, 301);
            exit;
        }
    }
}

// Save the last page URL in the session (excluding login/registration/logout/ajax pages)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !in_array($page, [
    'customer_login', 'customer_register', 'customer_logout', 
    'customer_forgot_password', 'customer_forgot_password_process', 
    'admin_login', 'admin_logout', 'admin_forgot_password', 
    'admin_confirm_reset', 'live_search', 'user_search_history',
    'user_chat_history', 'user_similar_products'
], true)) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
}

// Dispatch request via modular Router
Router::dispatch($page);
?>
