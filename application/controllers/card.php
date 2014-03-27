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
		
		$query = $this->db->get('card');
		
		$data['result'] = $query->result_array();
		
		echo $this->twig->render('card/main.html', $data);
	}
	
	function view()
	{
		$data = array();
	   
		$id = $this->uri->segment(3);
		
		$query = $this->db->get_where('card', array('id' => $id));
		
		$card = $query->row_array();
		
		$data['result'] = $card;

        if(!empty($data['result']['cсoments'])) $data['result']['cсoments'] = unserialize($data['result']['cсoments']);

		$query = $this->db->get_where('request', array('cid' => $card['id']));
		
		$request = $query->result_array();

        $this->config->load('request');

        $kpstatus = array_merge($this->config->item('kpstatus'), $this->config->item('history'));

        $users = $this->db->get('users')->result_array();

        foreach($request as $req) {

            $req['more'] = unserialize($req['more']);

            $data['result']['req'][$req['id']] = $req;

            $this->db->order_by('date', 'ASC');

            $query = $this->db->get_where('history', array('rid' => $req['id']));

            $history = $query->result_array();

            foreach($history as $k => $q) {

                $history1[$k] = $q;

                foreach($kpstatus as $i) {

                    if($i['dbname'] == $q['name']) {

                        $history1[$k]['name'] = $i['name'];

                        $history1[$k]['date'] = $q['date'];
                    }
                }
            }

            foreach($users as $w) {

                if($w['id'] == $req['mid']) $data['result']['req'][$req['id']]['nmid'] = $w['name'];

                if($w['id'] == $req['uid']) $data['result']['req'][$req['id']]['nuid'] = $w['name'];
            }

            $data['result']['req'][$req['id']]['history'] = $history1;
        }
		
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