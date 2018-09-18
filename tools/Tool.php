<?php

namespace app\tools;

class Tool {

    public static function getFormattedTime($date) {

        $res = substr($date, 0, 10);
        $year = substr($res, 0, 4);
        $month = substr($res,5, 2);
        $day = substr($res, 8, 3);
        return $day . '/' . $month . '/' . $year;
    }

}
