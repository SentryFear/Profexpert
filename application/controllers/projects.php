<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Projects
 *
 * Проекты
 */
class Projects extends CI_Controller
{
    /**
     * Инифиализация
     */
    function __construct()
    {
        parent::__construct();

        //load helpers
        $this->load->helper(array('form', 'url', 'projects'));

        //load request model
        $this->load->model('projects/projects_model');

        //load request config
        $this->config->load('request');
    }

    /**
     * Стартовая страница со списком проектов
     */
    function index()
    {
        $result = array();

        $result['success'] = $this->session->flashdata('success');

        $result['error'] = $this->session->flashdata('error');

        if($this->input->post('add')) {

            //client
            $cid = 0;

            if($this->input->post('cid')) $cid = $this->input->post('cid');

            if($cid == 0) {

                $comment[] = array('author' => $this->dx_auth->get_username(), 'text'=> 'Создана карточка клиента', 'date' => time());

                $insclnt = array(
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

                $this->db->insert('card', $insclnt);

                $cid = $this->db->insert_id();

            } else {

                $updclnt = array(
                    'zsurname' => $this->input->post('zsurname'),
                    'zname' => $this->input->post('zname'),
                    'zmname' => $this->input->post('zmname'),
                    'organization' => $this->input->post('organization'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'hear' => $this->input->post('hear')
                );

                $this->db->update('card', $updclnt, array('id' => $cid));

            }
            //endclient

            //projects

            $res = array();

            $lastedit = array();

            $res = projects_work_type_pr($this->config->item('worktype'), $res);

            $worktype = serialize($res);

            $lastedit[] =  array('author' => $this->dx_auth->get_name(), 'date' => time(), 'action' => $res);

            $tdd = '';

            if($this->input->post('dogdate')) {

                $dd = explode('.', $this->input->post('dogdate'));

                $tdd = mktime(0, 0, 0, $dd[1], $dd[0], $dd[2]);
            }

            $insproj = array(
                'date' => time(),
                'cnumber' => $this->input->post('cnumber'),
                'dogdate' => $tdd,
                'work' => $this->input->post('work'),
                'city' => $this->input->post('city'),
                'region' => $this->input->post('region'),
                'street' => $this->input->post('street'),
                'building' => $this->input->post('building'),
                'buildingAdd' => $this->input->post('buildingAdd'),
                'apartment' => $this->input->post('apartment'),
                'MngCompany' => $this->input->post('MngCompany'),
                'worktype' => $worktype,
                'lastedit' => serialize($lastedit),
                'cid' => $cid,
            );

            $this->db->insert('projects', $insproj);
            //endprojects
        }

        if($this->input->post('workedt')) {

            if($this->input->post('id')) {

                $updwork = array();

                $end = array();

                $updwork = projects_work_type_pr($this->config->item('worktype'), $updwork);

                $id = $this->input->post('id');

                $row = $this->db->get_where('projects', array('id' => $id))->row_array();

                $updlastedit = unserialize($row['lastedit']);

                if(empty($updlastedit)) $updlastedit = array();
                else $end = end($updlastedit);

                if($updwork != $end['action']) $updlastedit[] = array('author' => $this->dx_auth->get_name(), 'date' => time(), 'action' => $updwork);

                if(count($updlastedit) > 6) unset($updlastedit[1]);

                $updlastedit = array_values($updlastedit);

                $this->db->update('projects', array('worktype' => serialize($updwork), 'lastedit' => serialize($updlastedit)), array('id' => $this->input->post('id')));
            }

            return 'ok';
        }

        if($this->input->post('edit')) {

            if($this->input->post('id')) {

                $cid = 0;

                if($this->input->post('cid')) $cid = $this->input->post('cid');

                if($cid == 0) {

                    $comment[] = array('author' => $this->dx_auth->get_username(), 'text'=> 'Создана карточка клиента', 'date' => time());

                    $insclnt = array(
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

                    $this->db->insert('card', $insclnt);

                    $cid = $this->db->insert_id();

                } else {

                    $updclnt = array(
                        'zsurname' => $this->input->post('zsurname'),
                        'zname' => $this->input->post('zname'),
                        'zmname' => $this->input->post('zmname'),
                        'organization' => $this->input->post('organization'),
                        'phone' => $this->input->post('phone'),
                        'email' => $this->input->post('email'),
                        'hear' => $this->input->post('hear')
                    );

                    $this->db->update('card', $updclnt, array('id' => $cid));
                }

                $tdd = '';

                if($this->input->post('dogdate')) {

                    $dd = explode('.', $this->input->post('dogdate'));

                    $tdd = mktime(0, 0, 0, $dd[1], $dd[0], $dd[2]);
                }

                $updproj = array(
                    'cnumber' => $this->input->post('cnumber'),
                    'dogdate' => $tdd,
                    'work' => $this->input->post('work'),
                    'city' => $this->input->post('city'),
                    'region' => $this->input->post('region'),
                    'street' => $this->input->post('street'),
                    'building' => $this->input->post('building'),
                    'buildingAdd' => $this->input->post('buildingAdd'),
                    'apartment' => $this->input->post('apartment'),
                    'MngCompany' => $this->input->post('MngCompany'),
                    'cid' => $cid,
                );

                $this->db->update('projects', $updproj, array('id' => $this->input->post('id')));
            }

            return 'ok';
        }

        if($this->input->post('comments') && $this->input->post('id')) {

            if($this->input->post('text')) {

                //$this->load->library('history');

                //$this->load->library('notification');

                $id = $this->input->post('id');

                $text = $this->input->post('text');

                $author = $this->dx_auth->get_name();

                $aid = $this->dx_auth->get_user_id();

                $rname = $this->dx_auth->get_role_name();

                $row = $this->db->get_where('projects', array('id' => $id))->row_array();

                //$this->notification->setNotification('Новый комментарий ['.$id.']', '/request/?sort=mAll', $id, 'Новый комментарий к заявке', '0', $row['mid']);

                $comments = unserialize($row['comments']);

                if(empty($comments)) $comments = array();

                $comments[] = array('aid' => $aid, 'rname' => $rname, 'author' => $author, 'text'=> $text, 'date' => time());

                //if($this->dx_auth->get_role_id() == '2' || $this->dx_auth->get_role_id() == '6') {

                    //$upd['kp'] = 9;

                    //$this->history->setHistory('dt9', $id);
                //}

                $upd['comments'] = serialize($comments);

                $this->db->update('projects', $upd, array('id' => $id)) ? $data['success'] = "Заявка успешно отправлена на доработку!" : $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
            }

            return 'ok';
        }

        if($this->input->post('upload') && $this->input->post('id')) {

            $data = $this->projects_model->add_docs();

            //var_dump($data);

            return 'ok';
        }

        $result['data'] = $this->db->select('*')->from('card')->join('projects', 'projects.cid = card.id', 'RIGHT OUTER')->order_by('dogdate asc, cnumber asc')->get()->result_array();
            //->limit(10,10)->get()->result_array();

        $respar = array();

        $zadach = array();

        $result['stats'] = array(
            'all' => array('close' => 0, 'notfill' => 0, 'work' => 0, 'all' => 0, 'tasktoday' => 0, 'tasktomorrow' => 0),
            'datest' => array()
        );

        $result['tasks'] = array();

        $tasks = array();

        foreach($result['data'] as $i) {

            $i['worktype'] = unserialize($i['worktype']);

            $i['unixtime'] = '';

            $i['success'] = 0;

            $i['notfill'] = 0;

            if(!empty($i['worktype']['rabotaszakzakrytdogovordata']['value'])) $i['success'] = 1;

            if(empty($i['worktype'])) $i['notfill'] = 1;

            if(!empty($i['worktype']['doverennstsrokokonchaniyadata']['value'])) {

                $dogdt = explode('.', $i['worktype']['doverennstsrokokonchaniyadata']['value']);

                $i['unixtime'] = mktime(0, 0, 0, $dogdt[1], $dogdt[0], $dogdt[2]);
            }

            $i['comments'] = unserialize($i['comments']);

            $i['docs'] = unserialize($i['docs']);

            $i['zadach'] = projects_work_type_total(projects_work_type_bd($this->config->item('worktype'), $i['worktype']), $i['zadach']);

            if(count($i['zadach']) > 0) $tasks = projects_work_type_task($i);

            $result['tasks'] = array_merge ($result['tasks'], $tasks);

            $result['stats']['all']['tasktoday'] += count($tasks['today']);

            $result['stats']['all']['tasktomorrow'] += count($tasks['tomorrow']);

            //stats
            $datest = !empty($i['dogdate']) ? date("Y", $i['dogdate']) : date("Y", $i['date']);

            //$result['stats']['datest'][$datest] = $datest;

            $thsyesr = date("Y");

            if(($thsyesr - $datest) < 3) {

                if(!isset($result['stats']['datest'][$datest])) $result['stats']['datest'][$datest] = array('datest' => $datest,'close' => 0, 'notfill' => 0, 'work' => 0, 'all' => 0);

                $result['stats']['datest'][$datest]['all']++;

                if(empty($i['worktype'])) {

                    $result['stats']['datest'][$datest]['notfill']++;

                    $result['stats']['datest'][$datest]['work']++;

                } elseif(!empty($i['worktype']['rabotaszakzakrytdogovordata']['value'])) {

                    $result['stats']['datest'][$datest]['close']++;

                } else {

                    $result['stats']['datest'][$datest]['work']++;
                }

            } else {

                if(!isset($result['stats']['datest'][$thsyesr-3])) $result['stats']['datest'][$thsyesr-3] = array('datest' => ($thsyesr-3), 'text' => 'До '.($thsyesr-2).' года', 'close' => 0, 'notfill' => 0, 'work' => 0, 'all' => 0);

                $result['stats']['datest'][$thsyesr-3]['all']++;

                if(empty($i['worktype'])) {

                    $result['stats']['datest'][$thsyesr-3]['notfill']++;

                    $result['stats']['datest'][$thsyesr-3]['work']++;

                } elseif(!empty($i['worktype']['rabotaszakzakrytdogovordata']['value'])) {

                    $result['stats']['datest'][$thsyesr-3]['close']++;

                } else {

                    $result['stats']['datest'][$thsyesr-3]['work']++;
                }
            }


            $result['stats']['all']['all']++;

            if(empty($i['worktype'])) {

                $result['stats']['all']['notfill']++;

                $result['stats']['all']['work']++;

            } elseif(!empty($i['worktype']['rabotaszakzakrytdogovordata']['value'])) {

                $result['stats']['all']['close']++;

            } else {

                $result['stats']['all']['work']++;
            }
            //end stats

            $respar[] = $i;
        }

        ksort($result['stats']['datest']);
        //var_dump($result['stats']['datest']);

        $result['data'] = $respar;

        $sr = '';

        $result['search'] = projects_work_type_to_search($this->config->item('worktype'), $sr);

        $wt = '';

        $result['wktp'] = projects_work_type($this->config->item('worktype'), $wt);

        $result['client'] = array('0' => array('none' => 'Не выбрано'));

        $this->db->order_by('zsurname asc, zname asc, zmname asc');

        $client = $this->db->get_where('card')->result_array();

        foreach($client as $i) {

            $result['client'][$i['id']] = $i;
        }

        //$result = $this->db->get();

        //$result = $this->db->get_where('projects')->result_array();

        echo $this->twig->render('projects/main.html', $result);
    }


    function calendar()
    {
        $result = array();

        $result['data'] = $this->db->select('*')->from('card')->join('projects', 'projects.cid = card.id', 'RIGHT OUTER')->order_by('dogdate asc, cnumber asc')->get()->result_array();

        $result['tasks'] = array();

        $result['region'] = array();

        $result['prtasks'] = array();

        $result['prregion'] = array();

        $tasks = array();

        foreach($result['data'] as $i) {

            $i['worktype'] = unserialize($i['worktype']);

            $i['zadach'] = projects_work_type_total(projects_work_type_bd($this->config->item('worktype'), $i['worktype']), $i['zadach']);

            if(count($i['zadach']) > 0) $tasks = projects_work_type_task($i);

            $result['tasks'] = array_merge ($result['tasks'], $tasks['nztask']);

            $result['region'] = array_merge ($result['region'], $tasks['nzreg']);

            $result['prtasks'] = array_merge ($result['prtasks'], $tasks['prtask']);

            $result['prregion'] = array_merge ($result['prregion'], $tasks['prreg']);
        }

        //var_dump($result['tasks']);

        echo $this->twig->render('projects/calendar.html', $result);
    }

    function getCalendar()
    {
        $result = array();

        $result['data'] = $this->db->select('*')->from('card')->join('projects', 'projects.cid = card.id', 'RIGHT OUTER')->order_by('dogdate asc, cnumber asc')->get()->result_array();

        $result['tasks'] = array();

        $tasks = array();

        foreach($result['data'] as $i) {

            $i['worktype'] = unserialize($i['worktype']);

            $i['zadach'] = projects_work_type_total(projects_work_type_bd($this->config->item('worktype'), $i['worktype']), $i['zadach']);

            if(count($i['zadach']) > 0) $tasks = projects_work_type_task($i);

            $result['tasks'] = array_merge ($result['tasks'], $tasks['task']);
        }

        $OutCal = array();

        foreach($result['tasks'] as $q) {

            $color = '#278ccf';

            $note = '';

            if(isset($q['ins'])) {

                if($q['ins'] == 'mvk') $color = '#C67605';
                if($q['ins'] == 'pib') $color = '#356635';
            }

            if(!empty($q['note'])) $note = "\n\rПримечание: ".$q['note'];

            $OutCal[] = array('rid' => $q['id'], 'color' => $color, 'start' => isset($q['date']) ? $q['date'] : '', 'name' => $q['name'], 'title' => "Район: ".$q['region']."\n\rАдрес: ".$q['address']."\n\r".$q['task'].$note);
        }

        echo json_encode($OutCal);
    }

    function setCalendar()
    {
        $id = intval($this->input->post('rid'));

        $name = $this->input->post('name');

        $cdate = intval($this->input->post('cdate'));

        if(!empty($id) && $this->input->is_ajax_request()) {

            $wt = array();

            $res = $this->db->get_where('projects', array('id' => $id))->row_array();

            $wt = unserialize($res['worktype']);

            if(!isset($wt[$name])) $wt[$name] = array('value'=> '', 'ord' => '', 'note' => '', 'cdate' => $cdate);
            else $wt[$name]['cdate'] = $cdate;

            $upd['worktype'] = serialize($wt);

            $this->db->update('projects', $upd, array('id' => $id));

            echo 'ok';
        }
    }

    function delCalendarEvent()
    {
        $id = intval($this->input->post('rid'));

        $name = $this->input->post('name');

        $cdate = '';

        if(!empty($id) && $this->input->is_ajax_request()) {

            $wt = array();

            $res = $this->db->get_where('projects', array('id' => $id))->row_array();

            $wt = unserialize($res['worktype']);

            if(!isset($wt[$name])) $wt[$name] = array('value'=> '', 'ord' => '', 'note' => '', 'cdate' => $cdate);
            else $wt[$name]['cdate'] = $cdate;

            $upd['worktype'] = serialize($wt);

            $this->db->update('projects', $upd, array('id' => $id));

            echo 'ok';
        }
    }
    /**
     * Добавление файлов открывается с помощью AJAX
     */
    function docs()
    {
        $id = intval($this->uri->segment(3));

        $docs = array();

        if(!empty($id) && $this->input->is_ajax_request()) {

            $res = $this->db->get_where('projects', array('id' => $id))->row_array();

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
								<a href="/uploads/projects/'.$i['file'].'" target="_blank" class="btn btn-mini" data-toggle="tooltip" data-original-title="Скачать файл" data-placement="left"><i class="icon-download-alt"></i> Скачать файл</a>
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

                            xhr.open('POST', '/projects');

                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4) {
                                    if(xhr.status == 200) {
                                        data = xhr.responseText;
                                        $('#load').load('/projects/docs/'+$('#ths').val(), function() {
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

            redirect("/projects");
        }
    }

    function work()
    {
        $id = intval($this->uri->segment(3));

        $tot = '';

        $totsh = '';

        $end = array();

        $endle = '';

        $cendle = '';

        $current = array();

        $worktype = array();

        $lastedit[] = array('author' => 'none', 'date' => '1', 'action' => array());

        if(!empty($id) && $this->input->is_ajax_request()) {

            $res = $this->db->get_where('projects', array('id' => $id))->row_array();

            if(!empty($res['worktype'])) $worktype = unserialize($res['worktype']);

            if(!empty($res['lastedit'])) $lastedit = unserialize($res['lastedit']);

            $flt = $this->uri->segment(4);

            $tot = projects_work_type_show($this->config->item('worktype'), $worktype, $tot, $flt);

            $letot = '';

            foreach($lastedit as $kle => $le) {

                if(empty($letot)) {

                    $letot .= '<small><span style="cursor: pointer;" data-toggle="tooltip" data-original-title="Посмотреть изменения" onclick="$(\'#le'.$kle.'\').toggle(\'slow\');">Добавил <b>'.$le['author'].'</b> ('.date('d.m.y H:i:s', $le['date']).')</span>&nbsp;<i onclick="$(\'#all\').toggle(\'slow\');" style="cursor: pointer;" data-toggle="tooltip" data-original-title="Посмотреть все изменения" class="icon-tasks"></i></small><br>';

                    $cendle = projects_last_edit($this->config->item('worktype'), $le['action'], $cendle);

                    $letot .= '<div style="display:none;" id="le'.$kle.'">'.$cendle.'</div><div id="all" style="display:none;">';

                } else {

                    $tot1 = $le['action'];

                    $letot .= '<small style="cursor: pointer;" data-toggle="tooltip" data-original-title="Посмотреть изменения" onclick="$(\'#le'.$kle.'\').toggle(\'slow\');">Изменил <b>'.$le['author'].'</b> ('.date('d.m.y H:i:s', $le['date']).')</small><br>';

                    foreach($current['action'] as $ek => $e)  {

                        foreach($le['action'] as $ck => $c) {

                            if($ek == $ck && $e['note'] == $c['note'] && $e['ord'] == $c['ord'] && $e['value'] == $c['value']) unset($tot1[$ck]);
                        }
                    }

                    $endle = projects_last_edit($this->config->item('worktype'), $tot1, $endle);

                    $letot .= '<div style="display:none;" id="le'.$kle.'">'.$endle.'</div>';
                }

                //$letot .= '<div style="display:none;" id="le'.$kle.'">'.$cendle.'</div>';

                $current = $le;
            }
            $letot .= '</div>';
            /*$current = current($lastedit);

            $end = end($lastedit);

            $tot1 = $end['action'];
            //var_dump($end);
            foreach($current['action'] as $ek => $e)  {

                foreach($end['action'] as $ck => $c) {

                    if($ek == $ck && $e['note'] == $c['note'] && $e['ord'] == $c['ord'] && $e['value'] == $c['value']) unset($tot1[$ck]);
                }
            }*/

//var_dump($tot1);

            //$endle = projects_last_edit($this->config->item('worktype'), $tot1, $endle);

           //$cendle = projects_last_edit($this->config->item('worktype'), $current['action'], $cendle);

            $info = '';

            $info .= !empty($res['cnumber']) ? '<b>'.$res['cnumber'].'</b> ' : '';
            $info .= !empty($res['street']) ? $res['street'] : '';
            $info .= !empty($res['building']) ? ', д. '.$res['building'] : '';
            $info .= !empty($res['buildingAdd']) ? ', корп/лит. '.$res['buildingAdd'] : '';
            $info .= !empty($res['apartment']) ? ', кв. '.$res['apartment'] : '';

            echo '
                    <form method="POST" enctype="multipart/form-data" class="form-horizontal" id="workform">
                        <input type="hidden" name="id" value="'.$id.'" id="ths" />
                        <input type="hidden" name="workedt" value="Отправить"/>
                        <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                             <h3 id="myModalLabel">Работа над проектом <small>'.$info.'</small><br>';

            echo $letot;

            /*echo '<small onclick="$(\'#cendle\').toggle(\'slow\');">Добавил <b>'.$current['author'].'</b> ('.date('d.m.y H:i:s', $current['date']).')</small><br>';

            echo '<div style="display:none;" id="cendle">'.$cendle.'</div>';

            echo '<small onclick="$(\'#endle\').toggle(\'slow\');">Изменил <b>'.$end['author'].'</b> ('.date('d.m.y H:i:s', $end['date']).')</small><br>';

            echo '<div style="display:none;" id="endle">'.$endle.'</div>';*/

            echo '</h3>
                        </div>
                        <div class="modal-body" id="scrl"><a href="javascript:void(0)" class="btn" onclick="$(\'.shch\').show();">Редактировать список</a><br><br>';

            echo $tot;

            echo '</div>
              <div class="modal-footer">
                <div class="btn-group">
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                  <input type="submit" class="btn btn-primary" name="work" value="Сохранить" />
                </div>
              </div></form>';
            echo "<script>
				(function($) {
				$(function() {
				    $('#workform').submit(function() {
                        var str = $(this).serialize();

                        $. ajax ({
                            type: 'POST',
                            url: '/projects',
                            data: str,
                            success: function(msg) {

                                $('#load').load('/projects/work/'+$('#ths').val(), function() {
                                        //$('#scrl').animate({scrollTop: $('#scrl')[0].scrollHeight});
                                })


                            }
                        });

                        return false;
                    });
				})
				})(jQuery)
				</script>";

            echo "<script>
                $('.datepicker1').live('focus', function(){
                   $(this).datepicker({
                        language: 'ru'
                    });
                });
				/*$('.modal-body').ready(function(){
				        $('.datepicker1').datepicker();
				})*/
				function tglcheck(shcls) {
                    $('.'+shcls).toggle(document.getElementById(shcls+'ch').checked);
                }
				</script>";
        }
    }

    function comments()
    {
        $id = intval($this->uri->segment(3));

        if(!empty($id) && $this->input->is_ajax_request()) {

            $res = $this->db->get_where('projects', array('id' => $id))->row_array();

            if(!empty($res['comments'])) $more = unserialize($res['comments']);
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

            foreach($more as $i) {

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
                            url: '/projects',
                            data: str,
                            success: function(msg) {

                                $('#load').load('/projects/comments/'+$('#ths').val(), function() {
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

            redirect("/projects");
        }

    }

    function edit()
    {
        $id = intval($this->uri->segment(3));

        if(!empty($id) && $this->input->is_ajax_request()) {

            $res = $this->db->get_where('projects', array('id' => $id))->row_array();

            $rclient = array('0' => array('none' => 'Не выбрано'));

            $this->db->order_by('zsurname asc, zname asc, zmname asc');

            $client = $this->db->get_where('card')->result_array();

            foreach($client as $i) {

                $rclient[$i['id']] = $i;
            }

            echo '<form method="POST" enctype="multipart/form-data" class="form-horizontal" id="editform">
                        <input type="hidden" name="id" value="'.$id.'" id="ths" />
                        <input type="hidden" name="edit" value="Отправить"/>
                        <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                             <h3 id="myModalLabel">Работа над проектом</h3>
                        </div>
                        <div class="modal-body" id="scrl">';

            $dd = (!empty($res['dogdate']) && !strstr($res['dogdate'], '.')) ? date("d.m.Y", $res['dogdate']) : $res['dogdate'];

            echo '
                <div class="control-group">
                    <label class="control-label" for="cnumber">№ договора</label>
                    <div class="controls">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="projects" data-tpol="cnumber" id="cnumber" name="cnumber" placeholder="№ договора" value="'.$res['cnumber'].'">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="cnumber">Дата заключения договора</label>
                    <div class="controls">
                        <input class="inline-input datepicker1" type="text" data-date-format="dd.mm.yyyy" id="dogdate" name="dogdate" placeholder="Дата заключения договора" value="'.$dd.'">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="work">Работа</label>
                    <div class="controls">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="projects" data-tpol="work" id="work" name="work" placeholder="Работа" value="'.$res['work'].'">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="city">Адрес</label>
                    <div class="controls">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="projects" data-tpol="city" id="city" name="city" placeholder="Город" value="'.$res['city'].'">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="projects" data-tpol="region" id="region" name="region" placeholder="Район" value="'.$res['region'].'">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="projects" data-tpol="street" id="street" name="street" placeholder="Улица" value="'.$res['street'].'">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="projects" data-tpol="building" id="building" name="building" placeholder="Дом" value="'.$res['building'].'">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="projects" data-tpol="buildingAdd" id="buildingAdd" name="buildingAdd" placeholder="Корп/Лит" value="'.$res['buildingAdd'].'">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="projects" data-tpol="apartment" id="apartment" name="apartment" placeholder="кв/пом." value="'.$res['apartment'].'">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="work">Управляющая Компания</label>
                    <div class="controls">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="projects" data-tpol="MngCompany" id="MngCompany" name="MngCompany" placeholder="Управляющая Компания" value="'.$res['MngCompany'].'">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="client">Клиент</label>
                    <div class="controls">
                        <div class="ui-select" style="width: auto;">
                            <select name="cid" id="clnt">';
                                foreach($rclient as $k => $v) {

                                    $select = '';

                                    $zsurname = (!empty($v['zsurname'])) ? $v['zsurname'] : '';

                                    $zname = (!empty($v['zname'])) ? $v['zname'] : '';

                                    $zmname = (!empty($v['zmname'])) ? $v['zmname'] : '';

                                    $organization = (!empty($v['organization'])) ? '('.$v['organization'].')' : '';

                                    $phone = (!empty($v['phone'])) ? $v['phone'] : '';

                                    $email = (!empty($v['email'])) ? $v['email'] : '';

                                    if($res['cid'] == $k) {

                                        $select = 'selected';

                                        $res['clnt'] = $v;
                                    }

                                    echo '<option value="'.$k.'" data-sn="'.$zsurname.'" data-n="'.$zname.'" data-mn="'.$zmname.'" data-org="'.$organization.'" data-phone="'.$phone.'" data-email="'.$email.'" '.$select.'>'.$zsurname.' '.$zname.' '.$zmname.' '.$organization.'</option>';
                                }
                echo '
                            </select>
                        </div>
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="card" data-tpol="zsurname" id="zsurname" name="zsurname" placeholder="Фамилия" autocomplete="off" value="'.$res['clnt']['zsurname'].'">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="card" data-tpol="zname" id="zname" name="zname" placeholder="Имя" autocomplete="off" value="'.$res['clnt']['zname'].'">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="card" data-tpol="zmname" id="zmname" name="zmname" placeholder="Отчество" autocomplete="off" value="'.$res['clnt']['zmname'].'">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="card" data-tpol="organization" id="organization" name="organization" placeholder="Организация" autocomplete="off" value="'.$res['clnt']['organization'].'">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="card" data-tpol="phone" id="phone" name="phone" placeholder="Телефон" autocomplete="off" value="'.$res['clnt']['phone'].'">
                        <input class="inline-input autocomp ui-autocomplete-input" type="text" data-tbl="card" data-tpol="email" id="email" name="email" placeholder="Email" autocomplete="off" value="'.$res['clnt']['email'].'">
                    </div>
                </div>';

            echo '</div>
              <div class="modal-footer">
                <div class="btn-group">
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                  <input type="submit" class="btn btn-primary" name="work" value="Сохранить" />
                </div>
              </div></form>';

            echo "
<script>
				(function($) {
				$(function() {
				    $('.datepicker1').live('focus', function(){
                       $(this).datepicker({
                            language: 'ru'
                        });
                    });

				    $('#editform').submit(function() {
                        var str = $(this).serialize();

                        $. ajax ({
                            type: 'POST',
                            url: '/projects',
                            data: str,
                            success: function(msg) {

                                $('#load').load('/projects/edit/'+$('#ths').val(), function() {
                                        $('#scrl').animate({scrollTop: $('#scrl')[0].scrollHeight});
                                })


                            }
                        });

                        return false;
                    });

                    $('#clnt').change(function () {
                      //$(this).html('test');
                      $('#zsurname').val($(this).find('option:selected').data('sn'));
                      $('#zname').val($(this).find('option:selected').data('n'));
                      $('#zmname').val($(this).find('option:selected').data('mn'));
                      $('#organization').val($(this).find('option:selected').data('org'));
                      $('#phone').val($(this).find('option:selected').data('phone'));
                      $('#email').val($(this).find('option:selected').data('email'));
                      $('#hear').val($(this).find('option:selected').data('hear'));
                    });

                    var cache = {};

                    var tpol = 'address';

                    var tbl = 'address';

                    $('.autocomp')
                        .focus(function(){
                            tpol = $(this).data('tpol');
                            //console.log(tpol);
                            tbl = $(this).data('tbl');
                        })
                        .autocomplete({
                            source: function( request, response ) {
                                var term = request.term;
                                if ( term+tpol in cache ) {
                                    response( cache[ term+tpol ] );
                                    return;
                                }

                                $.getJSON( '/api/getAutocomplete/'+tbl+'/'+tpol, request, function( data, status, xhr ) {
                                    cache[ term+tpol ] = data;
                                    response( data );
                                });
                            },
                            //source: '/api/getAutocomplete/address',
                            delay:10,
                            cacheLength:10
                        });

                    $('#phone').mask('+7 (999) 999-99-99');
				})
				})(jQuery)
				</script>";
        }
    }

    function getProjects() {

        $return = array();

        $key = 0;

        $wt = $this->security->xss_clean($this->uri->segment(3));

        $term = $this->security->xss_clean($this->uri->segment(4));

        if($this->input->get('key')) $key = $this->input->get('key');

        $res = $this->db->select('*')
                ->from('card')
                ->join('projects', 'projects.cid = card.id', 'RIGHT OUTER')
                ->like('cnumber', $term)
                ->or_like('work', $term)
                ->or_like('city', $term)
                ->or_like('region', $term)
                ->or_like('street', $term)
                ->or_like('building', $term)
                ->or_like('buildingAdd', $term)
                ->or_like('apartment', $term)
                ->or_like('zsurname', $term)
                ->or_like('zname', $term)
                ->or_like('zmname', $term)
                ->or_like('organization', $term)
                ->or_like('phone', $term)
                ->or_like('email', $term)
                ->or_like('hear', $term)
                ->order_by('dogdate asc, cnumber asc')
                ->get()
                ->result_array();

        foreach($res as $i) {

            if(!empty($wt)) {

                if(!empty($i['worktype'])) {

                    $sr = unserialize($i['worktype']);

                    foreach($sr as $ks => $s) {

                        if($ks == $wt && empty($s['value'])) $return[] = $i['id'];
                    }
                }

            } elseif(!empty($key)) {

                if($key == 'unfilled') {

                    if(empty($i['worktype'])) {

                        $return[] = $i['id'];

                    } else {

                        $sr = unserialize($i['worktype']);

                        if(empty($sr)) $return[] = $i['id'];
                    }

                } elseif(strstr($key, 'year')) {

                    $year = preg_replace('#[^0-9]#','',$key);

                    $thsyear = date("Y");

                    $datest = !empty($i['dogdate']) ? date("Y", $i['dogdate']) : date("Y", $i['date']);

                    if(($thsyear - $year) == 3 && $datest < $year) $datest = $year;

                    if($datest == $year) $return[] = $i['id'];

                } elseif($key == 'allwork') {

                    if(!empty($i['worktype'])) {

                        $sr = unserialize($i['worktype']);

                        if(empty($sr['rabotaszakzakrytdogovordata']['value'])) $return[] = $i['id'];

                    } else {

                        $return[] = $i['id'];
                    }

                } elseif($key == 'allclose') {

                    if(!empty($i['worktype'])) {

                        $sr = unserialize($i['worktype']);

                        if(!empty($sr['rabotaszakzakrytdogovordata']['value'])) $return[] = $i['id'];
                    }

                } else {

                    $return[] = $i['id'];
                }

            } else {

                $return[] = $i['id'];
            }

        }

        echo json_encode($return);
    }

    function delete()
    {
        $id = intval($this->uri->segment(3));

        if(!empty($id) && $this->dx_auth->check_permissions('delete') == 1) {

            $this->db->delete('projects', array('id' => $id)) ? $this->session->set_flashdata('success', 'Проект успешно удалён.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
        }

        redirect("/projects");
    }
}