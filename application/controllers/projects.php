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
        //$this->load->model('request/request_model');

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

            $res = projects_work_type_pr($this->config->item('worktype'), $res);

            $worktype = serialize($res);

            $insproj = array(
                'date' => time(),
                'cnumber' => $this->input->post('cnumber'),
                'dogdate' => $this->input->post('dogdate'),
                'work' => $this->input->post('work'),
                'city' => $this->input->post('city'),
                'region' => $this->input->post('region'),
                'street' => $this->input->post('street'),
                'building' => $this->input->post('building'),
                'buildingAdd' => $this->input->post('buildingAdd'),
                'apartment' => $this->input->post('apartment'),
                'worktype' => $worktype,
                'cid' => $cid,
            );

            $this->db->insert('projects', $insproj);
            //endprojects
        }

        if($this->input->post('workedt')) {

            if($this->input->post('id')) {

                $updwork = array();

                $updwork = projects_work_type_pr($this->config->item('worktype'), $updwork);

                $updlastedit = array('author' => $this->dx_auth->get_name(), 'date' => time());

                $this->db->update('projects', array('worktype' => serialize($updwork), 'lastedit' => serialize($updlastedit)), array('id' => $this->input->post('id')));
            }

            exit('ok');
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

                $updproj = array(
                    'cnumber' => $this->input->post('cnumber'),
                    'dogdate' => $this->input->post('dogdate'),
                    'work' => $this->input->post('work'),
                    'city' => $this->input->post('city'),
                    'region' => $this->input->post('region'),
                    'street' => $this->input->post('street'),
                    'building' => $this->input->post('building'),
                    'buildingAdd' => $this->input->post('buildingAdd'),
                    'apartment' => $this->input->post('apartment'),
                    'cid' => $cid,
                );

                $this->db->update('projects', $updproj, array('id' => $this->input->post('id')));
            }

            exit('ok1');
        }

        $result['data'] = $this->db->select('*')->from('card')->join('projects', 'projects.cid = card.id', 'RIGHT OUTER')->get()->result_array();

        $respar = array();

        $zadach = array();

        foreach($result['data'] as $i) {

            $i['worktype'] = unserialize($i['worktype']);

            $i['zadach'] = projects_work_type_total($this->config->item('worktype'), $i['worktype'], $i['zadach']);

            $respar[] = $i;
        }

        $result['data'] = $respar;

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

    function work() {

        $id = intval($this->uri->segment(3));

        $tot = '';

        $totsh = '';

        $worktype = array();

        $lastedit = array('author' => 'none', 'date' => '1');

        if(!empty($id) && $this->input->is_ajax_request()) {

            $res = $this->db->get_where('projects', array('id' => $id))->row_array();

            if(!empty($res['worktype'])) $worktype = unserialize($res['worktype']);

            if(!empty($res['lastedit'])) $lastedit = unserialize($res['lastedit']);

            $flt = $this->uri->segment(4);

            $tot = projects_work_type_show($this->config->item('worktype'), $worktype, $tot, $flt);

            echo '
                    <form method="POST" enctype="multipart/form-data" class="form-horizontal" id="workform">
                        <input type="hidden" name="id" value="'.$id.'" id="ths" />
                        <input type="hidden" name="workedt" value="Отправить"/>
                        <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                             <h3 id="myModalLabel">Работа над проектом<br> <small><b>'.$lastedit['author'].'</b> ('.date('d.m.y H:i:s', $lastedit['date']).')</small></h3>
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
                                        $('#scrl').animate({scrollTop: $('#scrl')[0].scrollHeight});
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
                   $(this).datepicker();
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

    function edit() {

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
                        <input class="inline-input datepicker1" type="text" data-date-format="dd.mm.yyyy" id="dogdate" name="dogdate" placeholder="Дата заключения договора" value="'.$res['dogdate'].'">
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
                       $(this).datepicker();
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

    function delete()
    {
        $id = intval($this->uri->segment(3));

        if(!empty($id) && $this->dx_auth->check_permissions('delete') == 1) {

            $this->db->delete('projects', array('id' => $id)) ? $this->session->set_flashdata('success', 'Проект успешно удалён.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
        }

        redirect("/projects");
    }
}