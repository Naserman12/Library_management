<?php
require_once '../include/session.php';
require_once '../include/db_connect.php';
include '../USERS/MemberClass.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // تحديث دور العضو إلى مدير
    $sql = "UPDATE member SET role = 'admin' WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // ربط المتغير مع الاستعلام (PDO)
    $stmt->bindParam(1, $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "تمت الترقية";
        header("Location: adminpanel.php");
        exit;
    } else {
        echo "حدث خطأ أثناء الترقية";
    }

} else {
    echo "حدث خطأ: لم يتم تحديد العضو";
}
?>
