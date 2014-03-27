<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Request
 *
 * Заявки
 */
class Request extends CI_Controller
{
    //Если раздел в разработке $dev = 1
    public $dev = 0;

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
        //$this->output->enable_profiler(TRUE);

        if($this->dx_auth->is_admin() == 0 && $this->dev == 1) {

            echo $this->twig->render('indev.html');

        } else {

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

            if($this->input->post('comments') && $this->input->post('id')) {

                $this->request_model->add_comments() ? $data['success'] = "Заявка успешно отправлена на доработку!" : $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
            }

            if($this->input->get('print')) $data['result'] = $this->request_model->get_request(null, 'prnt', $gsort);
            else $data['result'] = $this->request_model->get_request(null, 'FormTable', $gsort);

            $data['table'] = $this->config->item('access');

            $ntype = $this->config->item('ntype');

            $client = $this->request_model->getCard();

            $formdata['region'] = $data['region'];

            $formdata['ptype'] = $ntype;

            $formdata['ztype'] = $ntype;

            $formdata['worktype'] = $this->config->item('worktype');

            $formdata['cid'] = $client;

            $source = req_perm_in_view($this->config->item('access'), $type = 'add', $this->dx_auth->get_all_data());

            if($this->dx_auth->check_permissions('add')) $data['add'] = req_arr_to_form($source, $formdata);

            $data['stats'] = req_get_stats($this->request_model->get_request(null, 'prnt'));

            $tpl = 'request/main.html';

            if($this->input->get('print')) $tpl = 'request/prints.html';

            echo $this->twig->render($tpl, $data);
        }
	}

    function test() {

        $data = array();

        echo $this->twig->render('request/test.html', $data);

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

            echo '
<form method="POST" enctype="multipart/form-data" class="form-horizontal" id="addform">
      <input type="hidden" name="id" value="'.$id.'" id="ths" />
      <input type="hidden" name="upload" value="Отправить"/>
<div class="modal-header">
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

                echo '<div class="alert alert-success" style="display:none" id="alrt">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <b id="resp"></b>
					  </div>';

				foreach($docs as $i) {

					echo '<blockquote><table class="table table-hover" style="margin-bottom: 0px;"><tr><td style="vertical-align: top;">
							<input class="inline-input" placeholder="Название файла" name="name'.$i['id'].'" value="'.$i['name'].'" type="text">
							<input id="inp'.$i['id'].'" type="file" name="doc'.$i['id'].'" style="display:none; margin-top: 15px;" />
							</td>
							<td style="vertical-align: top; overflow: visible;"><div class="btn-group">
								<a href="#" class="btn btn-mini" onclick="$(\'#inp'.$i['id'].'\').toggle();" data-toggle="tooltip" data-original-title="Загрузить другой файл" data-placement="left"><i class="icon-edit"></i> Обновить файл</a>
								<a href="/uploads/'.$i['file'].'" target="_blank" class="btn btn-mini" data-toggle="tooltip" data-original-title="Скачать файл" data-placement="left"><i class="icon-download-alt"></i> Скачать файл</a>
							</div></td></tr>
						</table><small>Загрузил <b>'.$i['author'].'</b> '.date("d.m.Y в H:i", $i['date']).'</small></blockquote>';
						
				}
			}
			
			echo '<div class="adds"></div>';
			
			echo '<hr><p><a href="javascript:void(0);" class="btn btn-success btn-mini" id="add">Добавить файл</a></p>';
			
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
                  </div></form>';
			
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

            echo "<script>
				(function($) {
				$(function() {
				    $('#addform').submit(function() {

                        $( '#loading' ).show();

                        var str = $(this).serialize();

                        var form = document.forms.addform;

                        var formData = new FormData(form);

                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', '/request');

                        xhr.onreadystatechange = function() {

                            if (xhr.readyState == 4) {
                                if(xhr.status == 200) {
                                    data = xhr.responseText;
                                    $('#load').load('/request/add/'+$('#ths').val(), function() {
                                        $( '#loading' ).hide();
                                        $( '#alrt' ).show();
                                        $( '#resp' ).html('Файлы успешно добалены');
                                        $('#scrl').animate({scrollTop: $('#scrl')[0].scrollHeight});
                                    })
                                }
                            }
                        };

                        xhr.send(formData);

                        /*$. ajax ({
                            type: 'POST',
                            url: '/request',
                            data: str,
                            success: function(msg) {

                                $('#load').load('/request/add/'+$('#ths').val(), function() {
                                        $('#scrl').animate({scrollTop: $('#scrl')[0].scrollHeight});
                                })


                            }
                        });*/

                        return false;
                    });
				})
				})(jQuery)
				</script>";
			
		} else {
			
			redirect("/request");
		}
	}

    function comments() {

        $id = intval($this->uri->segment(3));

        if(!empty($id) && $this->input->is_ajax_request()) {

            $res = $this->db->get_where('request', array('id' => $id))->row_array();

            if(!empty($res['more'])) $more = unserialize($res['more']);
            else $more = array();

            echo '
<form method="POST" enctype="multipart/form-data" class="form-horizontal" id="commentsform">
      <input type="hidden" name="id" value="'.$id.'" id="ths" />
      <input type="hidden" name="comments" value="Отправить"/>
<div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h3 id="myModalLabel">Комментарии к проекту</h3>
              </div>
              <div class="modal-body" id="scrl">';

            foreach($more as $i){

                isset($i['author']) ? $author = $i['author'] : $author = 'none';

                isset($i['rname']) ? $rname = $i['rname'] : $rname = 'none';

                echo '<blockquote>
                          <p>'.$i['text'].'</p>
                          <small>Создал <b>'.$author.' ('.$rname.')</b> '.date("d.m.Y в H:i", $i['date']).'</small>
                        </blockquote>';
            }

            //if($this->dx_auth->get_role_id() == '2' || $this->dx_auth->get_role_id() == '6') {

                //echo '';
            //}

            echo '</div>
              <div class="modal-footer">
                <textarea class="span5 wysihtml5" rows="5" name="text" id="text" placeholder="Комментарий к проекту" style="float: left; width: 515px; margin-bottom: 15px;"></textarea>
                <div class="btn-group">
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>';

            //if($this->dx_auth->get_role_id() == '2' || $this->dx_auth->get_role_id() == '6') {

                echo '<input type="submit" class="btn btn-primary" name="comments" value="Отправить" />';
            //}
            
            echo '</div></div></form>';

            echo "<script>
				(function($) {
				$(function() {
				    $('#commentsform').submit(function() {
                        var str = $(this).serialize();

                        $. ajax ({
                            type: 'POST',
                            url: '/request',
                            data: str,
                            success: function(msg) {

                                $('#load').load('/request/comments/'+$('#ths').val(), function() {
                                        $('#scrl').animate({scrollTop: $('#scrl')[0].scrollHeight});
                                })


                            }
                        });

                        return false;
                    });
				})
				})(jQuery)
				</script>";

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

        $this->load->library('notification');

        if(!empty($id)) {

            $row = $this->db->get_where('request', array('id' => $id))->row_array();
            //$row = $this->db->select('*')->from('request')->join('cCard', 'cCard.id = request.cid')->get()->row_array();

            if(!empty($row)) {

                //Отдел продаж отправляет проектировщикам
                if($type == 'optop') {

                    $this->history->setHistory('dt1', $id);

                    $this->history->setHistory('dt20', $id);

                    $this->notification->setNotification('Новая заявка ['.$id.'] ['.mb_substr($this->dx_auth->get_role_name(),0,1,'utf-8').']', '/request/?sort=pAll', $id, 'Новая заявка от отдела продаж', '4', '0');

                    $this->db->update('request', array('kp' => 1), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена проектировщикам.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                //Проектировщик выбирает заявку как свою
                } elseif($type == 'pstop') {

                    $this->history->setHistory('dt21', $id);

                    $this->db->update('request', array('uid' => $this->dx_auth->get_user_id()), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно принята.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                //Проектировщик завершил работу и отправляет отделу продаж обратно
                } elseif($type == 'ptoop') {

                    $this->history->setHistory('dt22', $id);

                    $this->notification->setNotification('Завершено ['.$id.'] ['.mb_substr($this->dx_auth->get_role_name(),0,1,'utf-8').']', '/request/?sort=mAll', $id, 'Проектный отдел завершил работу над заявкой', '0', $row['mid']);

                    $this->db->update('request', array('kp' => 3), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // Отдел продаж завершил работу и отправляет заявку руководству на согласование сроков
                } elseif($type == 'optor') {

                    $this->history->setHistory('dt4', $id);

                    $this->notification->setNotification('Завершено ['.$id.'] ['.mb_substr($this->dx_auth->get_role_name(),0,1,'utf-8').']', '/request/?sort=rAll', $id, 'Отдел продаж отправил на согласование', '6', '0');

                    $this->db->update('request', array('kp' => 4), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена руководству.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // Руководство согласовало сроки и отправляет заявку отделу продаж на отправку кп заказчикам
                } elseif($type == 'rtoop') {

                    $this->history->setHistory('dt5', $id);

                    $this->notification->setNotification('КП Согласовано ['.$id.'] ['.mb_substr($this->dx_auth->get_role_name(),0,1,'utf-8').']', '/request/?sort=mAll', $id, 'Руководство согласовало КП', '0', $row['mid']);

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

                    $this->notification->setNotification('Доработка ['.$id.'] ['.mb_substr($this->dx_auth->get_role_name(),0,1,'utf-8').']', '/request/?sort=mAll', $id, 'Руководство отправило заявку на доработку', '0', $row['mid']);

                    $this->db->update('request', array('kp' => 9), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // Менеджер прислал с доработки
                } elseif($type == 'optordor') {

                    $this->history->setHistory('dt10', $id);

                    $this->notification->setNotification('Завершено ['.$id.'] ['.mb_substr($this->dx_auth->get_role_name(),0,1,'utf-8').']', '/request/?sort=rAll', $id, 'Отдел продаж завершил доработку и отправил на согласование', '6', '0');

                    $this->db->update('request', array('kp' => 10), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена руководству.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // Менеджер отправил на доработку проектировщикам
                } elseif($type == 'optopr') {

                    $this->history->setHistory('dt11', $id);

                    $this->notification->setNotification('Доработка ['.$id.'] ['.mb_substr($this->dx_auth->get_role_name(),0,1,'utf-8').']', '/request/?sort=pAll', $id, 'Отдел продаж отправил на доработку', '0', $row['uid']);

                    $this->db->update('request', array('kp' => 11), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена проектировщикам.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // проектировщик доработал
                } elseif($type == 'prtoop') {

                    $this->history->setHistory('dt12', $id);

                    $this->notification->setNotification('Доработано ['.$id.'] ['.mb_substr($this->dx_auth->get_role_name(),0,1,'utf-8').']', '/request/?sort=mAll', $id, 'Проектный отдел доработал заявку', '0', $row['mid']);

                    $this->db->update('request', array('kp' => 12), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена отделу продаж.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                // Договор подписан
                } elseif($type == 'zaytoproj') {

                    $this->history->setHistory('dt13', $id);

                    $InsProject = array(
                        'date' => time(),
                        'city' => $row['city'],
                        'region' => $row['region'],
                        'street' => $row['street'],
                        'building' => $row['building'],
                        'buildingAdd' => $row['buildingAdd'],
                        'apartment' => $row['apartment'],
                        'rid' => $id,
                        'cid' => $row['cid'],
                    );

                    $this->db->insert('projects', $InsProject);

                    $this->db->update('request', array('kp' => 13), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно авершена. Договор подписан.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                }

                if($this->input->is_ajax_request()) {

                    $this->load->helper('request');

                    $res = array(
                        'kpstatus' => $this->config->item('kpstatus'),
                        'region' => $this->config->item('region'),
                    );

                    //GetData
                    $this->db->order_by("date", "asc");

                    $query = array(
                        'request' => $this->db->get('request')->result_array(),
                        'card' => $this->db->get('card')->result_array(),
                    );

                    $data['result'] = req_parse_data($query, $res);
                    //end GetData

                    $alldata = $this->dx_auth->get_all_data();

                    $alldata['status'] = $this->config->item('status');

                    $alldata['id'] = $data['result'][$id]['id'];

                    $alldata['req'] = $data['result'][$id];

                    echo req_get_status($alldata['status'], $alldata);

                } else {

                    redirect("/request");
                }
            }
		}
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

		if(!empty($id) && $perm == 1) {

            $check = $this->request_model->get_request($id, 'data');

            if($this->dx_auth->get_role_id() == 4) {

                if($check['uid'] == 0) $perm = 0;

                if($check['kp'] != 1 && $check['kp'] != 11) $perm = 0;
            }

            if(!empty($check) && $perm == 1) {

                if($this->input->post('add')) {

                    $this->request_model->update_request($id) ? $data['success'] = "Заявка успешно изменена!" : $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
                }

                $data['result'] = $this->request_model->get_request($id);

                echo $this->twig->render('request/edit.html', $data);

            } else {

                $this->session->set_flashdata('error', 'Нет доступа!');

                redirect("/request");
            }
			
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

            $m_ru = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

            $data['date'] = date("«d»")." ".$m_ru[date("m")-1]." ".date("Y")." г.";

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

        if($first == 2) $data['first'] = 2;

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

                if(!empty($name[0]['signature'])) $data['project']['sign'] = $name[0]['signature'];
                else $data['project']['sign'] = false;

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
         
			$this->db->delete('card', array('id' => $req['cid']));
         
			$this->db->delete('history', array('rid' => $req['id']));

            $this->db->delete('projects', array('cid' => $req['cid']));

			$this->db->delete('request', array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно удалена.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
		}

		redirect("/request");
	}
}
?>