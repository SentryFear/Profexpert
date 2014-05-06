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

        $id = $this->input->post('id');

        $config['upload_path'] = './uploads/projects';
        //$config['allowed_types'] = 'doc|docx|xls|xlsx|pdf|txt|jpg|gif|jpeg';
        $config['max_size']	= '10000';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        $author = $this->dx_auth->get_username();

        $data['success'] = '';

        $docs1 = array();

        $row = $this->db->get_where('projects', array('id' => $id))->row_array();

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

        for($i=count($docs)+1;$i<=100;$i++) {

            if ($this->upload->do_upload('doc'.$i)) {

                $name = $this->input->post('name'.$i) ? $this->input->post('name'.$i) : $dt['file_name'];

                $data['success'] .= "Документ номер $i с именем $name успешно загружен.<br>";

                $dt = $this->upload->data();

                $docs[] = array('id' => $i, 'author' => $author, 'date' => time(), 'name' => $name, 'file' => $dt['file_name']);

            } else {

                if($i > 10) break;
            }
        }

        if(empty($docs)) {

            $data['error'] = $this->upload->display_errors(false,false);

        } else {

            $upd['docs'] = serialize($docs);

            $this->db->update('projects', $upd, array('id' => $id));

        }

        return $data;
    }
}