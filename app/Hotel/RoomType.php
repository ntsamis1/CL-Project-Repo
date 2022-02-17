<?php

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;
use Support\Configuration\Configuration;


class RoomType extends BaseService
{
    public function getAllTypes(){
        //get types
       return $this->fetchAll('SELECT * FROM room_type');
    }

    
    public function getType($typeId){
        $sql = 'SELECT * FROM room_type WHERE type_id = :type_id';
        $parameters[':type_id'] = $typeId;
        return $this->fetch($sql, $parameters);
    }
}