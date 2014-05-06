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

    function getAutocomplete() {

        //$this->output->enable_profiler(TRUE);

        if($this->input->is_ajax_request()) {

           if($this->uri->segment(3)) {

               $tbl = $this->uri->segment(3);

               if(strpos($tbl, '5') !== FALSE) {

                   $tbl = explode('5', $tbl);

               } else {

                   $tbl = array();

                   $tbl[] = $this->uri->segment(3);
               }

           } else {

               exit('err');
           }

            if($this->uri->segment(4)) {

                $pole = $this->uri->segment(4);

            } else {

                exit('err');
            }

            if($this->input->get('term')) {

                $term = $this->input->get('term');

            } else {

                exit('err');
            }

            $result = array();

            foreach($tbl as $i) {

                $this->db->select($pole);

                $this->db->like($pole, $term);

                $this->db->order_by($pole, 'asc');

                $res = $this->db->get($i, 20, 0);

                foreach($res->result_array() as $row) {

                    $result[] = $row[$pole];
                }
            }

            $result = array_unique($result);

            echo json_encode($result);

        } else {

            echo 'err';
        }
    }

    function getChat() {


    }

    function sendRequest() {

        header('Access-Control-Allow-Origin: *');

        if($this->session->userdata('DX_role_id')) {

            $this->session->set_userdata('DX_role_id', '0');
        }

        if($this->input->post('fname') && $this->input->post('phone')) {

            $_POST['zname'] = $this->input->post('fname');

            if(empty($_POST['more'])) $_POST['more'] = 'Обратный звонок';

            $result = "Произошла неожиданная ошибка, обратитесь к системному администратору.";

            $this->load->model('request/request_model');

            $this->load->library('notification');

            $id = $this->request_model->create_request();

            if($this->input->post('add') && !empty($id)) {

                $this->notification->setNotification('Заявка с сайта ['.$id.']', '/request/?sort=mSite', $id, 'Заявка с сайта', '3', '0');

                $result = "<b>СПАСИБО!</b><br>Наш менеджер свяжется с Вами в ближайшее время.";

                $this->load->library('email');

                $this->email->from('admin@profexpert.com', 'PROFEXPERT');
                $this->email->to('df4210000@gmail.com');

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