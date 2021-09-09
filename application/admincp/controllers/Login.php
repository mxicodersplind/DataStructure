<?php

ob_start();
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Login.php file contains functions for authenticate admin for login
 */

class Login extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        if ($this->session->userdata('seed_admin')) {
            redirect('Dashboard', 'refresh');
        }
        //after logout not to open page on back in browser so clear cache
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        //get site related setting details
        $app_name = $this->common->selectRecordById('settings', '1', 'setting_id');
        $this->data['app_name'] = $app_name['setting_value'];
        $this->data['title'] = 'Login : ' . $this->data['app_name'];
    }

    //show the login page
    public function index() {
        $this->load->view('login/index', $this->data);
    }

    //authenticate admin
    public function authenticate() {
        $this->form_validation->set_rules('username', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Please follow validation rules!');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        } else {
            $userName = $this->input->post('username');
            $password = sha1($this->input->post('password'));
            $remember = $this->input->post('remember');
            $checkAuth = $this->common->selectRecordById('admin', $userName, 'email');
            if (!empty($checkAuth)) {
                $dbPassword = $checkAuth['password'];
                $dbusername = $checkAuth['email'];
                if ($userName == $dbusername && $password === $dbPassword) {

                    if ($remember != '' && $remember == 1) {
                        $cookie = array(
                            'name' => 'remember_user_id',
                            'value' => $checkAuth['admin_id'],
                            'expire' => '86500',
                        );
                        $this->input->set_cookie($cookie);
                    }
                    $this->session->set_userdata('seed_admin', $checkAuth['admin_id']);


                    //$this->session->set_flashdata('add_class', true);
                    if ($checkAuth['role'] == 1) {
                        redirect('Dashboard', 'refresh');
                    } else {
                        redirect('UploadedCards', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Email or Password you entered is incorrect OR the account does not exist!');
                    redirect('Login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('error', 'Email or Password you entered is incorrect OR the account does not exist!');
                redirect('Login', 'refresh');
            }
        }
    }

}

/* 
 * End of file Login.php
 * Location: ./application/admincp/controllers/Login.php 
 */
    
