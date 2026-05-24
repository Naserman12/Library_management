<?php

function setFlash($type, $message) {
    $_SESSION['flash_type'] = $type;
    $_SESSION['flash_message'] = $message;
}

function getFlash() {
    if (isset($_SESSION['flash_type']) && isset($_SESSION['flash_message'])) {

        $flash = [
            'type' => $_SESSION['flash_type'],
            'message' => $_SESSION['flash_message']
        ];

        unset($_SESSION['flash_type']);
        unset($_SESSION['flash_message']);

        return $flash;
    }

    return null;
}