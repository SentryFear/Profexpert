<?php
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 24.09.14
 * Time: 15:37
 */

class Tasks extends CI_Controller
{
    /**
     * Инифиализация
     */
    function __construct()
    {
        parent::__construct();

        //load helpers
        $this->load->helper(array('form', 'url', 'tasks'));

        //load request model
        //$this->load->model('dx_auth/users_model');

        //load request config
        //$this->config->load('request');
    }

    /**
     * Стартовая страница
     */
    function index()
    {
        $result = array();

        $result['success'] = $this->session->flashdata('success');

        $result['error'] = $this->session->flashdata('error');

        if($this->input->post('add') && $this->input->post('rid') && $this->input->post('name')) {

            $this->load->library('history');

            $this->load->library('notification');

            //tasks
            $instask = array(
                'date' => time(),
                'name' => $this->input->post('name'),
                'cid' => $this->dx_auth->get_user_id(),
                'rid' => $this->input->post('rid')
            );

            $this->db->insert('tasks', $instask);

            $id = $this->db->insert_id();

            $own = $this->dx_auth->get_user_by_id($this->dx_auth->get_user_id());

            $own = short_user_name($own['name']);

            $this->history->setHistory('taskdt1', $id);

            $this->notification->setNotification('['.$id.'] Новая Задача ['.$own.']', '/tasks/', $id, 'Задача выдана '.$own, '0', $this->input->post('rid'));
            //endtasks
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

                $row = $this->db->get_where('tasks', array('id' => $id))->row_array();

                if($aid == $row['cid']) $own = $row['rid'];
                elseif($aid == $row['rid']) $own = $row['cid'];

                $this->notification->setNotification('Новый комментарий ['.$id.']', '/tasks/', $id, 'Новый комментарий к задаче', '0', $own);

                $comments = unserialize($row['comments']);

                if(empty($comments)) $comments = array();

                $comments[] = array('aid' => $aid, 'rname' => $rname, 'author' => $author, 'text'=> $text, 'date' => time());

                //if($this->dx_auth->get_role_id() == '2' || $this->dx_auth->get_role_id() == '6') {

                //$upd['kp'] = 9;

                //$this->history->setHistory('dt9', $id);
                //}

                $upd['comments'] = serialize($comments);

                $this->db->update('tasks', $upd, array('id' => $id)) ? $data['success'] = "Заявка успешно отправлена на доработку!" : $data['error'] = "Произошла неожиданная ошибка, обратитесь к системному администратору.";
            }

            return 'ok';
        }

        $this->db->where('cid', $this->dx_auth->get_user_id());

        $this->db->or_where('rid', $this->dx_auth->get_user_id());

        $this->db->order_by('date', 'asc');

        $query = $this->db->get('tasks');

        $result['data'] = $query->result_array();

        foreach($result['data'] as $k => $i) {

            $type = 0;

            if($this->dx_auth->get_user_id() == $i['cid']) $type = 2;

            if($this->dx_auth->get_user_id() == $i['rid']) $type = 1;

            if($this->dx_auth->get_user_id() == $i['rid'] && $this->dx_auth->get_user_id() == $i['cid']) $type = 3;

            $i['comments'] = unserialize($i['comments']);

            $i['cid'] = $this->dx_auth->get_user_by_id($i['cid']);

            $i['rid'] = $this->dx_auth->get_user_by_id($i['rid']);

            $i['status'] = tasks_get_status(array('id' => $i['id'], 'status' => $i['status'], 'type' => $type));

            $result['data'][$k] = $i;
        }

        $result['respons'] = array();

        $this->load->model('dx_auth/users_model', 'users_model');

        $users = $this->users_model->get_all()->result_array();

        foreach($users as $i) {

            if($i['banned'] == 1) continue;

            if(($this->dx_auth->is_admin() != true && $this->dx_auth->get_role_id() != 6) && $this->dx_auth->get_user_id() != $i['id']) continue;

            $result['respons'][$i['id']] = $i['name'];

        }

        echo $this->twig->render('tasks/main.html', $result);
    }

    /**
     * Изменение статуса задачи
     *
     * taskdt1 - задача выдана
     * taskdt2 - задача принята
     * taskdt3 - задача выполнена
     */
    function send()
    {
        $type = $this->uri->segment(3);

        $id = intval($this->uri->segment(4));

        $this->load->library('history');

        $this->load->library('notification');

        if(!empty($id)) {

            $row = $this->db->get_where('tasks', array('id' => $id))->row_array();

            if(!empty($row)) {

                $own = $this->dx_auth->get_user_by_id($row['rid']);

                $own = short_user_name($own['name']);

                //ответсвенный принял задачу
                if($type == 'take') {

                    $this->history->setHistory('taskdt2', $id);

                    $this->notification->setNotification('['.$id.'] Принято ['.$own.']', '/tasks/', $id, 'Задача принята '.$own, '0', $row['cid']);

                    $this->db->update('tasks', array('status' => 1), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена проектировщикам.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                } elseif($type == 'success') {

                    $this->history->setHistory('taskdt3', $id);

                    $this->notification->setNotification('['.$id.'] Выполнена ['.$own.']', '/tasks/', $id, 'Задача выполнена '.$own, '0', $row['cid']);

                    $this->db->update('tasks', array('status' => 2), array('id' => $id)) ? $this->session->set_flashdata('success', 'Заявка успешно отправлена проектировщикам.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');

                }
            }
        }
    }

    function getStatus() {

        if($this->input->is_ajax_request()) {

            $result = array();

            $this->db->where('cid', $this->dx_auth->get_user_id());

            $this->db->or_where('rid', $this->dx_auth->get_user_id());

            $query = $this->db->get('tasks');

            $result['data'] = $query->result_array();

            $result['task'] = array();

            foreach($result['data'] as $k => $i) {

                $type = 0;

                if($this->dx_auth->get_user_id() == $i['cid']) $type = 2;

                if($this->dx_auth->get_user_id() == $i['rid']) $type = 1;

                if($this->dx_auth->get_user_id() == $i['rid'] && $this->dx_auth->get_user_id() == $i['cid']) $type = 3;

                $i['status'] = tasks_get_status(array('id' => $i['id'], 'status' => $i['status'], 'type' => $type));

                $result['task'][] = array('id' => $i['id'], 'text' => $i['status']);
            }

            echo json_encode($result['task']);

        } else {

            echo 'err';
        }
    }

    function comments()
    {
        $id = intval($this->uri->segment(3));

        if(!empty($id) && $this->input->is_ajax_request()) {

            $res = $this->db->get_where('tasks', array('id' => $id))->row_array();

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
                <textarea class="span6 wysihtml5" rows="5" name="text" id="text" placeholder="Комментарий к проекту" style="float: left; width: 655px; margin-bottom: 15px;"></textarea>
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
                            url: '/tasks',
                            data: str,
                            success: function(msg) {

                                $('#load').load('/tasks/comments/'+$('#ths').val(), function() {
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

            redirect("/tasks");
        }

    }

    function delete()
    {
        $id = intval($this->uri->segment(3));

        if(!empty($id) && $this->dx_auth->check_permissions('delete') == 1) {

            $this->db->delete('tasks', array('id' => $id)) ? $this->session->set_flashdata('success', 'Задача успешно удалён.') : $this->session->set_flashdata('error', 'Произошла неожиданная ошибка, обратитесь к системному администратору.');
        }

        echo 'Удалено!';
        //redirect("/tasks");
    }
}