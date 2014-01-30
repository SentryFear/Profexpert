<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class request_model
 */
class request_model extends CI_Model {
    /**
     * Инициализация
     */
    function __construct()
	{
		parent::__construct();

        $this->config->load('request');
	}

    /**
     * Добаление заявки
     *
     * @return bool
     */
    function create_request() {
	   
		$suc = 0;

        $more = array();

        $cid = 0;

        if($this->input->post('cid')) $cid = $this->input->post('cid');

        if($cid == 0) {

            $comment[] = array('author' => $this->dx_auth->get_username(), 'text'=> 'Создана карточка клиента', 'date' => time());

            //Карточка клиента
            $insert = array(
                'cdate' => time(),
                'zsurname' => $this->input->post('zsurname'),
                'zname' => $this->input->post('zname'),
                'zmname' => $this->input->post('zmname'),
                'organization' => $this->input->post('organization'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'hear' => $this->input->post('hear'),
                'cсoments' => serialize($comment)
            );

            if($this->db->insert('card', $insert)) $suc+=1;

            $cid = $this->db->insert_id();

        } else {

            $row = $this->db->get_where('card', array('id' => $cid))->row_array();

            $comment = unserialize($row['cсoments']);

            if(empty($comment)) $comment = array();

            $comment[] = array('author' => $this->dx_auth->get_username(), 'text'=> 'Новая заявка от клиента', 'date' => time());

            $update = array(
                'cсoments' => serialize($comment)
            );

            if($this->db->update('card', $update, array('id' => $cid))) $suc+=1;
        }


		//end Карточка клиента
		
        //Заявка
		$form = $this->config->item('access');

		foreach($form as $i) {
			
			if(!isset($i['form']) || $i['form'] != 0) {

                $access = explode(",", $i['allow']);

                if (in_array($this->dx_auth->get_role_id(), $access)) $insert1[$i['value']] = $this->input->post($i['value']);
			}
		}

        unset($insert1['hear']);

        unset($insert1['organization']);

        $more = array();

        if($this->input->post('more')) {

            $aid = $this->dx_auth->get_user_id();

            $rname = $this->dx_auth->get_role_name();

            $aid = !empty($aid) ? $aid : '0';

            $rname = !empty($rname) ? $rname : 'С сайта';

            $name = $this->dx_auth->get_name();

            $name = !empty($name) ? $name : 'Заказчик';

            $more[] = array('aid' => $aid, 'rname' => $rname, 'author' => $name, 'text'=> $this->input->post('more'), 'date' => time());
        }

        $insert1['more'] = serialize($more);

		$insert1['razd'] = '';
		
		$insert1['instance'] = '';
		
		$insert1['date'] = time();

        $insert1['cid'] = $cid;

		$mid = 0;
		
		$roleid = $this->dx_auth->get_role_id();
		
		if($roleid == 3) $mid = $this->dx_auth->get_user_id();
		
		$insert1['mid'] = $mid;

		if($this->db->insert('request', $insert1)) $suc+=1;
		//end Заявка

        $rids = $this->db->insert_id();

		//История
		$kpstatus = $this->config->item('kpstatus');
      
		$insert2 = array(
			'name' => $kpstatus[0]['dbname'],
			'date' => time(),
			'rid' => $rids
		);
      
		if($this->db->insert('history', $insert2)) $suc+=1;
		//end История
      
		return $suc == 3 ? $rids : false;
	}

    /**
     * Добавление документов
     *
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
			
			if(!empty($q['name'])) $docs1[] = $q;
		}
		
		$docs = $docs1;
		
		for($i=count($docs)+1;$i<=10;$i++) {
			
			if ($this->upload->do_upload('doc'.$i)) {
				
				$name = $this->input->post('name'.$i) ? $this->input->post('name'.$i) : $dt['file_name'];
				
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

    function add_comments() {

        $ok = 0;

        if($this->input->post('text')) {

            $this->load->library('history');

            $this->load->library('notification');

            $id = $this->input->post('id');

            $text = $this->input->post('text');

            $author = $this->dx_auth->get_name();

            $aid = $this->dx_auth->get_user_id();

            $rname = $this->dx_auth->get_role_name();

            $row = $this->db->get_where('request', array('id' => $id))->row_array();

            $this->notification->setNotification('Новый комментарий ['.$id.']', '/request/?sort=mAll', $id, 'Новый комментарий к заявке', '0', $row['mid']);

            $comments = unserialize($row['more']);

            if(empty($comments)) $comments = array();

            $comments[] = array('aid' => $aid, 'rname' => $rname, 'author' => $author, 'text'=> $text, 'date' => time());

            if($this->dx_auth->get_role_id() == '2' || $this->dx_auth->get_role_id() == '6') {

                //$upd['kp'] = 9;

                //$this->history->setHistory('dt9', $id);
            }

            $upd['more'] = serialize($comments);

            $ok = $this->db->update('request', $upd, array('id' => $id)) ? 1 : 0;
        }

        return $ok;
    }

    /**
     * Изменение заявки
     *
     * @param $id
     * @return mixed
     */
    function update_request($id) {

        //$this->output->enable_profiler(TRUE);

        $data = $this->db->get_where('request', array('id' => $id))->row_array();
		
		$form = $this->config->item('access');
		
		$razd = $this->config->item('razd');
		
		$instance = $this->config->item('instance');
		
		$orazd = 0;

        $oins = 0;

        $traspr = 0;

		foreach($form as $i) {
			
			if(!isset($i['form']) || $i['form'] != 0) {

                $access = explode(",", $i['allow']);

                if (in_array($this->dx_auth->get_role_id(), $access)) {

                    if($i['value'] == 'razd') $orazd = 1;

                    if($i['value'] == 'instance') $oins = 1;

                    if($i['value'] == 'traspr') $traspr = 1;

                    $update[$i['value']] = str_replace('&nbsp;', ' ', $this->input->post($i['value']));

                }
			}
		}
		//var_dump($this->input->post('kpmore'));
		if(!empty($orazd)) {
			
			$arazd = array();
			
			foreach($razd as $i) {
				
				if($this->input->post($i['name']."ch")) $arazd[$i['name']] = array('hours' => $this->input->post($i['name']), 'price' => $this->input->post($i['name'].'pr'));
			}
			
			$arazd = serialize($arazd);
			
			$update['razd'] = $arazd;
			
		}

        if(!empty($traspr)) {

            $traspr1 = array();

            $row = $this->db->get_where('card', array('id' => $id))->row_array();

            if(!empty($row['traspr'])) $traspr2 = unserialize($row['traspr']);

            if(empty($traspr2)) $traspr2 = array();

            $v = 0;

            $ct = 0;

            foreach($traspr2 as $q) {

                $ct++;

                if($this->input->post('trasprname'.$q['id'])) {

                    $q['name'] = str_replace('&nbsp;', ' ', $this->input->post('trasprname'.$q['id']));

                    $q['price'] = $this->input->post('trasprpr'.$q['id']);

                    $q['srok'] = $this->input->post('trasprsr'.$q['id']);

                    $v++;

                    $q['id'] = $v;

                    $traspr1[] = $q;

                }
            }

            $traspr2 = $traspr1;

            for($i=$ct+1;$i<=10;$i++) {

                if($this->input->post('trasprname'.$i) && !empty($_POST['trasprname'.$i])) {

                    $name = str_replace('&nbsp;', ' ', $this->input->post('trasprname'.$i));

                    $price = $this->input->post('trasprpr'.$i);

                    $srok = $this->input->post('trasprsr'.$i);

                    $traspr2[] = array('id' => $i, 'price' => $price, 'name' => $name, 'srok' => $srok);
                }
            }

            if(empty($traspr2)) {

                $data['error'] = 'Произошла неожиданная ошибка, обратитесь к администратору.';

            } else {

                $update['traspr'] = serialize($traspr2);

            }
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

        if($data['mid'] == 0) {

            $update['mid'] = $this->dx_auth->get_user_id();
            //$this->db->update('request', $upd1, array('id' => $id));
        }


		return $this->db->update('request', $update, array('id' => $id));
		
		/*$update = array(
			//'docs' => $this->input->post('docs'),
			//'kp' => $this->input->post('kp'),
			'history' => $this->input->post('history')
		);*/

		//return $this->db->update('request', $update, array('id' => $id));
	}

    /**
     * Получить все заявки
     *
     * @param null $id
     * @param string $view
     * @param string $sort
     * @return array|string
     */
    function get_request($id = null, $view = 'FormTable', $sort = 'all')
	{
        //$this->benchmark->mark('code_start');

		$res = array(
				'kpstatus' => $this->config->item('kpstatus'),
				'region' => $this->config->item('region'),
			     );
		
		$this->load->helper('request');

        //редактирование или печать
		if($id != null) {
			
			//GetData
			$query = $this->db->get_where('request', array('id' => $id))->row_array();
			
            (!empty($query)) ? $query1 = $this->db->get_where('card', array('id' => $query['cid']))->row_array() : redirect("/request");;

			$data['result'] = array_merge($query1, $query);
			//end GetData

			$ntype = $this->config->item('ntype');
			
			$formdata['razd'] = $this->config->item('razd');

            $formdata['instance'] = $this->config->item('instance');

            //форма редактирования
			if($view == 'FormTable') {
			
				$data['table'] = $this->config->item('access');
				
				$formdata['region'] = $res['region'];
				
				$formdata['ptype'] = $ntype;
				
				$formdata['ztype'] = $ntype;
				
				$formdata['user_info'] = $this->dx_auth->get_all_data();
				
				$source = req_perm_in_view($this->config->item('access'), $type = 'form', $this->dx_auth->get_all_data());
				
				$data['result'] = req_arr_to_form($source, $formdata, $data['result'], 'edit');

            //печать
			} else {
				
				if(!empty($data['result']['ptype'])) $data['result']['ptype'] = $ntype[$data['result']['ptype']];

                if(!empty($data['result']['ztype'])) $data['result']['ztype'] = $ntype[$data['result']['ztype']];

                if(!empty($data['result']['docs'])) $data['result']['docs'] = unserialize($data['result']['docs']);

				$razd = unserialize($data['result']['razd']);

                $data['result']['razd'] = array();

                foreach($formdata['razd'] as $i) {

                    if(isset($razd[$i['name']])){

                        $rs = array_merge($i, $razd[$i['name']]);

                        $rs['price1'] = $i['price'];

                        $data['result']['razd'][] = $rs;
                    }
                }

                $instance = unserialize($data['result']['instance']);

                $data['result']['instance'] = array();

                foreach($formdata['instance'] as $i) {

                    if(isset($i['name']) && isset($instance[$i['name']])){

                        $rs = array_merge($i, $instance[$i['name']]);

                        $rs['price1'] = $i['price'];

                        $data['result']['instance'][] = $rs;
                    }
                }

                $traspr = array();

                if(!empty($data['result']['traspr'])) $traspr = unserialize($data['result']['traspr']);

                $data['result']['traspr'] = array();

                foreach($traspr as $i) {

                    $data['result']['traspr'][] = $i;
                }
			}
			
		} else {

			//$this->output->enable_profiler(TRUE);

			if($sort['logic'] != 'all' && $sort != 'all') $this->db->where(req_parse_sort($sort, $this->dx_auth->get_all_data()));
			
			//GetData
			$this->db->order_by("date", "asc"); 

            $query = array(
                'request' => $this->db->get('request')->result_array(),
                'card' => $this->db->get('card')->result_array(),
            );

			$data['result'] = req_parse_data($query, $res);
			//end GetData

			$alldata = $this->dx_auth->get_all_data();

			$source = req_perm_in_view($this->config->item('access'), $type = 'view', $alldata);

			$alldata['status'] = $this->config->item('status');

            $alldata['region'] = $res['region'];

            //$this->benchmark->mark('code_mid');

            if($view == 'json') {

                foreach($data['result'] as $r) {

                    $extra = $alldata;

                    $extra['id'] = $r['id'];

                    $extra['req'] = $r;

                    $json[] = array('id' => $r['id'], 'text' => req_get_status($alldata['status'], $extra));
                }

                $data['result'] = $json;

            } else $data['result'] = req_arr_to_table($data['result'], $source, $alldata);

            //$this->benchmark->mark('code_end');
		}
		
		return $data['result'];
	}

    function getCard() {

        $result = array('0' => array('none' => 'Не выбрано'));

        $this->db->order_by('zsurname asc, zname asc, zmname asc');

        $client = $this->db->get_where('card')->result_array();

        foreach($client as $i) {

            $result[$i['id']] = $i;
        }

        return $result;
    }
}
?>