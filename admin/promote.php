<?php
include '../USERS/MemberClass.php';
// التحقق من معرف العضو
// $id = $_GET['id'];
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // تحديث دور العضو الى مدير
    $sql = "UPDATE member SET role = 'admin' WHERE id =?";
    echo $sql;
    $result = $conn->prepare($sql);
    $result->bind_param("i", $id);
    $result->execute();
    echo "تمت الترقية";
    header("Location: adminpanel.php");
}else{
    echo"حدث خطأ لم يتم تديد العضو";
}
?>