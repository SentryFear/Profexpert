<?php
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 24.09.14
 * Time: 17:47
 */

if (!function_exists('tasks_get_status')) {

    //type 1 = ответсвенный
    //type 2 = выдавший поручение
    //type 3 = ответсвенный и выдавший одно и тоже лицо
    //if (!empty($i['uri'])) $html_status .= '<a href="' . $i['uri'] . '' . $extra['id'] . '/" '.$self.' id="'.$extra['id'].'"  data-ind="' . $extra['id'] . '" data-loading-text="loading..." class="label label-' . $i['class'] . ' fat-btn"  data-toggle="tooltip" data-original-title="' . $i['fullname'] . '">' . $i['name'] . '</a>&nbsp;';

    //if (empty($i['uri'])) $html_status .= '<span class="label label-' . $i['class'] . '" data-toggle="tooltip" data-original-title="' . $i['fullname'] . '">' . $i['name'] . '</span>&nbsp;';

    function tasks_get_status($array = array())
    {
        $return = '';

        if($array['type'] == 1) {

            if($array['status'] == 0) $return = '<a href="/tasks/send/take/'.$array['id'].'" id="'.$array['id'].'"  data-ind="' . $array['id'] . '" data-loading-text="loading..." class="label label-warning fat-btn"  data-toggle="tooltip" data-original-title="Взяться за поручение">Забрать</a>&nbsp;';
            elseif($array['status'] == 1) $return = '<a href="/tasks/send/success/'.$array['id'].'" id="'.$array['id'].'"  data-ind="' . $array['id'] . '" data-loading-text="loading..." class="label label-warning fat-btn"  data-toggle="tooltip" data-original-title="Нажмите если завершили выполнение задания">Завершить</a>&nbsp;';
            elseif($array['status'] == 2) $return = '<span class="label label-success" data-toggle="tooltip" data-original-title="Задача выполнена">Выполнено</span>&nbsp;';

        } elseif($array['type'] == 2) {

            if($array['status'] == 0) $return = '<span class="label label-info" data-toggle="tooltip" data-original-title="Задача выдана">Выдано</span>&nbsp;';
            elseif($array['status'] == 1) $return = '<span class="label label-warning" data-toggle="tooltip" data-original-title="Задача выполнена">В работе</span>&nbsp;';
            elseif($array['status'] == 2) $return = '<span class="label label-success" data-toggle="tooltip" data-original-title="Задача выполнена">Выполнено</span>&nbsp;';

        } elseif($array['type'] == 3) {

            if($array['status'] == 0) $return = '<a href="/tasks/send/success/'.$array['id'].'" id="'.$array['id'].'"  data-ind="' . $array['id'] . '" data-loading-text="loading..." class="label label-warning fat-btn"  data-toggle="tooltip" data-original-title="Нажмите если завершили выполнение задания">Завершить</a>&nbsp;';
            elseif($array['status'] == 1) $return = '<span class="label label-warning" data-toggle="tooltip" data-original-title="Задача выполнена">В работе</span>&nbsp;';
            elseif($array['status'] == 2) $return = '<span class="label label-success" data-toggle="tooltip" data-original-title="Задача выполнена">Выполнено</span>&nbsp;';
        }

        return $return;
    }
}

if (!function_exists('short_user_name')) {

    function short_user_name($name) {

        $result = '';

        $name = explode(' ', $name);

        $result = $name[0];

        if(isset($name[1])) $result .= " " . mb_substr($name[1],0,1,'utf-8') . ".";

        if(isset($name[2])) $result .= " " . mb_substr($name[2],0,1,'utf-8') . ".";

        return $result;
    }
}