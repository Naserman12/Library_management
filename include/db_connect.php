<?php


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];
$name = $_ENV['DB_DATABASE'];
$port = $_ENV['DB_PORT'];
$conn = new mysqli($host, $user, $pass, $name, $port);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
// $conn = mysqli_connect('localhost','root','','Libey') or die('فشل الاتصال بقاعدة البيانات');
// // إعدادات بايبال
// require_once "config.php";
?>
