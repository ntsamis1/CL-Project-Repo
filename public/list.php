<?php

require __DIR__ . '/../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;
use \DateTime;
use Hotel\User;

//init Room Service
$room = new Room();
$guest = new Room();

//init RoomType Service
$type = new RoomType();

//Get Page Parameters
$selectedCity = $_REQUEST['city'];
$selectedTypeId = $_REQUEST['room_type'];
$selectedGuestCount = $_REQUEST['guest_count'];
$selectedMinPrice = $_REQUEST['min_price'];
$selectedMaxPrice = $_REQUEST['max_price'];
$checkInDate = $_REQUEST['check_in_date'];
$checkOutDate = $_REQUEST['check_out_date'];

//search for room
$allAvailableRooms = $room->search(new DateTime($checkInDate), new DateTime($checkOutDate), $selectedCity, $selectedTypeId, $selectedGuestCount, $selectedMinPrice, $selectedMaxPrice);

//get user id
$user = new User();
$userId = $user->getCurrentUserId();

//get all cities
$cities = $room->getCities();

//get all room types
$allTypes = $type->getAllTypes();

//get all guest count
$guestCount = $guest->guestCount();

$minPrice = $room->getMinPrice();
$maxPrice = $room->getMaxPrice();

?>

<!DOCTYPE html>
<html lang="en">

<head>
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
    <main>
        <section class="hero-hotel-list">
            <div class="container-list">
                <aside class="search-form">
                    <form name="searchForm" class="searchForm" action="list.php">
                        <fieldset class="introduction" id="formSearch">
                            <legend>Find the perfect<p>hotel</p>
                            </legend>
                            <div class="grid-item">
                                <label for="guests"></label>
                                <select name="type_id">
                                    <option value="" disabled selected hidden>Room Type</option>
                                    <?php
                                    foreach ($allTypes as $roomType) {
                                    ?>
                                        <option value="<?php echo $selectedTypeId == $roomType ? 'selected="selected"' : '' ?>"><?php echo $roomType['title']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="grid-item">
                                <label for="guest_count"></label>
                                <select name="count_of_guests">
                                    <option value="" disabled selected hidden>Guest Count</option>
                                    <?php
                                    foreach ($guestCount as $count) {
                                    ?>
                                        <option value="<?php echo $count ?>"><?php echo $count ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="grid-item">
                                <label for="city"></label>
                                <select name="city">
                                    <option value="" disabled selected hidden>Select City</option>
                                    <?php
                                    foreach ($cities as $city) {
                                    ?>
                                        <option <?php echo $selectedCity == $city ? 'selected="selected"' : '' ?> value="<?php echo $city; ?>"><?php echo $city; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="grid-item">
                                <div class="price-input">
                                    <div class="field">
                                        <label for="minPrice"></label>
                                        <input type="number" class="input-min" name="min_price" min="<?php echo $minPrice['low'] ?>" max="<?php echo $maxPrice['high'] ?>" value="<?php echo $minPrice['low'] ?>" placeholder="Min Price">
                                    </div>
                                    <div class="field">
                                        <label for="maxPrice"></label>
                                        <input type="number" class="input-max" name="max_price" min="<?php echo $minPrice['low'] ?>" max="<?php echo $maxPrice['high'] ?>" value="<?php echo $maxPrice['high'] ?>" placeholder="Max Price">
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item-slider">
                                <div class="slider">
                                    <div class="progress">
                                    </div>
                                </div>
                                <div class="range-input">
                                    <input type="range" min="<?php echo $minPrice['low'] ?>" max="<?php echo $maxPrice['high'] ?>" class="range-min" value="<?php echo $minPrice['low'] ?>" step="10">
                                    <input type="range" min="<?php echo $minPrice['low'] ?>" max="<?php echo $maxPrice['high'] ?>" class="range-max" value="<?php echo $maxPrice['high'] ?>" step="10">
                                </div>
                            </div>
                            <div class="grid-item">
                                <label for="check-in"></label>
                                <input value="<?php echo $checkInDate ?>" placeholder="<?php echo $checkInDate ?>" name="check_in_date" class="textbox-n" type="text" onfocus="(this.type='date')" id="date">
                            </div>
                            <div class="grid-item">
                                <label for="check-out"></label>
                                <input value="<?php echo $checkOutDate ?>" placeholder="<?php echo $checkOutDate ?>" name="check_out_date" class="textbox-n" type="text" onfocus="(this.type='date')" id="date">
                            </div>
                            <div class="action text-center">
                                <input type="submit" value="Find Hotels">
                        </fieldset>
                    </form>
                </aside>
                <div id="search-results-container">
                    <section class="side-list">
                        <h1 class="title-list">Search Results</h1>
                        <br>
                        <?php
                        foreach ($allAvailableRooms as $availableRoom) {
                            $type_id = $availableRoom['type_id'];
                            $type = new RoomType();
                            $roomType = $type->getType($type_id);
                        ?>
                            <section class="hotel-info">
                                <section class="media">
                                    <img src="/public/assets/images/rooms/<?php echo $availableRoom['photo_url']; ?>" width="100%" height="auto" alt="Hotel Picture">
                                </section>
                                <section class="information">
                                    <h1><?php echo $availableRoom['name']; ?></h1>
                                    <h2><?php echo $availableRoom['city']; ?> , <?php echo $availableRoom['area']; ?></h2>
                                    <p><?php echo $availableRoom['description_short']; ?></p>
                                    <div class="text-right">
                                        <a class="cta" href="http://hotel.collegelink.localhost/public/room.php?room_id=<?php echo $availableRoom['room_id'] ?>&check_in_date=<?php echo $checkInDate ?>&check_out_date=<?php echo $checkOutDate ?>">Go to room page</a>
                                    </div>
                                </section>
                                <section class="details-bottom">
                                    <div class="details-price">
                                        <p>Per Night:<?php echo $availableRoom['price']; ?>€</p>
                                    </div>
                                    <div class="room-guests">

                                        <div class="details">
                                            <p>Count of Guests: <?php echo $availableRoom['count_of_guests']; ?></p>
                                        </div>
                                        <div class="details">
                                            <P>Type Of Room: <?php echo $roomType['title'] ?></P>
                                        </div>
                                    </div>
                                </section>
                            </section>
                        <?php
                        }
                        ?>
                        <?php
                        if (count($allAvailableRooms) == 0) {
                        ?>
                            <h2>There Are No Rooms Available!</h2>
                            <hr>
                        <?php
                        }
                        ?>
                    </section>
                </div>
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
    <script type="text/javascript">
        var lowPrice = <?php echo $minPrice['low'] ?>
    </script>
    <script src="/public/assets/js/app-jquery.js"></script>
    <script src="/public/assets/pages/search.js"></script>
</body>

</html>