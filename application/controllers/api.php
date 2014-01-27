<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property mixed notification
 */
class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //$this->dx_auth->check_uri_permissions();
    }

    function getNotification() {

        if($this->input->is_ajax_request()) {

            $lock = intval($this->uri->segment(3));

            if(empty($lock)) $lock = 0;

            echo $this->notification->getNotification($this->dx_auth->get_all_data(),$lock);

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

    function sendRequest() {

        header('Access-Control-Allow-Origin: *');

        if($this->session->userdata('DX_role_id')) {

            $this->session->set_userdata('DX_role_id', '0');
        }

        if($this->input->post('fname') && $this->input->post('phone')) {

            $_POST['zname'] = $this->input->post('fname');

            $result = "Произошла неожиданная ошибка, обратитесь к системному администратору.";

            $this->load->model('request/request_model');

            $this->load->library('notification');

            $id = $this->request_model->create_request();

            if($this->input->post('add') && !empty($id)) {

                $this->notification->setNotification('Заявка с сайта ['.$id.']', '/request/?sort=mSite', $id, 'Заявка с сайта', '3', '0');

                $result = "Заявка успешно добавлена!";

                $this->load->library('email');

                $this->email->from('admin@profexpert.com', 'PROFEXPERT');
                $this->email->to('df4210000@gmail.com');
                $this->email->cc('df4210000@gmail.com');
                $this->email->bcc('df4210000@gmail.com');

                $this->email->subject('Заявка с сайта');
                $message = '';
                $message .= 'Имя: '.$this->input->post('fname')."\n\r";
                $message .= 'EMail: '.$this->input->post('email')."\n\r";
                $message .= 'Телефон: '.$this->input->post('phone')."\n\r";
                $message .= 'Откуда узнали: '.$this->input->post('hear')."\n\r";
                $message .= 'Комментарий: '.$this->input->post('more')."\n\r";

                $this->email->message($message);

                $this->email->send();

            }

        } else {

            $result = "Не заполнены обязательные поля!";
        }

        echo json_encode($result);
    }
}