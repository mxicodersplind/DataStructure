<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Cookie
 *
 * @author Mxicoders
 */
//This class is used for the registration 
class Register extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->data['title'] = $this->data['site_name'] . ': Signup';

        if ($this->session->userdata('user_id')) {
            redirect('Dashboard', 'refresh');
        }

        $this->data['header'] = $this->load->view('header', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
    }

    // view the registration page
    public function index() {
        $this->load->view('register/index', $this->data);
    }

    // this function is used to resend the otp when the user can not get the otp on the first time
    public function resendotp() {
        $email = $this->input->post('userid');
        if ($email != '') {
            // check the user is available in our site or not
            $res = $this->common->check_unique_avalibility('user', 'id', base64_decode($email), '', '', array());

            if (!empty($res)) {
                // generate the 6 digit of OTP
                $six_digit_random_number = random_int(100000, 999999);
                $update_data = array(
                    "otp" => $six_digit_random_number,
                );

                // send email again to user email id
                $card = $this->common->update_data($update_data, 'user', 'id', base64_decode($email));
                $emails = $res[0]->email;
                $subject = "OTP (One Time Password) : <projectname>";
                $activation_link = $six_digit_random_number;
                $this->data['mail_body'] = $six_digit_random_number . " is your One Time Password (OTP) for Registration Verification in <projectname>. ";
                $this->data['mail_header'] = $this->data['app_name'];
                $this->data['mail_footer'] = '<a href="' . site_url() . '">' . $this->data['app_name'] . '</a> | Copyright &copy;' . date('Y') . ' | All rights reserved</p>';
                $mail_body = $this->load->view('mail', $this->data, true);
                $this->sendEmail($this->data['app_name'], $this->data['app_email'], $emails, $subject, $mail_body);

                echo json_encode(array("status" => "success"));
                die();
            } else {
                echo json_encode(array("status" => "error"));
                die();
            }
        } else {
            echo json_encode(array("status" => "error"));
            die();
        }
    }

    // submit the otp from the user then we need to check here and verify the otp to register successfully
    public function submitotp() {
        if ($this->input->method() == 'post') {
            // check the validation of the data
            $this->form_validation->set_rules('userid', '', 'required');
            $this->form_validation->set_rules('otp', 'OTP', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors('<p>', '</p>'));
                redirect('Login', 'refresh');
            } else {

                //check and update the data of the particular user and complete the registration
                $if_exist = $this->common->select_data_by_condition('user', array('otp' => $this->input->post('otp')), '*', '', '', '', '', array());
                if (!empty($if_exist)) {
                    $update_data = array(
                        "status" => 'Enable',
                        "otp" => '',
                    );
                    $card = $this->common->update_data($update_data, 'user', 'id', base64_decode($this->input->post('userid')));
                    $this->session->set_flashdata('success', 'Registration Successfully.Please Login.');
                    redirect('Login', 'refresh');
                    die();
                } else {
                    $userdata = $this->common->select_data_by_condition('user', array('id' => base64_decode($this->input->post('userid'))), '*', '', '', '', '', array());
                    if (!empty($userdata)) {
                        $this->data['userid'] = $userdata[0]['id'];
                        $this->data['email'] = $userdata[0]['email'];
                        $this->session->set_flashdata('error', 'OTP is not Match Please try again later.');
                        $this->load->view('login/otp', $this->data);
                    } else {
                        $this->session->set_flashdata('error', 'Error Occured.');
                        redirect('Login', 'refresh');
                    }
                }
            }
        }
    }

    public function user_register() {
        if ($this->input->method() == 'post') {
            // check the all validation on server side
            $this->form_validation->set_rules('fullname', 'Full Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('cnfpassword', 'Confirm Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors('<p>', '</p>'));
                redirect('Login', 'refresh');
            } else {
                // check the user email if exist then no need to register again
                $if_exist = $this->common->select_data_by_condition('user', array('email' => $this->input->post('email'), 'is_deleted' => '0'), '*', '', '', '', '', array());
                if ($if_exist) {
                    $this->session->set_flashdata('error', 'Email Already Exists');
                    redirect('Login', 'refresh');
                    die();
                }

                // generate the google code , password and six digit OTP witht the different methods
                require_once(BASEPATH . 'Authenticator/rfc6238.php');
                $authenticatore_secrete = TokenAuth6238::generateRandomClue(16);

                $investorData['google_code'] = $authenticatore_secrete;
                $password = $this->input->post('password');
                $password_reset_token = time() . rand(100, 20000);
                $six_digit_random_number = random_int(100000, 999999);
                $custData = array(
                    "name" => ucfirst($this->security->xss_clean($this->input->post('fullname'))),
                    "email" => $this->security->xss_clean($this->input->post('email')),
                    "password" => sha1($password),
                    "created_datetime" => date('Y-m-d H:i:s'),
                    "modified_datetime" => date('Y-m-d H:i:s'),
                    "created_ip" => $this->input->ip_address(),
                    "modified_ip" => $this->input->ip_address(),
                    "status" => 'Disable',
                    "email_verify" => '1',
                    "reset_token" => $password_reset_token,
                    "otp" => $six_digit_random_number,
                );
                // insert the data to database
                $user_id = $this->common->insert_data_getid($custData, "user");

                if ($user_id > 0) {
                    // get the user details and sent the 6 digit OTP to user email
                    $name = ucwords($this->input->post('fullname'));
                    $email = $this->security->xss_clean($this->input->post('email'));

                    $site_logo = base_url() . '/assets/images/logo.jpg';
                    $url = base_url();

                    $year = date('Y');
                    // get the email format from the database
                    $mailData = $this->common->select_data_by_id('email_format', 'id', 3, '*', array());
                    $subject = str_replace('%site_name%', $this->data['app_name'], $mailData[0]['subject']);
                    $mailformat = $mailData[0]['emailformat'];
                    $activation_link = $six_digit_random_number . " is your One Time Password (OTP) for Registration Verification in <projectname>. ";
                    $this->data['mail_body'] = str_replace("%site_logo%", $site_logo, str_replace("%name%", $name, str_replace("%activation_link%", $activation_link, str_replace("%password%", $password, str_replace("%email%", $email, str_replace("%url%", $url, str_replace("%site_name%", $this->data['app_name'], str_replace("%year%", $year, stripslashes($mailformat)))))))));
                    $this->data['mail_header'] = $this->data['app_name'];
                    $this->data['mail_footer'] = '<a href="' . site_url() . '">' . $this->data['app_name'] . '</a> | Copyright &copy;' . $year . ' | All rights reserved</p>';
                    $mail_body = $this->load->view('mail', $this->data, true);
                    $this->sendEmail($this->data['app_name'], $this->data['app_email'], $email, $subject, $mail_body);
                    $this->session->set_flashdata('success', 'You are registered successfully. Please check your registered email address. we have send you OTP (One Time Password) in your registered email, check your inbox or spam folder.');
                    $this->data['userid'] = $user_id;
                    $this->data['email'] = $email;
                    $this->load->view("login/otp", $this->data);
                } else {
                    $this->session->set_flashdata('error', 'There is an error occured. please try after again');
                    redirect('Login', 'refresh');
                }
            }
        }
    }

    // the random password generater function
    function password_generate($chars) {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }

    // this function is used to check the email is exist or not
    public function emailExits() {
        $email = $this->input->post('email');
        if (trim($email) != '') {
            $res = $this->common->check_unique_avalibility('user', 'email_id', $email, '', '', array());
            if (empty($res)) {
                echo 'true';
                die();
            } else {
                echo 'false';
                die();
            }
        } else {
            echo 'true';
            die();
        }
    }


    // verify email function is used to verify the email of the user
    public function verifyemail($id = '') {
        if ($id == '') {
            redirect(site_url('Login'), 'refresh');
        }


        // check the token is correct or not
        $active_email = $this->common->select_data_by_id('user', 'reset_token', $id, '*', array());
        if (empty($active_email)) {
            $this->session->set_flashdata('error', 'Something went wrong.');
            redirect(site_url('Login'), 'refresh');
        }

        // if all data is correct then active the user and verified the user
        // update the data in the database
        $this->common->update_data(array('email_verify' => '1', 'status' => 'Enable', 'reset_token' => time() . rand(100, 999)), 'user', 'id', $active_email[0]['id']);
        $this->session->set_flashdata('success', 'Your account is successfully activated. Thank you!');
        redirect('Login', 'refresh');
    }

}
