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
        $this->host     = env('MYSQLHOST', env('MYSQL_HOST', env('DB_HOST', 'localhost')));
        $this->port     = (int) env('MYSQLPORT', env('MYSQL_PORT', env('DB_PORT', 3306)));
        $this->username = env('MYSQLUSER', env('MYSQL_USER', env('DB_USER', 'root')));
        $this->password = env('MYSQLPASSWORD', env('MYSQL_PASSWORD', env('DB_PASS', '')));
        $this->dbname   = env('MYSQLDATABASE', env('MYSQL_DATABASE', env('DB_NAME', 'StitchSmart')));
    }

    /**
     * Open and return a mysqli connection.
     * Terminates with an error message if the connection fails.
     */
    public function connect(): mysqli
    {
        try {
            $this->conn = @new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->dbname,
                $this->port
            );

            if ($this->conn->connect_error) {
                $msg = defined('APP_DEBUG') && APP_DEBUG
                    ? 'Database connection failed: ' . $this->conn->connect_error
                    : 'A database error occurred. Please try again later.';
                die($msg);
            }

            $this->conn->set_charset('utf8mb4');
            return $this->conn;
        } catch (Throwable $e) {
            $msg = defined('APP_DEBUG') && APP_DEBUG
                ? 'Database connection exception: ' . $e->getMessage() . ' | Host: ' . $this->host . ' | Port: ' . $this->port . ' | User: ' . $this->username . ' | DB: ' . $this->dbname
                : 'A database error occurred. Please try again later.';
            die($msg);
        }
    }
}