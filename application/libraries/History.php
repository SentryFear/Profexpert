<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class History
 *
 * История изменения чего либо
 */
class History {

    var $CI;

    /**
     * Инициализация класса
     */
    function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * Добавить в историю
     */
    function setHistory($name, $rid)
    {
        $insert = array(
            'name' => $name,
            'date' => time(),
            'rid' => $rid
        );

        return $this->CI->db->insert('history', $insert);
    }
}