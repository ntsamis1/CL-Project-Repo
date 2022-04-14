<?php

require __DIR__ . '/../boot/boot.php';

use Hotel\Room;
use Hotel\Favorite;
use Hotel\Review;
use Hotel\User;
use Hotel\Booking;
use Hotel\RoomType;

//init Room Service
$room = new Room();

//get user id
$userId = User::getCurrentUserId();

//check for logged in user//
if (empty(User::getCurrentUserId())) {
    header('Location: index.php');
    return;
}

$favorite = new Favorite();
$userFavorites = $favorite->getListByUser($userId);

//get all reviews
$review = new Review();
$userReviews = $review->getListByUser($userId);

//get all user bookings
$booking = new Booking();
$userBookings = $booking->getListByUser($userId);

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
    <title>Hotels-User Profile</title>
</head>

<body>
    <!-- Header -->
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
    <!-- The container for aside and list results -->
    <div class="container-profile">
        <!-- Aside Bar -->
        <aside class="aside-profile">
            <h3>FAVORITES</h3>
            <?php
            if (count($userFavorites) > 0) {
            ?>
                <ol>
                    <?php
                    foreach ($userFavorites as $favorite) {
                    ?>
                        <li>
                            <h3>
                                <a href="/public/room.php?room_id=<?php echo $favorite['room_id']; ?>">
                                    <?php echo $favorite['name']; ?>
                                </a>
                            </h3>
                        </li>
                    <?php
                    }
                    ?>
                </ol>
            <?php } else {
            ?>
                <h4>You don't have any favorite hotel!!</h4>
            <?php
            } ?>
            <h3>REVIEWS</h3>
            <?php
            if (count($userReviews) > 0) {
            ?>
                <ol>
                    <?php foreach ($userReviews as $review) {
                    ?>
                        <li>
                            <h3>
                                <a href="/public/room.php?room_id=<?php echo $review['room_id']; ?>">
                                    <?php echo $review['name']; ?>
                                </a>
                            </h3>
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($review['rate'] >= $i) {
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
                        </li>
                    <?php } ?>
                </ol>
            <?php
            } else {
            ?>
                <h4>You haven't made any reviews!</h4>
            <?php
            }
            ?>
        </aside>
        <!-- List of results -->
        <section class="results-profile">
            <h3 class="booking-results-profile">MY BOOKINGS</h3>
            <?php if (count($userBookings) > 0) {
            ?>
                <?php foreach ($userBookings as $booking) { ?>
                    <div class="list-results-profile">
                        <img src="/public/assets/images/rooms/<?php echo $booking['photo_url'] ?>" alt="room">
                        <div class="result-item-profile">
                            <h3 class="item-title"><?php echo $booking['name'] ?></h3>
                            <h4 class="item-area-profile"><?php sprintf("%s , %s", $booking['city'], $booking['area']) ?></h4>
                            <p class="item-description-profile"><?php echo $booking['description_short'] ?></p>
                            <a href="/public/room.php?room_id=<?php echo $booking['room_id'] ?>" class="button">Go to Room Page</a>
                        </div>
                    </div>
                    <div class="result-item-info-profile">
                        <p class="total-price">Total Price: <?php echo $booking['total_price'] ?></p>
                        <p class="check-in-date">CheckIn Date: <?php echo $booking['check_in_date'] ?></p>
                        <p class="check-out-date">CheckOut Date: <?php echo $booking['check_out_date'] ?></p>
                        <p class="type-room">Type of Room: <?php echo $booking['room_type'] ?></p>
                    </div>
                <?php }
            } else {
                ?>
                <h4>You dont have any previews bookings!</h4>
            <?php
            } ?>
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
</body>

</html>