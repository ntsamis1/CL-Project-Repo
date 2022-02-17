<?php

require __DIR__ . '/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;
use Hotel\User;
use \DateTime;

//get Cities
$room = new Room();
$cities = $room->getCities();

//get room types
$type = new RoomType();
$allTypes = $type->getAllTypes();

//get user id
$user = new User();
$userId = $user->getCurrentUserId();

?>

<!DOCTYPE>
<html>

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
                            <a href="index.php" target="_blank">
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
                            <a href="index.php" target="_blank">
                                <i class="fas fa-home"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="dropdown">
                                <i class="fas fa-user" target="_blank"></i>
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
    <main>
        <section class="hero">
            <div class="hero-container">
                <form name="searchForm" action="list.php">
                    <div class="grid-item">
                        <label for="city"></label>
                        <select name="city" class="form-control_landing" id="city" data-placeholder="City">
                            <option value="" disabled selected hidden>City</option>
                            <?php
                            foreach ($cities as $city) {
                            ?>
                                <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="grid-item">
                        <label for="room-type"></label>
                        <select name="room_type" class="form-control_landing" placeholder="Room Type">
                            <option value="" disabled selected hidden>Room Type</option>
                            <?php
                            foreach ($allTypes as $roomType) {

                            ?>
                                <option value="<?php echo $roomType['type_id']; ?>"><?php echo $roomType['title']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="grid-item">
                        <label for="check-in"></label>
                        <input placeholder="Check In" name="check_in_date" class="textbox-n" type="text" onfocus="(this.type='date')" id="check-in-date" />
                    </div>

                    <div class="grid-item">
                        <label for="check-out"></label>
                        <input placeholder="Check Out" name="check_out_date" class="textbox-n" type="text" onfocus="(this.type='date')" id="check-out-date" />
                    </div>

                    <div class="action text-center">
                        <input id="submit-btn" type="submit" value="Search" />
                </form>
            </div>
        </section>
    </main>
    <footer>
        <p>(c) Copyright CollegeLink 2020</p>
    </footer>
    <script type="text/javascript">
        function delete_cookie(name) {
            document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            location.assign('http://hotel.collegelink.localhost/public/index.php');
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="/public/assets/js/app-jquery.js"></script>
    <script src="/public/assets/js/index.js"></script>
</body>

</html>