<?php

ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Dashboard
 *
 * @author Mxicoders
 */
class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();

        // Clear the Catch of this site
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');

        $this->data['title'] = $this->data['site_name'] . ': Dashboard';
        $this->data['letsbegin'] = $this->common->select_data_by_condition('pages', array(), '*', 'page_id', 'ASC', '', '', array());


        // check the user is login or not by the session
        if ($this->session->userdata('user_id')) {
            $user = $this->common->select_data_by_condition('user', array('id' => $this->session->userdata('user_id'), "user_type" => 0), '*', '', '', '', '', array());
            $this->data['logged_use'] = $user[0];
        }

        // load the header depends on the session
        if (!$this->session->userdata('user_id'))
            $this->data['afterheader'] = $this->load->view('header', $this->data, TRUE);
        else
            $this->data['afterheader'] = $this->load->view('afterheader', $this->data, TRUE);

        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
    }

    // index function call the first to view the dashboard main page

    public function index() {

        // if any existing business session login then first logout and then check the user session is autorize or not
        // depends on the session load the view 
        $this->session->unset_userdata('business_user_id');
        if (!$this->session->userdata('user_id')) {
            redirect('Home', 'refresh');
        } else {
            $this->load->view('dashboard/index', $this->data);
        }
    }

    
    //check the unique username
    public function checkuniqueusername() {
        $name = $this->input->post("name");
        if ($name != "") {
            $card = $this->common->select_data_by_condition('user', array('slug' => $name), '*', '', '', '', '', array());
            if (!empty($card)) {
                $json['status'] = "error";
            } else {
                $json['status'] = 'success';
            }
        } else {
            $json['status'] = "error";
        }
        echo json_encode($json);
        die();
    }

    // uniq username for edit
    public function checkuniqueusernameedit() {
        $name = $this->input->post("name");
        $id = $this->input->post("id");
        if ($name != "") {
            $card = $this->common->select_data_by_condition('user', array('slug' => $name, 'id!=' => $id), '*', '', '', '', '', array());
            if (!empty($card)) {
                echo 'false';
                die();
            } else {
                echo 'true';
                die();
            }
        } else {
            echo 'false';
            die();
        }
    }

    // logout the session of the logged in user
    public function logout() {
        setcookie('<pname4>-token', null, -1, "/");
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('card_session_id');
        $this->session->unset_userdata('save_card_session_id');
        $this->session->sess_destroy();
        redirect('Home', 'refresh');
    }
     
    // make the uniuque slug for the user

    public function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

}
