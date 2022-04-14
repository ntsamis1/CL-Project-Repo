<?php

require __DIR__ . '/../boot/boot.php';

use Hotel\Room;
use Hotel\Favorite;
use Hotel\Review;
use Hotel\User;
use Hotel\RoomType;
use Hotel\Booking;

//init Room Service
$room = new Room();

//init Favorite Service
$favorite = new Favorite();

//check for room id
$roomId = $_REQUEST['room_id'];

if (empty($roomId)) {
    header('Location: index.php');
    return;
}

//load room info
$roomInfo = $room->get($roomId);
if (empty($roomInfo)) {
    header('Location: index.php');
    return;
}

//load booking info
$checkIn = $_REQUEST['check_in_date'];
$checkOut = $_REQUEST['check_out_date'];

//get user id
$userId = User::getCurrentUserId();

//check if room is favorite for current user
$isFavorite = $favorite->isFavorite($roomId, $userId);

//load all room Reviews
$review = new Review();

//get room type
$type = new RoomType();
$roomType = $type->getType($roomId);

//get Reviews
$allReviews = $review->getReviewsByRoom($roomId);


//init booking service
$booking = new Booking();
$isBooked = $booking->isBooked($roomId, $checkIn, $checkOut);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/assets/css/styles.css" />
    <link rel="stylesheet" href="/public/assets/css/fontawesome-free-5.15.4-web/fontawesome-free-5.15.4-web/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css" />
    <title>Hotels-Room Details</title>
</head>

<body>
    <header>
        <?php
        if (!empty($userId)) {
        ?>
            <div class="container-flex">
                <p class="main-logo">Hotels</p>
                <div class="primary-menu text-right">
                    <ul>
                        <li>
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="dropdown">
                                <i class="fas fa-user"></i>
                                Profile
                                <div class="dropdown-content">
                                    <a href="profile.php">My Profile</a>
                                    <a href="#" onclick="delete_cookie('user_token');return false;">Log Out</a>
                                </div>
                            </div>
                    </ul>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="container-flex">
                <p class="main-logo">Hotels</p>
                <div class="primary-menu text-right">
                    <ul>
                        <li>
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="dropdown">
                                <i class="fas fa-user"></i>
                                My Account
                                <div class="dropdown-content">
                                    <a href="login.php">Log In</a>
                                    <a href="register.php">Sign Up</a>
                                </div>
                            </div>
                    </ul>
                </div>
            </div>
        <?php
        }
        ?>
    </header>

    <div class="container-room">
        <section class="title">
            <?php echo sprintf('%s - %s, %s |', $roomInfo['name'], $roomInfo['city'], $roomInfo['area']) ?>
            <div class="title-details-room">
                <h4>REVIEWS</h4>
                <div class="stars">
                    <?php
                    $roomAvgReview = $roomInfo['avg_reviews'];
                    for ($i = 1; $i <= 5; $i++) {
                        if ($roomAvgReview >= $i) {
                    ?>
                            <span class="fas fa-star"></span>
                        <?php
                        } else {
                        ?>
                            <span class="far fa-star"></span>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="title-details-room" id="favorite">
                <form name="favoriteForm" method="post" id="favoriteForm" class="favoriteForm" action="actions/favorite.php">
                    <input type="hidden" name="room_id" value="<?php echo $roomId; ?>">
                    <input type="hidden" name="is_favorite" value="<?php echo $isFavorite ? '1' : '0'; ?>">
                    <div class="search_stars_div">
                        <ul class="fav_star">
                            <button type="submit">
                                <span class="star <?php echo $isFavorite ? 'fas fa-heart' : 'far fa-heart'; ?>"></span>
                            </button>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="title-details-room">
                Per Night: <?php echo $roomInfo['price'] ?> €
            </div>
        </section>
        <img src="/public/assets/images/rooms/<?php echo $roomInfo['photo_url'] ?>" alt="room">
        <section class="details-room">
            <div class="list-details-room">
                <i class="fa fa-user"> <?php echo $roomInfo['count_of_guests'] ?></i>
                <p>COUNT OF GUESTS</p>
            </div>
            <div class="list-details-room">
                <i class="fa fa-bed"> <?php echo $roomType['title'] ?></i>
                <p>TYPE OF ROOM</p>
            </div>
            <div class="list-details-room">
                <i class="fa fa-parking"> <?php echo $roomInfo['parking'] ? " Yes" : " No" ?></i>
                <p>PARKING</p>
            </div>
            <div class="list-details-room">
                <i class="fa fa-wifi"> <?php echo $roomInfo['wifi'] ? " Yes" : " No" ?></i>
                <p>WIFI</p>
            </div>
            <div class="list-details-room">
                <i class="fa fa-paw"> <?php echo $roomInfo['pet_friendly'] ? " Yes" : " No" ?></i>
                <p>PET FRIENDLY</p>
            </div>
        </section>
        <section class="room-decription">
            <h4>Room Description</h4>
            <p><?php echo $roomInfo['description_long'] ?></p>
        </section>
        <?php
        if ($isBooked) { ?>
            <button disabled class="room-details-btn-booked">Already Booked</button>
        <?php } else {
        ?>
            <form method="POST" action="actions/booking.php">
                <input type="hidden" name="user_id" value="<?php echo $userId ?>" />
                <input type="hidden" name="room_id" value="<?php echo $roomId ?>" />
                <input type="hidden" name="check_in_date" value="<?php echo $checkIn ?>" />
                <input type="hidden" name="check_out_date" value="<?php echo $checkOut ?>" />
                <button type="submit" class="room-details-btn">Book Now</button>
            </form>
        <?php } ?>
        <iframe width="300" height="170" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $roomInfo['location_lat'] ?>,<?php echo $roomInfo['location_long'] ?>&hl=en&z=14&amp;output=embed">
        </iframe>
        <section class="room-reviews">
            <h4>Reviews</h4>
            <div id="room-reviews-container">
                <?php
                foreach ($allReviews as $counter => $review) {
                ?>
                    <div class="user-review">
                        <p><?php echo sprintf('%d. %s', $counter + 1, $review['user_name']); ?></p>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($review['rate'] >= $i) {
                        ?>
                                <span class="fas fa-star"></span>
                            <?php
                            } else { ?>
                                <span class="far fa-star"></span>
                        <?php
                            }
                        }
                        ?>
                        <h5>Created at: <?php echo $review['created_time'] ?> </h5>
                        <p><?php echo htmlentities($review['comment']); ?></p>
                        <br>
                    </div>
                <?php }
                ?>
            </div>
        </section>
        <section class="add-review">
            <h4>Add Review</h4>
            <form name="reviewForm" class="reviewForm" method="post" action="/public/actions/review.php">
                <input type="hidden" name="room_id" value="<?php echo $roomId ?>" />
                <fieldset class="rating">
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label class="fas fa-star" for="star5" title="5 STARS"></label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label class="fas fa-star" for="star4" title="4 STARS"></label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label class="fas fa-star" for="star3" title="3 STARS"></label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label class="fas fa-star" for="star2" title="2 STARS"></label>
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label class="fas fa-star" for="star1" title="1 STAR"></label>
                </fieldset>
                <div class="comment_input">
                    <textarea name="comment" id="reviewField" class="form-control_landing review-textarea" placeholder="Write Your Review" data-validation-required-message="Please enter a review"></textarea>
                </div>
                <div class="form-group_landing">
                    <button class="btn_landing btn-brick" type="submit">Submit</button>
                </div>
            </form>
        </section>
    </div>
    <!-- Footer -->
    <footer>
        <p>(c) Copyright CollegeLink 2020</p>
    </footer>
    <!-- Scripts -->
    <script type="text/javascript">
        function delete_cookie(name) {
            document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            location.assign('http://hotel.collegelink.localhost/public/index.php');
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="/public/assets/js/app-jquery.js"></script>
    <script src="/public/assets/pages/room.js"></script>
</body>

</html>