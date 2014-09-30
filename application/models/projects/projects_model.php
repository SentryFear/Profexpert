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

            $ok = $this->db->update('projects', $upd, array('id' => $id));


        }

        return $ok;

    }
}