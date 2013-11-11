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

        $this->CI->load->helper('Notification');
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
    function getNotification($user_info)
    {
        $notify = $this->CI->db->get('notification')->result_array();

        foreach($notify as $i) {

            if( (isset($i['role']) && $user_info['role_id'] == $i['role']) || (isset($i['user']) && $user_info['user_id'] == $i['user']) || (empty($i['user']) && empty($i['role']) )) {

                $i['time'] = time_to_notify($i['time']);

                $this->notify[] = $i;
            }
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