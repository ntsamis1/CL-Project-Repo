<?php

error_reporting(E_ERROR);

// Register Autoload Function

spl_autoload_register(function ($class){
    $class = str_replace("\\", "/" , $class);
    require_once sprintf(__DIR__.'/../app/%s.php', $class);
    // include_once '/../app/' . $class . '.php' ; 
});

use Hotel\user;

$user = new User();

//Check if there is a token in request
if ( isset($_COOKIE['user_token'])){
$userToken = $_COOKIE['user_token'];
if ($userToken){
    //verify user

    if ($user->verifyToken($userToken)){
        //set user in memory

        $userInfo = $user->getTokenPayload($userToken);
        User::setCurrentUserId($userInfo['user_id']);
    }

}
}