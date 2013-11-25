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
        $this->load->helper(array('form', 'url'));

        //load request model
        //$this->load->model('request/request_model');

        //load request config
        //$this->config->load('request');
    }

    /**
     * Стартовая страница со списком проектов
     */
    function index()
    {
        $result = array();

        $result['data'] = $this->db->select('*')->from('projects')->join('cCard', 'cCard.id = projects.cid')->get()->result_array();

        //$result = $this->db->get();

        //$result = $this->db->get_where('projects')->result_array();

        echo $this->twig->render('projects/main.html', $result);
    }
}