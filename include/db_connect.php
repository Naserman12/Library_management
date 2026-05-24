<?php
require_once __DIR__ . '/../vendor/autoload.php';

// تحميل .env فقط في المحلي
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();
}

// قراءة المتغيرات من SERVER أولاً (Railway)
$host = $_SERVER['DB_HOST']     ?? $_ENV['DB_HOST']     ?? null;
$db   = $_SERVER['DB_DATABASE'] ?? $_ENV['DB_DATABASE'] ?? null;
$user = $_SERVER['DB_USERNAME'] ?? $_ENV['DB_USERNAME'] ?? null;
$pass = $_SERVER['DB_PASSWORD'] ?? $_ENV['DB_PASSWORD'] ?? null;
$port = $_SERVER['DB_PORT']     ?? $_ENV['DB_PORT']     ?? 3306;

try {
    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}
