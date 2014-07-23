<?php
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 23.07.14
 * Time: 10:26
 */
if (!function_exists('users_time')) {

    /*
     * $time - реальное время или unix time
     */
    function users_time($time)
    {
        $result = '';

        if(count(explode(' ', $time)) > 1) {

            $dt_elements = explode(' ', $time);

            $date_elements = explode('-',$dt_elements[0]);

            $time_elements =  explode(':',$dt_elements[1]);

            $result = mktime($time_elements[0],$time_elements[1],$time_elements[2], $date_elements[1],$date_elements[2], $date_elements[0]);

            $time = time() - $result;

        }

        if($time > 31536000) {

            $dtTime = floor($time/31536000)." г. ";

            $tm = $time - (31536000*floor($time/31536000));

            if($tm > 0) $dtTime .= users_time($tm);

        } elseif($time > 2419200) {

            $dtTime = floor($time/2419200)." мес. ";

            $tm = $time - (2419200*floor($time/2419200));

            if($tm > 0) $dtTime .= users_time($tm);

        } elseif($time > 86400) {

            $dtTime = floor($time/86400)." дн. ";

            $tm = $time - (86400*floor($time/86400));

            if($tm > 0) $dtTime .= users_time($tm);

        } elseif($time > 3600) $dtTime = floor($time/3600)." ч.";
        elseif($time > 60) $dtTime = floor($time/60)." мин.";
        else $dtTime = $time." сек.";

        return $dtTime;
    }
}