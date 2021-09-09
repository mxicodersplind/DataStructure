<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Forgotpassword
 * contains functions related to login and forgot password and OTP verification
 * @author Mxicoders
 */
class Forgotpassword extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->data['title'] = $this->data['site_name'] . ': Reset Password';


        //redirect to dashboard if already login
        if ($this->session->userdata('user_id')) {
            redirect('Dashboard', 'refresh');
        }

        $this->data['header'] = $this->load->view('header', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
    }

    //show login page, contains popup for OTP

    public function index() {

        // get the email from user input
        $forgotEmail = $this->input->post('forgot_email');

        // check the email is exist or not
        $checkAuth = $this->common->select_data_by_id('user', 'email', $forgotEmail, '*', array());
        $checkAuth = $checkAuth[0];
        if (!empty($checkAuth)) {
            // generate new token update in the database and send the email to user
            $reset_token = time() . rand(100, 999);
            $update_data = array("reset_token" => $reset_token);
            $this->common->update_data($update_data, 'user', 'email', $forgotEmail);
            $email = $forgotEmail;
            $name = $checkAuth['name'];

            // generate the new link
            $reset_link = '<a href="' . site_url('Forgotpassword/reset_password/' . $reset_token) . '" class="btn-primary" itemprop="url" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Reset Password</a>';

            // set the email body
            $site_logo = base_url() . 'userdash/assets/images/logo1.png';
            $year = date('Y');
            $mailData = $this->common->select_data_by_id('email_format', 'id', '10', '*', array());
            $subject = str_replace('%site_name%', $this->data['site_name'], $mailData[0]['subject']);
            $mailformat = $mailData[0]['emailformat'];
            $this->data['mail_body'] = str_replace("%site_logo%", $site_logo, str_replace("%name%", $name, str_replace("%email%", $email, str_replace("%reset_link%", $reset_link, str_replace("%site_name%", $this->data['site_name'], str_replace("%year%", $year, stripslashes($mailformat)))))));
            $this->data['mail_header'] = $this->data['site_name'];
            $this->data['mail_footer'] = '<a href="' . site_url() . '">' . $this->data["site_name"] . '</a> | Copyright &copy;' . $year . ' | All rights reserved</p>';
            $mail_body = $this->load->view('mail', $this->data, true);

            // send the email 
            $this->sendEmail($this->data['site_name'], $this->data['site_email'], $forgotEmail, $subject, $mail_body);

            $this->session->set_flashdata('success', 'Password reset link is sent to your email address');
            redirect('Login', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Oops, it is not a registered email address!');
            redirect('Login', 'refresh');
        }
    }

    // reset password function is used to update new password

    public function reset_password($reset_token = '') {
        $this->data['reset_token'] = $reset_token = $this->uri->segment(3);
        $contition_array = array('reset_token' => $reset_token);
        $this->data['user_detail'] = $user_detail = $this->common->select_data_by_condition('user', $contition_array, $data = '*', '', '', '', '', array());

        // get the new and confirm password and compare with the reset token
        if (!$user_detail) {
            $this->session->set_flashdata('error', 'You are not allowed to reset password.');
            redirect('Login', 'refresh');
            die();
        }

        // method check for the secutiry 
        if ($this->input->method() == 'post') {

            // get all the input data
            $newpassword = $this->input->post('password');
            $confirmpass = $this->input->post('cnfpassword');
            if ($newpassword != $confirmpass) {
                $this->session->set_flashdata('error', 'New password and Confirm password must be same.');
                header("Refresh:0");
                die();
            }

            // conver the password with the sha1 algoritham and store into the datbase
            $updatedPassword = sha1($newpassword);
            if ($this->common->update_data(array('password' => $updatedPassword, 'modified_datetime' => date('Y-m-d H:i:s')), 'user', 'reset_token', $reset_token)) {
                $this->common->update_data(array('reset_token' => '', 'modified_datetime' => date('Y-m-d H:i:s')), 'user', 'email', $user_detail[0]['email']);
                $this->session->set_flashdata('success', 'New password set successfully.');
                redirect('Login', 'refresh');
                die();
            } else {
                $this->session->set_flashdata('error', 'Error Occurred. Try Again!');
                header("Refresh:0");
                die();
            }
        }

        $this->load->view('login/changepassword', $this->data);
    }

    // this function is check the email given by client is already exist or not 
    public function emailExits() {
        $email = $this->input->post('email');
        if (trim($email) != '') {
            $res = $this->common->select_data_by_id('users', 'email', $email, 'email', array());
            if (empty($res)) {
                echo 'false';
                die();
            } else {
                echo 'true';
                die();
            }
        }
    }

    // the send email functio used for the send email to the user
}
