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
    function setNotification($name, $uri, $id, $text, $role, $user)
    {
        $insert = array(
            'name' => $name,
            'uri' => $uri,
            'rid' => $id,
            'text' => $text,
            'time' => time(),
            'role' => $role,
            'user' => $user
        );

        return $this->CI->db->insert('notification', $insert);
    }

    /**
     * Выбрать все уведомления
     */
    function getNotification($user_info, $lock)
    {
        $this->CI->db->order_by('time', 'desc');

        if($lock != 1)  $this->CI->db->where('lock', $lock);

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
    function lockNotification($id)
    {
        $update = array(
            'lock' => 1
        );

        return $this->CI->db->update('notification', $update, array('id' => $id));
    }

    /**
     * Установить время через которое уведомление отправится
     */
    function setTimeNotification()
    {

    }
}