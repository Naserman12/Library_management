<?php
// بدء الجلسة
session_start();
// استدعاء ملف كلاس الاعضاء
include 'MemberClass.php';

// انشاء كائن من كلاس الاعضاء
$member = new Member($conn);

// دالة تسجيل الخروخ

if ($member->logout()) {
   echo 'تم تسجيل الخروخ بنجاح.<br>';
   header( 'Location: login.php');
   exit();
} else {
    echo 'لم يتم تسجيل الخروج!!<br>';
}