<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property mixed notification
 */
class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function getNotification() {

        if($this->input->is_ajax_request()) {

            echo $this->notification->getNotification($this->dx_auth->get_all_data());

        } else {

            echo 'err';
        }
    }
}