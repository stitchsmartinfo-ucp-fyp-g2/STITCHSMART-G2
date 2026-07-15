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
            $driver = mysqli_init();
            $driver->options(MYSQLI_OPT_CONNECT_TIMEOUT, 8);
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
                @file_put_contents(__DIR__ . '/../public/db_error_temp.txt', "Connect Error: " . $err . " | Host: " . $this->host . " | Port: " . $this->port . " | User: " . $this->username . " | DB: " . $this->dbname);
                $msg = defined('APP_DEBUG') && APP_DEBUG
                    ? 'Database connection failed: ' . $err
                    : 'A database error occurred. Please try again later.';
                die($msg);
            }

            $this->conn->set_charset('utf8mb4');
            return $this->conn;
        } catch (Throwable $e) {
            @file_put_contents(__DIR__ . '/../public/db_error_temp.txt', "Exception: " . $e->getMessage() . " | Host: " . $this->host . " | Port: " . $this->port . " | User: " . $this->username . " | DB: " . $this->dbname);
            $msg = defined('APP_DEBUG') && APP_DEBUG
                ? 'Database connection exception: ' . $e->getMessage() . ' | Host: ' . $this->host . ' | Port: ' . $this->port . ' | User: ' . $this->username . ' | DB: ' . $this->dbname
                : 'A database error occurred. Please try again later.';
            die($msg);
        }
    }
}