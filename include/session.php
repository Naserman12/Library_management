<?php

ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => true,      // Railway = HTTPS
    'httponly' => true,
    'samesite' => 'None'   // أهم شيء
]);

session_start();
