<?php

function setFlash($type, $message) {
    setcookie('flash_type', $type, time() + 5, "/");
    setcookie('flash_message', $message, time() + 5, "/");
}
function getFlash() {
    if (isset($_COOKIE['flash_type']) && isset($_COOKIE['flash_message'])) {

        $flash = [
            'type' => $_COOKIE['flash_type'],
            'message' => $_COOKIE['flash_message']
        ];

        // حذف الكوكيز بعد القراءة
        setcookie('flash_type', '', time() - 3600, "/");
        setcookie('flash_message', '', time() - 3600, "/");

        return $flash;
    }

    return null;
}
