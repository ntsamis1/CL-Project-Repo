<?php 

use Hotel\User;

require_once __DIR__.'/../../boot/boot.php';

if (strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    header('Location: /');

    return;
}

//create new user
$user = new User();
$user->insert($_REQUEST['name'],$_REQUEST['email'] , $_REQUEST['password']);

//retrieve user
$userInfo = $user->getByEmail($_REQUEST['email']);

//generate token
$token = $user->generateToken($userInfo['user_id']);

//Add Cookie
setcookie('user_token', $token, time() + (30 * 24 * 60 * 60), '/');

//return to home page
header('Location: /public/index.php');