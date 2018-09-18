<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\config;

class Status {

    const ON = 1; //Marks Present 
    const OFF = 0; //Marks Absent
    const PURCHASED = 1; //Marks Purchase
    const NON_PURCHASED = 0; //Marks Non purchased

    //Returns statuses

    public static function getStatuses() {
        return [
            self::ON => 'Present',
            self::OFF => 'Absent'
        ];
    }

    //Returns Shippment Status
    public static function getShipmentStatus() {
        return [
            self::NON_PURCHASED => 'Non Purchased',
            self::PURCHASED => 'Purchased'
        ];
    }

}
