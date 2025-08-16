<?php
session_start();
require '../../include/db_connect.php';

if (!isset($_SESSION['memberId'])) {
    echo "سجل دخول لعرض هذه الصفحة!!.";
    header( "REFRESH:3; URL = ../admin/login.php");
    exit();
}

$memberId = $_SESSION['memberId'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_avatar = $_POST['avatar'];

    $query = "UPDATE member SET avatar = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $new_avatar, $memberId);

    if ($stmt->execute()) {
        echo "تم تحديث الصورة الشخصية بنجاح!";
        header("REFRESH:3; URL =  showProfile.php");
        exit();
    } else {
        echo "حدث خطأ أثناء تحديث الصورة.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تغيير الصورة الشخصية</title>
</head>
<body>
    <h2>تغيير الصورة الشخصية</h2>
    <form action="updateAvatar.php" method="post" enctype="multipart/form-data">
       <!-- عرض الصور كخيارات اختيار للمستخدم -->
    <div>
           <label>
                <input type="radio" name="avatar" value="../ImageAvater/eng.jfif" required>
                <img src="ImageAvater/eng.jfif" alt="Avatar 1" width="50" height="50">
            </label>
            <label>
                <input type="radio" name="avatar" value="Girl.png">
                <img src="ImageAvater/Girl.png" alt="Avatar 2" width="50" height="50">
            </label>
            <label>
                <input type="radio" name="avatar" value="man.png">
                <img src="ImageAvater/man.png" alt="Avatar 3" width="50" height="50">
            </label>
            <label>
                <input type="radio" name="avatar" value="userMAN.jpg">
                <img src="ImageAvater/userMAN.jpg" alt="Avatar 4" width="50" height="50">
            </label>
            <label>
                <input type="radio" name="avatar" value="woman.png">
                <img src="ImageAvater/woman.png" alt="Avatar 5" width="50" height="50">
            </label>
            <label>
                <input type="radio" name="avatar" value="woman2.png">
                <img src="ImageAvater/woman2.png" alt="Avatar 6" width="50" height="50">
            </label>
    </div>
        <button type="submit">تحديث الصورة</button>
    </form>
</body>
</html>
