<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Card extends CI_Controller
{
   
	function __construct()
	{
		parent::__construct();
		
		$this->dx_auth->check_uri_permissions();
		
		$this->load->helper('url');
	}
	
	function index()
	{
		$data = array();
		
		$data['success'] = $this->session->flashdata('success');
		
		$data['error'] = $this->session->flashdata('error');
		
		$query = $this->db->get('cCard');
		
		$data['result'] = $query->result_array();
		
		echo $this->twig->render('card/main.html', $data);
	}
	
	function view()
	{
		$data = array();
	   
		$id = $this->uri->segment(3);
		
		$query = $this->db->get_where('cCard', array('id' => $id));
		
		$card = $query->row_array();
		
		$data['result'] = $card;
		
		$query = $this->db->get_where('request', array('cid' => $card['id']));
		
		$request = $query->row_array();
		
		$data['result'] += $request;

        $this->db->order_by('date', 'ASC');

        $query = $this->db->get_where('history', array('rid' => $request['id']));
		
		$history = $query->result_array();
		
		$this->config->load('request');
		
		$kpstatus = array_merge($this->config->item('kpstatus'), $this->config->item('history'));

        foreach($history as $k => $q) {

            $history1[$k] = $q;

            foreach($kpstatus as $i) {

                if($i['dbname'] == $q['name']) {

                    $history1[$k]['name'] = $i['name'];

                    $history1[$k]['date'] = $q['date'];
                }
            }

        }

		/*foreach($kpstatus as $k => $i) {
		
			$history1[$k] = $i;
		
			foreach($history as $q) {
		
				if($i['dbname'] == $q['name']) $history1[$k]['date'] = $q['date'];
			}
		
		}*/
      
		$data['result']['history'] = $history1;
		
		echo $this->twig->render('card/view.html', $data);
	}
	
	function add()
	{
		$data = array();
	   
		$data['region'] = $this->config->item('region');
	   
		$add = $this->input->post('add');
	   
		if(!empty($add)) {

			$this->request_model->create_request() ? $data['success'] = "������ ������� ���������!" : $data['error'] = "��������� ����������� ������, ���������� � ���������� ��������������.";
		}
		
		echo $this->twig->render('request/add.html', $data);
	}
	
	function edit()
	{
		$data = array();
      
		$data['region'] = $this->config->item('region');
      
		$id = $this->uri->segment(3);
      
		if(!empty($id)) {
         
			$add = $this->input->post('add');
         
			if(!empty($add)) {

				$this->request_model->update_request($id) ? $data['success'] = "������ ������� ��������!" : $data['error'] = "��������� ����������� ������, ���������� � ���������� ��������������.";
			}
         
			$data['result'] = $this->request_model->get_request($id);
		   
			echo $this->twig->render('request/edit.html', $data);
      
		} else {
         
			redirect("/request");
		}
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
	   
		if(!empty($id)) {
         
			$this->db->delete('request', array('id' => $id)) ? $this->session->set_flashdata('success', '������ ������� �������.') : $this->session->set_flashdata('error', '��������� ����������� ������, ���������� � ���������� ��������������.');
		}

		redirect("/request");
	}
}
?>