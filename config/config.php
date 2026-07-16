<?php
/**
 * Stitch Smart — Application Configuration
 *
 * Loads environment variables from the root .env file and defines
 * application-wide constants consumed by controllers and views.
 */

// ── Load .env ───────────────────────────────────────────────────────────────
// Simple .env parser — no external dependency required.
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Skip comments and blank lines
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (str_contains($line, '=')) {
            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key]    = $value;
                $_SERVER[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

// ── Helper ───────────────────────────────────────────────────────────────────
if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $val = $_ENV[$key] ?? getenv($key);
        return ($val !== false && $val !== null && $val !== '') ? $val : $default;
    }
}

// ── Application Constants ────────────────────────────────────────────────────
define('APP_NAME',    env('APP_NAME',    'Stitch Smart'));
define('APP_ENV',     env('APP_ENV',     'development'));
define('APP_DEBUG',   filter_var(env('APP_DEBUG', true), FILTER_VALIDATE_BOOLEAN));

// Ensure BASE_URL always ends with exactly one trailing slash
// Automatically support Railway public domain / static url if running on Railway
$rawAppUrl = (string) env('APP_URL', 'http://localhost:8000/');
if (env('RAILWAY_STATIC_URL')) {
    $rawAppUrl = env('RAILWAY_STATIC_URL');
} elseif (env('RAILWAY_PUBLIC_DOMAIN')) {
    $rawAppUrl = env('RAILWAY_PUBLIC_DOMAIN');
} elseif (!empty($_SERVER['HTTP_HOST']) && (str_contains($_SERVER['HTTP_HOST'], 'railway.app') || env('RAILWAY_ENVIRONMENT'))) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https://' : 'http://';
    $rawAppUrl = $protocol . $_SERVER['HTTP_HOST'];
}

// Ensure protocol (http:// or https://) is always prepended if missing
if (!str_starts_with($rawAppUrl, 'http://') && !str_starts_with($rawAppUrl, 'https://')) {
    if (str_contains($rawAppUrl, 'localhost') || str_contains($rawAppUrl, '127.0.0.1')) {
        $rawAppUrl = 'http://' . ltrim($rawAppUrl, '/');
    } else {
        $rawAppUrl = 'https://' . ltrim($rawAppUrl, '/');
    }
}

$baseUrl = rtrim($rawAppUrl, '/') . '/';
define('BASE_URL', $baseUrl);

// ── Clean URL Helper ─────────────────────────────────────────────────────────
if (!function_exists('url')) {
    /**
     * Generate a clean URL without index.php or double slashes.
     * Example: url('design') -> http://localhost/Stitch-Smart/public/design
     */
    function url(string $path = ''): string
    {
        $base = rtrim(BASE_URL, '/');
        $path = ltrim($path, '/');
        if ($path === '' || $path === 'home' || $path === 'index.php?page=home' || $path === 'page=home' || $path === '?page=home') {
            return $base . '/';
        }
        if (str_starts_with($path, 'index.php?page=')) {
            $path = substr($path, strlen('index.php?page='));
        } elseif (str_starts_with($path, 'index.php')) {
            $path = ltrim(substr($path, strlen('index.php')), '/?');
        }
        if (str_starts_with($path, '?page=')) {
            $path = substr($path, strlen('?page='));
        }
        if (str_starts_with($path, 'page=')) {
            $path = substr($path, strlen('page='));
        }
        if (str_starts_with($path, 'page?slug=')) {
            $path = substr($path, strlen('page?slug='));
        } elseif (str_starts_with($path, 'page&slug=')) {
            $path = substr($path, strlen('page&slug='));
        }
        if ($path === 'how_to_order') {
            $path = 'how-to-order';
        }
        $pos = strpos($path, '&');
        if ($pos !== false && strpos($path, '?') === false) {
            $path = substr_replace($path, '?', $pos, 1);
        }
        return $base . '/' . $path;
    }
}

// ── Google Gemini Constants for Admin AI ─────────────────────────────────────
define('GOOGLE_API_KEY', env('GOOGLE_API_KEY', ''));
define('GEMINI_MODEL',    env('GEMINI_MODEL',    'gemini-2.5-flash-lite'));

// ── Chatbot ──────────────────────────────────────────────────────────────────
$chatbotUrl = env('CHATBOT_API_URL', 'http://localhost:5000');
if (env('FYP_CHATBOT_URL')) {
    $chatbotUrl = env('FYP_CHATBOT_URL');
} elseif (env('RAILWAY_SERVICE_FYP_CHATBOT_URL')) {
    $chatbotUrl = 'https://' . rtrim(env('RAILWAY_SERVICE_FYP_CHATBOT_URL'), '/');
}
define('CHATBOT_API_URL',     $chatbotUrl);
define('CHATBOT_API_TIMEOUT', (int) env('CHATBOT_API_TIMEOUT', 8));
define('CHATBOT_API_TOKEN',   env('CHATBOT_API_TOKEN',   ''));

// ── Mail ─────────────────────────────────────────────────────────────────────
define('MAIL_HOST',       env('MAIL_HOST',       'smtp.gmail.com'));
define('MAIL_PORT',       (int) env('MAIL_PORT', 587));
define('MAIL_USERNAME',   env('MAIL_USERNAME',   'stitchsmartofficial@gmail.com'));
define('MAIL_PASSWORD',   env('MAIL_PASSWORD',   'hsyqeqetbfyeqisp'));
define('MAIL_ENCRYPTION', env('MAIL_ENCRYPTION', 'tls'));
define('MAIL_FROM_NAME',  env('MAIL_FROM_NAME',  APP_NAME));

// ── Theme ─────────────────────────────────────────────────────────────────────
// $global_theme is set dynamically from DB settings in the router / controllers.
// Default fallback:
if (!isset($global_theme)) {
    $global_theme = 'theme-luxury';
}

// ── PayPal ───────────────────────────────────────────────────────────────────
define('PAYPAL_CLIENT_ID', env('PAYPAL_CLIENT_ID', 'sb'));
define('PAYPAL_ENV',       env('PAYPAL_ENV',       'sandbox'));