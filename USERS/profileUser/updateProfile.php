<?php
session_start();
include '../MemberClass.php';

// التأكد من أن المستخدم مسجّل الدخول
if (!isset($_SESSION['memberId'])) {
    setFlash('error', 'يجب تسجيل الدخول لتحديث الملف الشخصي.');
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
   $avatar = $_FILES['avatar']['name'] ?? null;
   $curMember->updateProfile(  $name, $email, $phone, $avatar, $memberId );
}