<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

echo "Host: " . env('MYSQLHOST', env('MYSQL_HOST', env('DB_HOST', 'localhost'))) . "\n";
echo "Port: " . env('MYSQLPORT', env('MYSQL_PORT', env('DB_PORT', 3306))) . "\n";
echo "User: " . env('MYSQLUSER', env('MYSQL_USER', env('DB_USER', 'root'))) . "\n";
echo "DB: " . env('MYSQLDATABASE', env('MYSQL_DATABASE', env('DB_NAME', 'StitchSmart'))) . "\n";

$database = new Database();
$conn = $database->connect();
echo "Connected successfully!\n";
?>
