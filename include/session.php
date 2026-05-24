<?php

// 🔥 مهم جداً لـ Railway: إجبار PHP على اعتبار الاتصال HTTPS
if (
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
) {
    $_SERVER['HTTPS'] = 'on';
}

ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => true,      // Railway = HTTPS
    'httponly' => true,
    'samesite' => 'None'   // ضروري جداً
]);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
