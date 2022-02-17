<?php

require __DIR__ . '/../../boot/boot.php';

use Hotel\Room;
use Hotel\RoomType;
// use \DateTime;
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

<section class="side-list">
    <h1 class="title-list">Search Results From Ajax</h1>
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