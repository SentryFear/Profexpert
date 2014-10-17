<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Админ
 * Date: 28.03.14
 * Time: 10:37
 */

class projects_model extends CI_Model {

    /**
     * Инициализация
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Добавление документов
     *
     * @return mixed
     */
    function add_docs() {

        $ok = 0;

        $author = $this->dx_auth->get_name();

        $id = $this->input->post('id');

        $row = $this->db->get_where('projects', array('id' => $id))->row_array();

        if(!empty($row) && !empty($author)) {

            $config['upload_path'] = './uploads/projects/';

            $config['max_size']	= '10000';

            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);

            $BaseDocs = array();

            $Docs = array();

            if(!empty($row['docs'])) $BaseDocs = unserialize($row['docs']);

            //Редактирование старых
            $DocsCount = 0;

            $TotDocsCount = 0;

            foreach($BaseDocs as $q) {

                $TotDocsCount++;

                if($this->input->post('name'.$q['id'])) {

                    $q['name'] = $this->input->post('name'.$q['id']);

                    if($this->upload->do_upload('doc'.$q['id'])) {

                        $dt = $this->upload->data();

                        $q['file'] = $dt['file_name'];

                        $q['date'] = time();

                        $q['author'] = $author;
                    }

                    $q['id'] = $DocsCount;

                    $Docs[] = $q;

                    $DocsCount++;
                }
            }

            //Добавление новых
            for($i=$TotDocsCount+1;$i<=100;$i++) {

                if($this->input->post('name'.$i) && $this->upload->do_upload('doc'.$i)) {

                    $name = $this->input->post('name'.$i);

                    $dt = $this->upload->data();

                    $Docs[] = array('id' => $DocsCount, 'author' => $author, 'date' => time(), 'name' => $name, 'file' => $dt['file_name']);

                    $DocsCount++;

                } else {

                    if($i - $TotDocsCount > 10) break;

                }
            }

            $upd['docs'] = serialize($Docs);

            if($this->db->update('projects', $upd, array('id' => $id))) $ok = 'Файлы успешно добалены';
            else $ok = 'Произошла неожиданная ошибка, обратитесь к администратору.';

        }

        return $ok;
    }

    function update_work() {

        $result = '';

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

        if($this->db->update('projects', array('worktype' => serialize($updwork), 'lastedit' => serialize($updlastedit)), array('id' => $this->input->post('id')))) $result = 'Задачи по проекту сохранены';
        else $result = 'Произошла неожиданная ошибка, обратитесь к администратору.';

        return $result;
    }

    function update_info() {

        $result = '';

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
                'more' => $this->input->post('more'),
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
                'more' => $this->input->post('more'),
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

        if($this->db->update('projects', $updproj, array('id' => $this->input->post('id')))) $result = 'Информация сохранена';
        else $result = 'Произошла неожиданная ошибка, обратитесь к администратору.';

        return $result;
    }

    function add_comment() {

        $result = '';

        $id = $this->input->post('id');

        $text = $this->input->post('text');

        $author = $this->dx_auth->get_name();

        $aid = $this->dx_auth->get_user_id();

        $rname = $this->dx_auth->get_role_name();

        $row = $this->db->get_where('projects', array('id' => $id))->row_array();

        $comments = unserialize($row['comments']);

        if(empty($comments)) $comments = array();

        $comments[] = array('aid' => $aid, 'rname' => $rname, 'author' => $author, 'text'=> $text, 'date' => time());

        $upd['comments'] = serialize($comments);

        if($this->db->update('projects', $upd, array('id' => $id))) $result = 'Комментарий успешно добавлен';
        else $result = 'Произошла неожиданная ошибка, обратитесь к администратору.';

        return $result;
    }
}