<?php
/**
 * Stitch Smart — Core Router
 *
 * Handles loading modular route files from the routes/ directory,
 * enforces access control (admin authentication), validates CSRF tokens,
 * and dispatches requests to the appropriate controller and method.
 */

class Router
{
    /**
     * Dispatch the incoming request to the appropriate controller and method.
     *
     * @param string $page The route key or page slug requested.
     */
    public static function dispatch(string $page): void
    {
        $baseDir = realpath(__DIR__ . '/../../');

        // Load route definitions from separate files in app/routes/
        $webRoutes   = require $baseDir . '/app/routes/web.php';
        $adminRoutes = require $baseDir . '/app/routes/admin.php';
        $apiConfig   = require $baseDir . '/app/routes/api.php';

        $apiRoutes        = $apiConfig['routes'] ?? [];
        $csrfExemptRoutes = $apiConfig['csrf_exempt'] ?? [];

        // 1. Resolve Route & Enforce Access Control
        if ($page === 'favicon.ico') {
            $faviconPath = $baseDir . '/public/pictures/stitchsmart_luxury_icon.svg';
            if (file_exists($faviconPath)) {
                header('Content-Type: image/svg+xml; charset=utf-8');
                header('Cache-Control: public, max-age=86400');
                readfile($faviconPath);
                exit;
            }
            header("HTTP/1.0 404 Not Found");
            exit;
        }

        $route = null;

        if (isset($webRoutes[$page])) {
            $route = $webRoutes[$page];
        } elseif (isset($apiRoutes[$page])) {
            $route = $apiRoutes[$page];
        } elseif (isset($adminRoutes[$page])) {
            // Admin pages except auth pages can only be accessed if logged in
            $adminAuthPages = ['admin_login', 'admin_logout', 'admin_forgot_password', 'admin_confirm_reset'];
            if (!in_array($page, $adminAuthPages, true) && !isset($_SESSION['admin_logged_in'])) {
                header("Location: " . url("admin_login"));
                exit;
            }
            $route = $adminRoutes[$page];
        } else {
            // Treat unknown frontend routes as CMS page slug
            require_once $baseDir . '/app/controllers/Admin/PageController.php';
            $controller = new PageController();
            $controller->show($page);
            exit;
        }

        // 2. Validate CSRF Token on POST Requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !in_array($page, $csrfExemptRoutes, true)) {
            self::validateCsrfToken($page);
        }

        // 3. Load Controller & Execute Method
        $file = $route['file'];
        if (str_starts_with($file, '../')) {
            $file = substr($file, 3);
        }
        require_once $baseDir . '/' . $file;
        
        $controllerName = $route['controller'];
        $method         = $route['method'];

        $controller = new $controllerName();

        // List of pages that require an ID parameter
        $pagesWithId = [
            'product', 'edit_product', 'delete_product', 'edit_category', 
            'delete_category', 'edit_banner', 'delete_banner', 'cart_remove', 
            'edit_page', 'update_page', 'delete_page'
        ];

        if ($page === 'page') {
            $slug = $_GET['slug'] ?? '';
            $controller->$method($slug);
        } elseif (in_array($page, $pagesWithId, true)) {
            if (!isset($_GET['id'])) {
                die("ID missing for this action.");
            }
            $controller->$method((int)$_GET['id']);
        } else {
            $controller->$method();
        }
    }

    /**
     * Validate CSRF token for non-exempt POST requests.
     */
    private static function validateCsrfToken(string $page): void
    {
        $submittedToken = $_POST['csrf_token'] ?? '';
        if (!is_string($submittedToken) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            $redirectTo = trim((string)($_POST['redirect_to'] ?? ''));
            if (!empty($redirectTo)) {
                $_SESSION['csrf_error'] = 'Security token refreshed. Please try again.';
                $redirectUrl = self::resolveSafeRedirectUrl($redirectTo, $page);
                header('Location: ' . $redirectUrl);
                exit;
            }

            $_SESSION['csrf_error'] = 'Security token expired. Please refresh the page and try again.';
            if (str_starts_with($page, 'admin_') || str_starts_with($page, 'customer_') || in_array($page, ['place_order', 'contact_send', 'subscribe_newsletter', 'product_review', 'cart_add', 'wishlist_toggle', 'toggle_wishlist'], true)) {
                header('Location: ' . url($page));
                exit;
            }

            http_response_code(403);
            echo 'Invalid security token.';
            exit;
        }
    }

    /**
     * Resolve a safe redirect URL after a CSRF or validation redirect.
     */
    public static function resolveSafeRedirectUrl(string $redirectTo, string $fallbackRoute): string
    {
        $redirectTo = trim($redirectTo);

        if ($redirectTo === '') {
            return url($fallbackRoute);
        }

        $sanitized = preg_replace('/[^A-Za-z0-9_=&?\-\/\.]/', '', $redirectTo);

        if ($sanitized === '') {
            return url($fallbackRoute);
        }

        return url($sanitized);
    }
}

if (!function_exists('resolveSafeRedirectUrl')) {
    function resolveSafeRedirectUrl(string $redirectTo, string $fallbackRoute): string
    {
        return Router::resolveSafeRedirectUrl($redirectTo, $fallbackRoute);
    }
}
