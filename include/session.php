<?php

ini_set('session.use_strict_mode', 1);
// بما أنك تستخدم HTTPS
ini_set('session.cookie_secure', 1);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}