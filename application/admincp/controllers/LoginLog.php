<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


// login log of the user display on the admin side
class LoginLog extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');


        $this->data['title'] = 'Login Log : ' . $this->data['app_name'];
        //Load header and save in variable
        $this->data['header'] = $this->load->view('header', $this->data, true);
        $this->data['sidebar'] = $this->load->view('sidebar', $this->data, true);
        $this->data['footer'] = $this->load->view('footer', $this->data, true);
        $this->data['redirect_url'] = $this->last_url();
        $this->load->helper('security');
        $this->load->library('user_agent');
        $this->data['country'] = $this->common->select_data_by_condition('country', array(), '*', '', '', '', '', array());
        $this->data['state'] = $this->common->select_data_by_condition('state', array(), '*', 'name', 'ASC', '', '', array());
    }

    // load the view
    public function index() {
        $this->load->view('loginlog/index', $this->data);
    }

    
    // fetch and get the loginlog view details
    public function gettabledata() {
        $request = $this->input->get();
        
        $join_str[0] = array('table' => 'user',
            'join_table_id' => 'user.id',
            'from_table_id' => 'login_log.user_id',
            'join_type' => 'left'
        );
        $condition = array();
        $columns = array('login_log.id', 'user.name', 'login_datetime', 'login_ip', 'browser', 'operating_system', 'login_type');
        $getfiled = "login_log.id as login_log_id, user.name as username, login_datetime, login_ip, browser, operating_system, login_type";
        $this->db->order_by("login_log.id", "desc");
        echo $this->common->getDataTableSource('login_log', $columns, $condition, $getfiled, $request, $join_str, '');
        die();
    }

}
