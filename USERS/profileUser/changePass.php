<?php
session_start();
include '../MemberClass.php';

// التأكد من أن المستخدم مسجّل الدخول
if (!isset($_SESSION['memberId'])) {
    echo "سجل دخول لعرض هذه الصفحة!!.";
    header( "REFRESH:3; URL = ../../admin/login.php");
    exit();
}
$curMember = new Member($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword =$_POST['confirmPassword'];

    $curMember->changePassword($currPassword, $newPassword, $confirmPassword);
}

?>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #f5f5f5;
}

.password-change-container {
    width: 300px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.password-change-container h2 {
    margin-bottom: 20px;
    color: #333;
}

.password-change-container label {
    display: block;
    text-align: right;
    margin-bottom: 5px;
    color: #666;
    font-size: 0.9em;
}

.password-change-container input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.password-change-container button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
}

.password-change-container button:hover {
    background-color: #45a049;
}
</style>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تغيير كلمة السر</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="password-change-container">
        <h2>تغيير كلمة السر</h2>
        <form action="changePass.php" method="POST">
            <label for="current-password">كلمة السر الحالية</label>
            <input type="password" id="current-password" name="currentPassword" required>

            <label for="new-password">كلمة السر الجديدة</label>
            <input type="password" id="new-password" name="newPassword" required>

            <label for="confirm-password">تأكيد كلمة السر الجديدة</label>
            <input type="password" id="confirm-password" name="confirmPassword" required>

            <button type="submit">حفظ التغييرات</button>
        </form>
    </div>
</body>
</html>
