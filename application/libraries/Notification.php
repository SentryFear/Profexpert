<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Notification
 */
class Notification {

    /**
     * Заголовок уведомления
     *
     * @var string
     */
    var $name;

    /**
     * Ссылка уведомления
     *
     * @var string
     */
    var $uri;

    /**
     * Тело уведомления
     *
     * @var string
     */
    var $text;

    /**
     * Время уведомления
     *
     * @var int
     */
    var $time;

    /**
     * Отложено ли уведомление
     *
     * @var bool
     */
    var $lock;

    var $notify = array();

    /**
     * Инициализация уведомлений
     */
    function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * Добавить уведомление
     */
    function setNotification()
    {

    }

    /**
     * Выбрать все уведомления
     */
    function getNotification()
    {
        $notify = array(
            array('name' => 'test', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381119536', 'lock' => '0'),
            array('name' => 'test1', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381039536', 'lock' => '0'),
            array('name' => 'test2', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1380139536', 'lock' => '0'),
            array('name' => 'test3', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1351139536', 'lock' => '0'),
            array('name' => 'test4', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1331139536', 'lock' => '0'),
            array('name' => 'test5', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381139536', 'lock' => '0'),
            array('name' => 'test6', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381139536', 'lock' => '0'),
            array('name' => 'test7', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381139536', 'lock' => '0'),
            array('name' => 'test8', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381139536', 'lock' => '0'),
            array('name' => 'test9', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381139536', 'lock' => '0'),
            array('name' => 'test10', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381139536', 'lock' => '0'),
            array('name' => 'test11', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381139536', 'lock' => '0'),
            array('name' => 'test12', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381139536', 'lock' => '0'),
            array('name' => 'test12', 'uri' => '/request', 'text' => 'тестовое уведомление', 'time' => '1381139536', 'lock' => '0')
        );

        foreach($notify as $i) {

            $i['time'] = time() - $i['time']." сек.";

            if($i['time'] > 31536000) $i['time'] = round($i['time']/31536000)." г.";
            elseif($i['time'] > 2419200) $i['time'] = round($i['time']/2419200)." мес.";
            elseif($i['time'] > 604800) $i['time'] = round($i['time']/604800)." нед.";
            elseif($i['time'] > 86400) $i['time'] = round($i['time']/86400)." дн.";
            elseif($i['time'] > 3600) $i['time'] = round($i['time']/3600)." ч.";
            elseif($i['time'] > 60) $i['time'] = round($i['time']/60)." мин.";

            $this->notify[] = $i;
        }

        $this->notify = json_encode($this->notify);

        return $this->notify;
    }

    /**
     * Проверить есть ли новые уведомления
     */
    function checkNotification()
    {

    }

    /**
     * Отложить уведомление
     */
    function lockNotification()
    {

    }

    /**
     * Установить время через которое уведомление отправится
     */
    function setTimeNotification()
    {

    }
}