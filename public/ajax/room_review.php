<?php

use Hotel\Review;
use Hotel\User;

require_once __DIR__ . '/../../boot/boot.php';


//check method 
if (strtolower($_SERVER['REQUEST_METHOD']) != 'post') {
    echo "This is a post script.";
    die;
}

//if there is already logged user, return to home page
if (empty(User::getCurrentUserId())) {
    echo "No current user for this operation.";
    die;
}

//check if room id is given
$roomId = $_REQUEST['room_id'];
if (empty($roomId)) {
    echo "No room is given for this operation.";
    die;
}

//set Review
$review = new Review();
//Get all reviews
$roomReviews = $review->getReviewsByRoom($roomId);
$counter = count($roomReviews);
$review->insert($roomId, User::getCurrentUserId(), $_REQUEST['rate'], $_REQUEST['comment']);


// Load User
$user = new User();
$userInfo = $user->getByUserId(User::getCurrentUserId());

?>

<div class="user-review">
    <p><?php echo sprintf('%d. %s', $counter + 1, $userInfo['name']); ?></p>
    <?php
    for ($i = 1; $i <= 5; $i++) {
        if ($_REQUEST['rate'] >= $i) {
    ?>
            <span class="fas fa-star"></span>
        <?php
        } else { ?>
            <span class="far fa-star"></span>
    <?php
        }
    }
    ?>
    <h5>Created at: <?php echo (new DateTime())->format('Y-m-d H:i:s'); ?> </h5>
    <p><?php echo htmlentities($_REQUEST['comment']); ?></p>
    <br>
</div>