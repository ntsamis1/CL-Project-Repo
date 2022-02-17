<?php

use Hotel\Booking;
use \DateTime;

require_once __DIR__ . '/../../boot/boot.php';

if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    header('Location: /');

    return;
}

//Create booking Param
$booking = new Booking();
$booking->insert($_REQUEST['room_id'], $_REQUEST['user_id'], $_REQUEST['check_in_date'], $_REQUEST['check_out_date']);
header('Location: /public/profile.php');
