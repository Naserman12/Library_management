<?php
// الإتصال بقاعدة البيانات
$conn = new PDO('mysql:host=localhost;dbname=users', 'root', '');

// إضافة مستخدم جديد
$queryInsert = "INSERT INTO users (name, email, created_at ) VALUES (:name, :email, NOW())";
$stmt = $conn->prepare($queryInsert);
if ($stmt->execute([':name' => 'name', ':email' => 'email'])) {
    echo "تمت الإضافة.";
}

// جلب جميع المستخدمين
$querySeclect = $conn->prepare("SELECT * FROM users");
$querySeclect->execute();

  // عرض النتائج
  $users = $querySelect->fetchAll(PDO::FETCH_ASSOC);
  foreach ($users as $user) {
      echo "ID: " . $user['id'] . " | Name: " . $user['name'] . " | Email: " . $user['email'] . "<br>";
  }