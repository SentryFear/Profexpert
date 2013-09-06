<?php
class Request extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

        //load helpers
		$this->load->helper(array('form', 'url'));

        //load request model
		$this->load->model('request/request_model');

        //load request config
		$this->config->load('request');
	}
	
	function index()
	{
		$data = array();
		
		$data['success'] = $this->session->flashdata('success');
		
		$data['error'] = $this->session->flashdata('error');
		
		$sort = '1';
		
		if($this->input->get('sort')) $sort = $this->input->get('sort');
		
		$data['region'] = $this->config->item('region');
		
		$csort = $this->config->item('sort');
		
		$gsort = 'all';
		
		$role_id = $this->dx_auth->get_role_id();
		
		foreach($csort as $i) {
			
			$i['allow'] = explode(',', $i['allow']);
			
			if(in_array($role_id, $i['allow'])) {
				
				if(isset($i['default']) && $sort == $i['default']) {
				
					$i['active'] = 1;
					
					$gsort = $i;
				}
				
				if($sort == $i['uri']) {
				
					$i['active'] = 1;
					
					$gsort = $i;
				}
				
				$data['sort'][] = $i;
			}
		}
		
		if($this->input->post('add')) {
		
			$this->request_model->create_request() ? $data['success'] = "Заявка успешно добавлена!" : $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
		}
		
		if($this->input->post('upload') && $this->input->post('id')) {
			
			$data = array_merge($data, $this->request_model->add_docs());
		}
		
		$data['result'] = $this->request_model->get_request(null, 'FormTable', $gsort);
		
		$data['table'] = $this->config->item('access');
		
		$ntype = $this->config->item('ntype');
		
		$formdata['region'] = $data['region'];
		
		$formdata['ptype'] = $ntype;
		
		$formdata['ztype'] = $ntype;
		
		$source = req_perm_in_view($this->config->item('access'), $type = 'form', $this->dx_auth->get_all_data());
		
		if($this->dx_auth->check_permissions('add')) $data['add'] = req_arr_to_form($source, $formdata);
		
		echo $this->twig->render('request/main.html', $data);
	}
	
	function add()
	{
		$id = $this->uri->segment(3);
		
		$docs = array();
		
		if(!empty($id) && $this->input->is_ajax_request()) {
			
			$res = $this->db->get_where('request', array('id' => $id))->row_array();
			
			$docs = unserialize($res['docs']);
			
			if(empty($docs)) {
				
				echo '	<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<b>Ещё не добавлено не одного файла.</b>
					</div>';
				echo '<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<b>Подсказка</b><br>
					* Для добавления файла нажмите кнопку <b>Добавить файл</b>.<br/>
					* Заполните поле <b>Название файла</b>.<br/>
					* Выберите файл с компьютера.<br/>
					* Нажмите на кнопку <b>Загрузить</b>.
				      </div>';
				
			} else {
				
				foreach($docs as $i) {

					echo '<blockquote><table class="table table-hover" style="margin-bottom: 0px;"><tr><td style="width: 100%; vertical-align: top;">
							<input class="inline-input" placeholder="Название файла" name="name'.$i['id'].'" value="'.$i['name'].'" type="text">
							<input id="inp'.$i['id'].'" type="file" name="doc'.$i['id'].'" style="display:none; margin-top: 15px;" />
							</td>
							<td style="vertical-align: top;"><div class="btn-group">
								<a href="#" class="btn btn-mini" onclick="$(\'#inp'.$i['id'].'\').toggle();" data-toggle="tooltip" data-original-title="Загрузить другой файл" data-placement="left"><i class="icon-edit"></i> Обновить файл</a>
								<a href="/uploads/'.$i['file'].'" target="_blank" class="btn btn-mini" data-toggle="tooltip" data-original-title="Скачать файл" data-placement="left"><i class="icon-download-alt"></i> Скачать файл</a>
							</div></td></tr>
						</table><small>Загрузил <b>'.$i['author'].'</b> '.date("d.m.Y в H:i", $i['date']).'</small></blockquote>';
						
				}
			}
			
			echo '<div class="adds"></div>';
			
			echo '<hr><p><a href="#" class="btn btn-success btn-mini" id="add">Добавить файл</a></p>';
			
			echo '<div class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<b>Подсказка</b><br>
				* Нажмите на текст названия чтобы изменить его.<br>
				* Нажмите на кнопку <i class="icon-edit" style="margin:0;"></i> рядом с названием того файла который хотите заменить.<br>
				* Нажмите на кнопку <i class="icon-download-alt" style="margin:0;"></i> рядом с названием того файла который хотите скачать.
			      </div>';
			
			echo "<script>  
				(function($) {  
				$(function() {  
				//  $('input').styler({  
				//      browseText: 'Обновить файл'
				//  });
				var i = ".count($docs)." + 1;
				var q = 0;
				$('#add').click(function(e) {
					if(q<10) {
						$('div.adds').append('<blockquote><input class=\"inline-input\" placeholder=\"Название файла\" name=\"name'+i+'\" value type=\"text\"><input type=file name=doc'+i+' style=\"float: right;\" /></blockquote>');
						q++;
						i++;
					} else {
						alert('За один раз можно отправлять только 10 файлов!')
					}
					
					
				})
				})  
				})(jQuery)  
				</script>  ";
			
		} else {
			
			redirect("/request");
		}
	}
	
	function send() {
		
		$type = $this->uri->segment(3);
		
		$id = $this->uri->segment(4);
		
		if(!empty($id)) {
			
			//Отдел продаж отправляет проектировщикам
			if($type == 'optop') {
				
				$row = $this->db->get_where('request', array('id' => $id))->row_array();
				
				if($row['kp'] == 0) {
				       
					$kpstatus = $this->config->item('kpstatus');
					
					$insert2 = array(
						'name' => $kpstatus[1]['dbname'],
						'date' => time(),
						'rid' => $row['id']
					);
					
					$this->db->insert('history', $insert2);
					
					$insert3 = array(
						'name' => 'dt20',
						'date' => time(),
						'rid' => $row['id']
					);
					
					$this->db->insert('history', $insert3);
					
					$upd['kp'] = 1;
					
					$this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена проектировщикам.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
				}
				
			//Проектировщик выбирает заявку как свою
			} elseif($type == 'pstop') {
				
				$insert1 = array(
					'name' => 'dt21',
					'date' => time(),
					'rid' => $id
				);
				
				$this->db->insert('history', $insert1);
				
				$upd['uid'] = $this->dx_auth->get_user_id();
				
				$this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно принята.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
				
			//Проектировщик завершил работу и отправляет отделу продаж обратно
			} elseif($type == 'ptoop') {
				
				$insert1 = array(
					'name' => 'dt22',
					'date' => time(),
					'rid' => $id
				);
				
				$this->db->insert('history', $insert1);
				
				$upd['kp'] = 3;
				
				$this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
				
			// Отдел продаж завершил работу и отправляет заявку руководству на согласование сроков
			} elseif($type == 'optor') {
				
				$insert1 = array(
					'name' => 'dt4',
					'date' => time(),
					'rid' => $id
				);
				
				$this->db->insert('history', $insert1);
				
				$upd['kp'] = 4;
				
				$this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена руководству.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
				
			// Руководство согласовало сроки и отправляет заявку отделу продаж на отправку кп заказчикам
			} elseif($type == 'rtoop') {
				
				$insert1 = array(
					'name' => 'dt5',
					'date' => time(),
					'rid' => $id
				);
				
				$this->db->insert('history', $insert1);
				
				$upd['kp'] = 5;
				
				$this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

			// Менеджер отправил на доработку проектировщикам
            } elseif($type == 'optopr') {

                $insert1 = array(
                    'name' => 'dt11',
                    'date' => time(),
                    'rid' => $id
                );

                $this->db->insert('history', $insert1);

                $upd['kp'] = 11;

                $this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена проектировщикам.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

            // проектировщик доработал
            } elseif($type == 'prtoop') {

                $insert1 = array(
                    'name' => 'dt12',
                    'date' => time(),
                    'rid' => $id
                );

                $this->db->insert('history', $insert1);

                $upd['kp'] = 12;

                $this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

            // Руководство отправило на доработку
			} elseif($type == 'rtodor') {
				
				$insert1 = array(
					'name' => 'dt9',
					'date' => time(),
					'rid' => $id
				);
				
				$this->db->insert('history', $insert1);
				
				$upd['kp'] = 9;
				
				$this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
				
			// Менеджер прислал с доработки
			} elseif($type == 'optordor') {
				
				$insert1 = array(
					'name' => 'dt10',
					'date' => time(),
					'rid' => $id
				);
				
				$this->db->insert('history', $insert1);
				
				$upd['kp'] = 10;
				
				$this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена руководству.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
				
			//заявка отправляется заказчику
			} elseif($type == 'optoz') {
				
				$insert1 = array(
					'name' => 'dt6',
					'date' => time(),
					'rid' => $id
				);
				
				$this->db->insert('history', $insert1);
				
				$upd['kp'] = 6;
				
				$this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена заказчику.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
				
			//Заказчик отказался
			} elseif($type == 'otkaz') {
				
				$insert1 = array(
					'name' => 'dt7',
					'date' => time(),
					'rid' => $id
				);
				
				$this->db->insert('history', $insert1);
				
				$upd['kp'] = 7;
				
				$this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отбработана.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
				
			//Заказчик согласился
			} elseif($type == 'inwork') {
				
				$insert1 = array(
					'name' => 'dt8',
					'date' => time(),
					'rid' => $id
				);
				
				$this->db->insert('history', $insert1);
				
				$upd['kp'] = 8;
				
				$this->db->update('request', $upd, array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отбработана.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
				
			}
			
		}
		
		redirect("/request");
	}
	
	function edit()
	{
		$data = array();
		
		$data['region'] = $this->config->item('region');
		
		$id = $this->uri->segment(3);
		
		if(!empty($id) && $this->dx_auth->check_permissions('edit') == 1) {
			
			if($this->input->post('add')) {
			
				$this->request_model->update_request($id) ? $data['success'] = "Заявка успешно изменена!" : $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
			}
			
			$data['result'] = $this->request_model->get_request($id);
			
			echo $this->twig->render('request/edit.html', $data);
			
		} else {
         
			redirect("/request");
		}
	}
	
	function prints() {
		
		$data = array();
		
		$data['region'] = $this->config->item('region');
		
		$id = $this->uri->segment(3);
		
		if(!empty($id) && $this->dx_auth->check_permissions('print') == 1) {
			
			$name = $this->dx_auth->get_name();
			
			$name = explode(' ', $name);
			
			$data['user']['name'] =  $name[0]." ".mb_substr($name[1],0,1,'utf-8').". ".mb_substr($name[2],0,1,'utf-8').". ";
			
			$data['result'] = $this->request_model->get_request($id, 'data');
		   
			echo $this->twig->render('request/print.html', $data);
			
		} else {
         
			redirect("/request/");
		}
	}
	
	function delete()
	{
		$id = $this->uri->segment(3);
	   
		if(!empty($id) && $this->dx_auth->check_permissions('delete') == 1) {
         
			$query = $this->db->get_where('request', array('id' => $id));
         
			$req = $query->row_array();
         
			$this->db->delete('cCard', array('id' => $req['cid']));
         
			$this->db->delete('history', array('rid' => $req['id']));
         
			$this->db->delete('request', array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно удалена.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
		}

		redirect("/request");
	}
}
?>