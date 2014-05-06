<?php
/*
|--------------------------------------------------------------------------
| Прошедшее время после показа или удаления уведомления
|--------------------------------------------------------------------------
|
| $time = number
|   - Время показа или удаления уведомления
|
*/
if (!function_exists('time_to_notify')) {

    function time_to_notify($time)
    {
        $time = time() - $time;

        $dtTime = $time." сек.";

        if($time > 60) $dtTime = round($time/60)." мин.";

        if($time > 3600) $dtTime = round($time/3600)." ч.";

        if($time > 86400) $dtTime = round($time/86400)." дн.";

        if($time > 604800) $dtTime = round($time/604800)." нед.";

        if($time > 2419200) $dtTime = round($time/2419200)." мес.";

        if($time > 31536000) $dtTime = round($time/31536000)." г.";

        return $dtTime;
    }
}