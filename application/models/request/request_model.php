<?php

/**
 * Class request_model
 */
class request_model extends CI_Model
{
    /**
     *
     */
    function __construct()
	{
		parent::__construct();	
	}

    /**
     * @return bool
     */
    function create_request() {
	   
		$suc = 0;

        //Карточка клиента
		$form = $this->config->item('access');
		
		foreach($form as $i) {
			
			if(!isset($i['form']) || $i['form'] != 0) {
				
				$insert1[$i['value']] = $this->input->post($i['value']);
			}
		}
		
		$insert1['razd'] = '';
		
		$insert1['instance'] = '';

		if($this->db->insert('cCard', $insert1)) $suc+=1;
		//end карточка клиента
		
		//Заявка
		$mid = 0;
		
		$roleid = $this->dx_auth->get_role_id();
		
		if($roleid == 3) $mid = $this->dx_auth->get_user_id();
		
		$insert = array(
			'date' => time(),
			//'kp' => $this->input->post('kp'),
			'mid' => $mid,
			//'history' => $this->input->post('history'),
			'cid' => $this->db->insert_id()
		);
      
		if($this->db->insert('request', $insert)) $suc+=1;
		//end Заявка
      
		//История
		$kpstatus = $this->config->item('kpstatus');
      
		$insert2 = array(
			'name' => $kpstatus[0]['dbname'],
			'date' => time(),
			'rid' => $this->db->insert_id()
		);
      
		if($this->db->insert('history', $insert2)) $suc+=1;
		//end История
      
		return $suc == 3 ? true : false;
	}

    /**
     * @return mixed
     */
    function add_docs() {
      
		$id = $this->input->post('id');
	      
		$config['upload_path'] = './uploads/';
		//$config['allowed_types'] = 'doc|docx|xls|xlsx|pdf|txt|jpg|gif|jpeg';
		$config['max_size']	= '10000';
		$config['encrypt_name'] = true;

		$this->load->library('upload', $config);
     
		$author = $this->dx_auth->get_username();
     
		$data['success'] = '';
		
		$docs1 = array();

        $row = $this->db->get_where('request', array('id' => $id))->row_array();

		//$row = $query->row_array();
     
		$docs = unserialize($row['docs']);
		
		if(empty($docs)) $docs = array();
		
		foreach($docs as $q) {
			
			$q['name'] = $this->input->post('name'.$q['id']);
			
			if($this->upload->do_upload('doc'.$q['id'])) {
				
				$dt = $this->upload->data();
				
				$q['file'] = $dt['file_name'];
				
				$q['date'] = time();
				
				$q['author'] = $author;
				
				$data['success'] .= "Документ номер <b>$q[id]</b> с именем <b>$q[name]</b> успешно обновлён.<br>";
			}
			
			$docs1[] = $q;
		}
		
		$docs = $docs1;
		
		for($i=count($docs)+1;$i<=10;$i++) {
			
			if ($this->upload->do_upload('doc'.$i)) {
				
				$name = $this->input->post('name'.$i);
				
				$data['success'] .= "Документ номер $i с именем $name успешно загружен.<br>";
			      
				$dt = $this->upload->data();
				
				$docs[] = array('id' => $i, 'author' => $author, 'date' => time(), 'name' => $name, 'file' => $dt['file_name']);
				
			}
		}
		
		if(empty($docs)) {
		 	
			$data['error'] = $this->upload->display_errors(false,false);
		 	
		} else {
		 	
			$upd['docs'] = serialize($docs);
		 	
			$this->db->update('request', $upd, array('id' => $id));
		       
		}
   	
		return $data;
	}

    /**
     * @param $id
     * @return mixed
     */
    function update_request($id) {

        $data = $this->db->get_where('request', array('id' => $id))->row_array();
		
		$form = $this->config->item('access');
		
		$razd = $this->config->item('razd');
		
		$instance = $this->config->item('instance');
		
		$orazd = 0;
		
		foreach($form as $i) {
			
			if(!isset($i['form']) || $i['form'] != 0) {
				
				if($i['value'] == 'razd') $orazd = 1;
				
				if($i['value'] == 'instance') $oins = 1;
				
				$update[$i['value']] = $this->input->post($i['value']);
			}
		}
		
		if(!empty($orazd)) {
			
			$arazd = array();
			
			foreach($razd as $i) {
				
				if($this->input->post($i['name']."ch")) $arazd[$i['name']] = array('hours' => $this->input->post($i['name']), 'price' => $this->input->post($i['name'].'pr'));
			}
			
			$arazd = serialize($arazd);
			
			$update['razd'] = $arazd;
			
		}
		
		if(!empty($oins)) {
			
			$ains = array();
			
			foreach($instance as $i) {
				
				if(empty($i['ins'])) {
					
					if($this->input->post($i['name']."ch")) $ains[$i['name']] = array('name' => $i['name'], 'price' => $this->input->post($i['name']));
				}
			}
			
			$ains = serialize($ains);
			
			$update['instance'] = $ains;
		}
		
		return $this->db->update('cCard', $update, array('id' => $data['cid']));
		
		/*$update = array(
			//'docs' => $this->input->post('docs'),
			//'kp' => $this->input->post('kp'),
			'history' => $this->input->post('history')
		);*/

		//return $this->db->update('request', $update, array('id' => $id));
	}

    /**
     * @param null $id
     * @param string $view
     * @param string $sort
     * @return array|string
     */
    function get_request($id = null, $view = 'FormTable', $sort = 'all')
	{		
		$res = array(
				'kpstatus' => $this->config->item('kpstatus'),
				'region' => $this->config->item('region'),
			     );
		
		$this->load->helper('request');
		
		if($id != null) {
			
			//GetData
			$query = $this->db->get_where('request', array('id' => $id))->row_array();
			
            (!empty($query)) ? $query1 = $this->db->get_where('cCard', array('id' => $query['cid']))->row_array() : redirect("/request");;

			$data['result'] = array_merge($query1, $query);
			//end GetData
			
			$ntype = $this->config->item('ntype');
			
			$formdata['razd'] = $this->config->item('razd');
			
			if($view == 'FormTable') {
			
				$data['table'] = $this->config->item('access');
				
				$formdata['region'] = $res['region'];
				
				$formdata['ptype'] = $ntype;
				
				$formdata['ztype'] = $ntype;
				
				$formdata['instance'] = $this->config->item('instance');
				
				$formdata['user_info'] = $this->dx_auth->get_all_data();
				
				$access = $this->dx_auth->check_permissions('request');
				
				if($this->dx_auth->is_admin() == 1) $access = 'is_admin';
				
				$source = req_perm_in_view($this->config->item('access'), $type = 'form', $this->dx_auth->get_all_data());
				
				$data['result'] = req_arr_to_form($source, $formdata, $data['result'], 'edit');
			
			} else {
				
				$data['result']['ptype'] = $ntype[$data['result']['ptype']];
				
				$data['result']['ztype'] = $ntype[$data['result']['ztype']];
				
				$razd = unserialize($data['result']['razd']);
				
				$data['result']['razd'] = array();
				
				foreach($formdata['razd'] as $k => $i) {
					
					if(isset($razd[$k])) $data['result']['razd'][$i] = $razd[$k];
				}
			}
			
		} else {
			
			//$this->output->enable_profiler(TRUE);
			
			if($sort['logic'] != 'all' && $sort != 'all') $this->db->where(req_parse_sort($sort, $this->dx_auth->get_all_data()));
			
			//GetData
			$this->db->order_by("date", "asc"); 
			
			$query = array(
				       'request' => $this->db->get('request')->result_array(),
				       'cCard' => $this->db->get('cCard')->result_array(),
				       );
			
			$data['result'] = req_parse_data($query, $res);
			//end GetData
			
			$alldata = $this->dx_auth->get_all_data();
			
			$source = req_perm_in_view($this->config->item('access'), $type = 'view', $alldata);

			$alldata['status'] = $this->config->item('status');
			
			$data['result'] = req_arr_to_table($data['result'], $source, $alldata);
		}
		
		return $data['result'];
	}
}
?>