<?php


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = getenv('DB_HOST');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$name = getenv('DB_DATABASE');
$port = getenv('DB_PORT');
$conn = new mysqli($host, $user, $pass, $name, $port);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
// $conn = mysqli_connect('localhost','root','','Libey') or die('فشل الاتصال بقاعدة البيانات');
// // إعدادات بايبال
// require_once "config.php";
?>
