<?php

namespace Hotel;

use PDO;
use DateTime;
use Exception;
use Hotel\BaseService;
use Support\Configuration\Configuration;


class Room extends BaseService
{

    public function get($roomId)
    {
        $parameters = [
            ':room_id' => $roomId,
        ];

        return $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
    }


    public function getCities()
    {
        //get cities
        $cities = [];
        try {
            $rows = $this->fetchAll('SELECT DISTINCT city FROM room');
            foreach ($rows as $row) {
                $cities[] = $row['city'];
            }
        } catch (Exception $ex) {
            //log error
        }

        return $cities;
    }

    public function guestCount()
    {
        $guests = [];
        $countGuests = $this->fetchAll('SELECT DISTINCT count_of_guests FROM room');
        foreach ($countGuests as $countGuest) {
            $guests[] = $countGuest['count_of_guests'];
        }
        return $guests;
    }

    public function getMinPrice()
    {
        $minPrice = $this->fetch('SELECT MIN(price) AS low FROM room');
        return $minPrice;
    }

    public function getMaxPrice()
    {
        $maxPrice = $this->fetch('SELECT MAX(price) AS high FROM room');
        return $maxPrice;
    }

    public function search($checkInDate, $checkOutDate, $city = '', $typeId = '', $guestCount = '', $minPrice = '', $maxPrice = '')
    {
        //set up params
        $parameters = [
            ':check_in_date' => $checkInDate->format(DateTime::ATOM),
            ':check_out_date' => $checkOutDate->format(DateTime::ATOM),
        ];
        if (!empty($city)) {
            $parameters[':city'] = $city;
        }
        if (!empty($guestCount)) {
            $parameters['count_of_guests'] = $guestCount;
        }
        if (!empty($typeId)) {
            $parameters[':type_id'] = $typeId;
        }
        if (!empty($minPrice)) {
            $parameters[':min_price'] = $minPrice;
        }
        if (!empty($maxPrice)) {
            $parameters[':max_price'] = $maxPrice;
        }

        //build query
        $sql = 'SELECT * FROM room WHERE ';
        if (!empty($city)) {
            $sql .= 'city = :city AND ';
        }
        if (!empty($guestCount)) {
            $sql .= 'count_of_guests = :count_of_guests AND ';
        }
        if (!empty($typeId)) {
            $sql .= 'type_id = :type_id AND ';
        }
        if (!empty($minPrice) && !empty($maxPrice)) {
            $sql .= 'price BETWEEN :min_price AND :max_price AND ';
        }
        $sql .= 'room_id NOT IN (
            SELECT room_id 
            FROM booking 
            WHERE check_in_date <= :check_out_date AND check_out_date >= :check_in_date
        )';
        //get results
        return $this->fetchAll($sql, $parameters);
    }
}

// WHERE check_out_date <= :check_in_date OR check_in_date >= :check_out_date