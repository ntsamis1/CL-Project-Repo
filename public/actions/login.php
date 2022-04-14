<?php

use Hotel\User;

require_once __DIR__ . '/../../boot/boot.php';

if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /');
    return;
}

//if there is already logged user, return to home page
if (!empty(User::getCurrentUserId())) {
    header('Location: / ');
    return;
}

//verify user
$user = new User();
try {
    if (!$user->verify($_REQUEST['email'], $_REQUEST['password'])) {
        header("location: /public/login.php?error='invalid-credentials'");
    } else {
        $userInfo = $user->getByEmail($_REQUEST['email']);
        $token = $user->generateToken($userInfo['user_id']);
        setcookie('user_token', $token, time() + 60 * 60 * 24 * 30, '/');
        header('Location: /public/index.php');
    }
} catch (InvalidArgumentException $ex) {
    header('Location /login.php?error=No User Exists');
    return;
}
