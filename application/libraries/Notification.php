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

    /**
     * Инициализация уведомлений
     */
    function __construct()
    {
        
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