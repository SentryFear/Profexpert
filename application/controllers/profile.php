<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Profile
 *
 * Профиль пользователя
 */
class Profile extends CI_Controller
{
    /**
     * Инифиализация
     */
    function __construct()
	{
		parent::__construct();

        //load helpers
		$this->load->helper(array('form', 'url'));

        //load request model
		//$this->load->model('request/request_model');

        //load request config
		//$this->config->load('request');
	}

    /**
     * Стартовая страница
     */
    function index()
	{
		$data = array();
		
		$data['success'] = $this->session->flashdata('success');
		
		$data['error'] = $this->session->flashdata('error');
		
		$id = $this->dx_auth->get_user_id();
		
		if($this->input->post('save')) {
			
			$save = array(
						'name' => $this->input->post('name'),
						'email' => $this->input->post('email'),
					);
			
			$config['upload_path'] = './uploads/img/sign/';
			//$config['allowed_types'] = 'doc|docx|xls|xlsx|pdf|txt|jpg|gif|jpeg';
			$config['max_size']	= '10000';
			$config['encrypt_name'] = true;
			
			$this->load->library('upload', $config);
			
			if($this->upload->do_upload('signature')) {
				
				$signature = $this->upload->data();
				
				$save['signature'] = $signature['file_name'];

			}
		
			if($this->db->update('users', $save, array('id' => $id))) $data['success'] = "Профиль изменён!";
			else $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
		}
		
		$user = $this->db->get_where('users', array('id' => $id))->row_array();
		
		$user['role_name'] = $this->dx_auth->get_role_name();
		
		$data['result'] = $user;
		
		echo $this->twig->render('profile/main.html', $data);
	}
}
?>