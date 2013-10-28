<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Request
 *
 * Заявки
 */
class Request extends CI_Controller
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
		$this->load->model('request/request_model');

        //load request config
		$this->config->load('request');
	}

    /**
     * Стартовая страница
     */
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

        if($this->input->post('rework') && $this->input->post('id')) {

            $this->request_model->add_rework() ? $data['success'] = "Заявка успешно отправлена на доработку!" : $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
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

    /**
     * Добавление файлов открывается с помощью AJAX
     */
    function add()
	{
		$id = intval($this->uri->segment(3));

		$docs = array();
		
		if(!empty($id) && $this->input->is_ajax_request()) {
			
			$res = $this->db->get_where('request', array('id' => $id))->row_array();
			
			$docs = unserialize($res['docs']);

            echo '<div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     <h3 id="myModalLabel">Загрузить документы</h3>
                  </div>
                  <div class="modal-body">';

			if(empty($docs)) {
				
				echo '<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<b>Ещё не добавлено ни одного файла.</b>
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
			      </div>
			      </div>
                  <div class="modal-footer">
                    <div class="btn-group">
                      <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                      <input type="submit" class="btn btn-primary" name="upload" value="Добавить" />
                    </div>
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

    function rework() {

        $id = intval($this->uri->segment(3));

        if(!empty($id) && $this->input->is_ajax_request()) {

            $res = $this->db->get_where('request', array('id' => $id))->row_array();

            if(!empty($res['rework'])) $rework = unserialize($res['rework']);
            else $rework = array();

            echo '<div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h3 id="myModalLabel">Комментарии руководства</h3>
              </div>
              <div class="modal-body">';

            foreach($rework as $i){

                echo '<blockquote>
                          <p>'.$i['text'].'</p>
                          <small>Создал <b>'.$i['author'].'</b> '.date("d.m.Y в H:i", $i['date']).'</small>
                        </blockquote>';
            }

            if($this->dx_auth->get_role_id() == '2' || $this->dx_auth->get_role_id() == '6') {

                echo '<textarea class="span5 wysihtml5" rows="5" name="text" id="text" placeholder="Комментарий к доработке"></textarea>';
            }

            echo '</div>
              <div class="modal-footer">
                <div class="btn-group">
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>';

            if($this->dx_auth->get_role_id() == '2' || $this->dx_auth->get_role_id() == '6') {

                echo '<input type="submit" class="btn btn-primary" name="rework" value="Отправить" />';
            }
            
            echo '</div></div>';

        } else {

            redirect("/request");
        }

    }

    /**
     * Изменение статуса заявки (отправление от отдела к отделу)
     */
    function send() {
		
		$type = $this->uri->segment(3);
		
		$id = intval($this->uri->segment(4));

        $this->load->library('history');

		if(!empty($id)) {

            $row = $this->db->get_where('request', array('id' => $id))->row_array();

            if(!empty($row)) {

                //Отдел продаж отправляет проектировщикам
                if($type == 'optop') {

                    $this->history->setHistory('dt1', $id);

                    $this->history->setHistory('dt20', $id);

                    $this->db->update('request', array('kp' => 1), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена проектировщикам.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                //Проектировщик выбирает заявку как свою
                } elseif($type == 'pstop') {

                    $this->history->setHistory('dt21', $id);

                    $this->db->update('request', array('uid' => $this->dx_auth->get_user_id()), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно принята.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                //Проектировщик завершил работу и отправляет отделу продаж обратно
                } elseif($type == 'ptoop') {

                    $this->history->setHistory('dt22', $id);

                    $this->db->update('request', array('kp' => 3), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // Отдел продаж завершил работу и отправляет заявку руководству на согласование сроков
                } elseif($type == 'optor') {

                    $this->history->setHistory('dt4', $id);

                    $this->db->update('request', array('kp' => 4), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена руководству.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // Руководство согласовало сроки и отправляет заявку отделу продаж на отправку кп заказчикам
                } elseif($type == 'rtoop') {

                    $this->history->setHistory('dt5', $id);

                    $this->db->update('request', array('kp' => 5), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                //заявка отправляется заказчику
                } elseif($type == 'optoz') {

                    $this->history->setHistory('dt6', $id);

                    $this->db->update('request', array('kp' => 6), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена заказчику.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                //Заказчик отказался
                } elseif($type == 'otkaz') {

                    $this->history->setHistory('dt7', $id);

                    $this->db->update('request', array('kp' => 7), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отбработана.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                //Заказчик согласился
                } elseif($type == 'inwork') {

                    $this->history->setHistory('dt8', $id);

                    $this->db->update('request', array('kp' => 8), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отбработана.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // Руководство отправило на доработку
                } elseif($type == 'rtodor') {

                    $this->history->setHistory('dt9', $id);

                    $this->db->update('request', array('kp' => 9), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // Менеджер прислал с доработки
                } elseif($type == 'optordor') {

                    $this->history->setHistory('dt10', $id);

                    $this->db->update('request', array('kp' => 10), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена руководству.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // Менеджер отправил на доработку проектировщикам
                } elseif($type == 'optopr') {

                    $this->history->setHistory('dt11', $id);

                    $this->db->update('request', array('kp' => 11), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена проектировщикам.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // проектировщик доработал
                } elseif($type == 'prtoop') {

                    $this->history->setHistory('dt12', $id);

                    $this->db->update('request', array('kp' => 12), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
                }
            }
		}
		
		redirect("/request");
	}

    /**
     * Редактирование заявки
     */
    function edit()
	{
		$data = array();
		
		$data['region'] = $this->config->item('region');
		
		$id = intval($this->uri->segment(3));

        $perm = $this->dx_auth->check_permissions('edit');

        //todo дописать проверку для проектировщиков
        //if($this->dx_auth->get_user_id() == 4 && кп != 1) $perm = 0;

		if(!empty($id) && $perm == 1) {
			
			if($this->input->post('add')) {
			
				$this->request_model->update_request($id) ? $data['success'] = "Заявка успешно изменена!" : $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
			}
			
			$data['result'] = $this->request_model->get_request($id);
			
			echo $this->twig->render('request/edit.html', $data);
			
		} else {
         
			redirect("/request");
		}
	}

    /**
     * Печать заявки
     */
    function prints() {
		
		$data = array();
		
		$data['region'] = $this->config->item('region');
		
		$id = intval($this->uri->segment(3));
		
		if(!empty($id) && $this->dx_auth->check_permissions('print') == 1) {
			
			$name = $this->dx_auth->get_name();
			
			$name = explode(' ', $name);
			
			$data['user']['name'] =  $name[0];

            if(isset($name[1])) $data['user']['name'] .= " " . mb_substr($name[1],0,1,'utf-8') . ".";

            if(isset($name[2])) $data['user']['name'] .= " " . mb_substr($name[2],0,1,'utf-8') . ".";

			$data['result'] = $this->request_model->get_request($id, 'data');

            $html = $this->twig->render('request/print.html', $data);

            //echo $html;

            // Load library
            $this->load->library('dompdf_gen');

            // Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("$id.pdf");
			
		} else {
         
			redirect("/request/");
		}
	}

    /**
     * Печать заявки
     */
    function review()
    {
        $data = array();

        $data['region'] = $this->config->item('region');

        $id = intval($this->uri->segment(3));

        $first = $this->uri->segment(4);

        if($first == 1) $data['first'] = 1;

        if(!empty($id)) {

            $this->load->model('dx_auth/users_model');

            $data['result'] = $this->request_model->get_request($id, 'data');

            $manager = $this->users_model->get_user_by_id($data['result']['mid']);

            $manager = $manager->result_array();

            if(!empty($manager)) {

                $data['manager']['sign'] = $manager[0]['signature'];

                $manager = explode(' ', $manager[0]['name']);

                $data['manager']['name'] =  $manager[0];

                if(isset($manager[1])) $data['manager']['name'] .= " " . mb_substr($manager[1],0,1,'utf-8') . ".";

                if(isset($manager[2])) $data['manager']['name'] .= " " . mb_substr($manager[2],0,1,'utf-8') . ".";
            }

            $name = $this->users_model->get_user_by_id($data['result']['uid']);

            $name = $name->result_array();

            if(!empty($name)) {

                $data['project']['sign'] = $name[0]['signature'];

                $name = explode(' ', $name[0]['name']);

                $data['user']['name'] =  $name[0];

                if(isset($name[1])) $data['user']['name'] .= " " . mb_substr($name[1],0,1,'utf-8') . ".";

                if(isset($name[2])) $data['user']['name'] .= " " . mb_substr($name[2],0,1,'utf-8') . ".";
            }

            $html = $this->twig->render('request/review.html', $data);

            //echo $html;

            // Load library
            $this->load->library('dompdf_gen');

            // Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("$id.pdf");

        } else {

            redirect("/request/");
        }
    }

    /**
     * Удаление заявки
     */
    function delete()
	{
		$id = intval($this->uri->segment(3));
	   
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