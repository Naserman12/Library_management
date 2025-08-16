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
//  التحقق من ان البيانات مرسلة عبر Post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $memberId = $_SESSION['memberId'];
   $name = $_POST['name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $avatar = $_POST['avatar'];
   $curMember->updateProfile(  $name, $email, $phone, $avatar, $memberId );
}