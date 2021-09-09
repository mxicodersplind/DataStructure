<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Cookie
 *
 * @author Mxicoders
 */
// This is a Cookie Controller . it is an userful to manage the cookie for the particular page
class Cookie extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();

       
        // check the user is login or not by the session
        if ($this->session->userdata('user_id')) {
            $user = $this->common->select_data_by_condition('user', array('id' => $this->session->userdata('user_id'), "user_type" => 0), '*', '', '', '', '', array());
            $this->data['logged_use'] = $user[0];
        }

        // load the header and footer
        $this->data['header'] = $this->load->view('header', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
    }

    //view landing page of site
    public function index() {
        $this->data['pages'] = $this->common->select_data_by_condition('pages', array('page_id' => 13), '*', 'page_id', 'ASC', '', '', array());
        $this->load->view('pages/cookie', $this->data);
    }

}
