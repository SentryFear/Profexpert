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

    function lockNotification() {

        if($this->input->is_ajax_request()) {

            $id = intval($this->uri->segment(3));

            if(!empty($id)) {

                echo json_encode($this->notification->lockNotification($id));

            } else {

                echo 'err';
            }

        } else {

            echo 'err';
        }
        //echo $this->notification->getNotification($this->dx_auth->get_all_data());
    }

    function getStatus() {

        if($this->input->is_ajax_request()) {

            $this->load->model('request/request_model');

            $result = $this->request_model->get_request($id = null, $view = 'json', $sort = 'all');

            echo json_encode($result);

        } else {

            echo 'err';
        }
    }
}