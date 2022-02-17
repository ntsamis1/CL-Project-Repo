<?php 

use Hotel\Review;
use Hotel\User;

require_once __DIR__.'/../../boot/boot.php';


//check method 
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
    header('Location: /');
    return;
}

//if there is already logged user, return to home page
if (empty(User::getCurrentUserId())){
    header('Location: / ');
    return;
}

//check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)){
    header('Location: / ');
    return;
}

//set Review
$review = new Review();
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);


//return to room page
header(sprintf('Location: /../public/room.php?room_id=%s', $roomId));

?>