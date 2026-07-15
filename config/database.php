<?php
/**
 * Stitch Smart — Database Connection
 *
 * Reads credentials from environment variables (loaded by config.php).
 * Always require config.php before this file.
 */

class Database
{
    private string $host;
    private string $username;
    private string $password;
    private string $dbname;
    private int    $port;

    public mysqli $conn;

    public function __construct()
    {
        // ── Try every possible Railway MySQL variable naming convention ───────
        // Railway MySQL plugin uses MYSQLHOST *or* MYSQL_HOST depending on version.
        $this->host     = env('MYSQLHOST')
                       ?: env('MYSQL_HOST')
                       ?: env('DB_HOST')
                       ?: 'localhost';

        $this->port     = (int)(env('MYSQLPORT')
                       ?: env('MYSQL_PORT')
                       ?: env('DB_PORT')
                       ?: 3306);

        $this->username = env('MYSQLUSER')
                       ?: env('MYSQL_USER')
                       ?: env('DB_USER')
                       ?: 'root';

        $this->password = env('MYSQLPASSWORD')
                       ?: env('MYSQL_PASSWORD')
                       ?: env('DB_PASS')
                       ?: '';

        $this->dbname   = env('MYSQLDATABASE')
                       ?: env('MYSQL_DATABASE')
                       ?: env('DB_NAME')
                       ?: 'StitchSmart';

        // ── Self-healing: parse MYSQL_URL / DATABASE_URL if host is not a DB ─
        // Kicks in when host is localhost on Railway, or a mail server
        $needsUrl = (env('RAILWAY_ENVIRONMENT') && in_array($this->host, ['localhost', '127.0.0.1'], true))
                 || str_contains($this->host, 'smtp')
                 || str_contains($this->host, 'gmail');

        if ($needsUrl) {
            $rawUrl = env('MYSQL_URL')
                   ?: env('DATABASE_URL')
                   ?: env('MYSQL_PRIVATE_URL')
                   ?: env('MYSQL_PUBLIC_URL')
                   ?: '';
            if ($rawUrl !== '') {
                $p = parse_url($rawUrl);
                if (!empty($p['host'])) {
                    $this->host     = $p['host'];
                    $this->port     = !empty($p['port']) ? (int)$p['port'] : $this->port;
                    $this->username = !empty($p['user']) ? $p['user'] : $this->username;
                    $this->password = !empty($p['pass']) ? $p['pass'] : $this->password;
                    $this->dbname   = !empty($p['path']) ? ltrim($p['path'], '/') : $this->dbname;
                }
            }
        }
    }

    /**
     * Open and return a mysqli connection.
     * Terminates with an error message if the connection fails.
     */
    public function connect(): mysqli
    {
        try {
            $driver = mysqli_init();
            $driver->options(MYSQLI_OPT_CONNECT_TIMEOUT, 2);
            @$driver->real_connect(
                $this->host,
                $this->username,
                $this->password,
                $this->dbname,
                $this->port
            );
            $this->conn = $driver;

            if ($this->conn->connect_error || mysqli_connect_error()) {
                $err = $this->conn->connect_error ?: mysqli_connect_error();
                $msg = defined('APP_DEBUG') && APP_DEBUG
                    ? 'Database connection failed: ' . $err . ' | Host: ' . $this->host . ':' . $this->port . ' | User: ' . $this->username . ' | DB: ' . $this->dbname
                    : 'A database error occurred. Please try again later.';
                die($msg);
            }

            $this->conn->set_charset('utf8mb4');
            return $this->conn;
        } catch (Throwable $e) {
            $msg = defined('APP_DEBUG') && APP_DEBUG
                ? 'Database connection exception: ' . $e->getMessage() . ' | Host: ' . $this->host . ':' . $this->port . ' | User: ' . $this->username . ' | DB: ' . $this->dbname
                : 'A database error occurred. Please try again later.';
            die($msg);
        }
    }
}