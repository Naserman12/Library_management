<?php
session_start();

require '../../include/db_connect.php';

if (!isset($_SESSION['memberId'])) {

    setFlash('error', 'يجب تسجيل الدخول لتحديث الصورة الشخصية.');

    header("REFRESH:3; URL = ../../admin/login.php");

    exit();
}

$memberId = $_SESSION['memberId'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $new_avatar = $_POST['avatar'];

    $query = "UPDATE member 
              SET avatar = :avatar 
              WHERE id = :id";

    $stmt = $conn->prepare($query);

    $result = $stmt->execute([
        'avatar' => $new_avatar,
        'id' => $memberId
    ]);

    if ($result) {

        setFlash('success', 'تم تحديث الصورة الشخصية بنجاح!');

        header("REFRESH:2; URL = showProfile.php");

        exit();

    } else {

        setFlash('error', 'حدث خطأ أثناء تحديث الصورة.');

    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تغيير الصورة الشخصية</title>
</head>
<body>
    <?php
require_once __DIR__ . '/../../include/flash.php';

$flash = getFlash();
if ($flash):
?>
    <div class="alert <?= $flash['type']; ?>">
        <?= $flash['message']; ?>
    </div>
<?php endif; ?>
<h2>تغيير الصورة الشخصية</h2>

<form action="updateAvatar.php" method="post">

    <div>

        <label>
            <input type="radio" name="avatar" value="eng.jfif" required>
            <img src="ImageAvater/eng.jfif" width="50" height="50">
        </label>

        <label>
            <input type="radio" name="avatar" value="Girl.png">
            <img src="ImageAvater/Girl.png" width="50" height="50">
        </label>

        <label>
            <input type="radio" name="avatar" value="man.png">
            <img src="ImageAvater/man.png" width="50" height="50">
        </label>

        <label>
            <input type="radio" name="avatar" value="userMAN.jpg">
            <img src="ImageAvater/userMAN.jpg" width="50" height="50">
        </label>

        <label>
            <input type="radio" name="avatar" value="woman.png">
            <img src="ImageAvater/woman.png" width="50" height="50">
        </label>

        <label>
            <input type="radio" name="avatar" value="woman2.png">
            <img src="ImageAvater/woman2.png" width="50" height="50">
        </label>

    </div>

    <button type="submit">تحديث الصورة</button>

</form>

</body>
</html>