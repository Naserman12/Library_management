<?php

session_start();

// حذف بيانات الجلسة
$_SESSION = [];

// حذف كوكي الجلسة
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// تدمير الجلسة
session_destroy();

// إعادة توجيه
header("Location: ../index.php");
exit;