<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// all the user related information and also admin can add edit update disable and manage the user data from here
class User extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        // load the header file
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        $this->data['title'] = 'User : ' . $this->data['app_name'];

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

    // load the main page of the user list
    public function index() {
        $this->load->view('user/index', $this->data);
    }

    // get and fetch the data of the userlist
    public function gettabledata() {
        $columns = array('user.id', 'user.name', 'user.email', 'user.contact_no', 'user.status', 'user.status', 'user.status', 'user.status', 'user.status', 'user.status');
        $request = $this->input->get();
        $condition = array('user.is_deleted' => '0');
        if ($request["usertype"] == 0) {
            $condition["user_type"] = 0;
        } else {
            $condition["user_type"] = 1;
        }
        $join_str = array();
        $getfiled = "user.id,user.name,user.email,user.contact_no,user.status";
        $this->db->order_by("user.id", "desc");
        echo $this->common->getDataTableSourceUser('user', $columns, $condition, $getfiled, $request, $join_str, '');
        die();
    }

    // load the add user page
    public function add() {
        $this->load->view('user/add', $this->data);
    }

    
    // check the validation and add the new user data 
    public function addnew() {
        $this->form_validation->set_rules('name', 'User name', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|strip_tags|xss_clean');
        

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="error">', '</div>'));
            redirect('User', 'refresh');
        } else {
            $check_email = $this->common->select_data_by_condition('user', array('email' => $this->input->post('email'), 'is_deleted' => '0'), '*', '', '', '', '', array());
            if (!empty($check_email)) {
                $this->session->set_flashdata('error', 'Email already exists.');
                redirect('User', 'refresh');
            }
            $dataimage = '';
            
            // set the new image for the user
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != null && $_FILES['image']['size'] > 0) {

                $config['upload_path'] = $this->config->item('upload_path_user');
                $config['allowed_types'] = $this->config->item('upload_user_allowed_types');
                $config['file_name'] = rand(10, 99) . time();
                $this->load->library('upload');
                //$this->load->library('image_lib');
                // Initialize the new config
                $this->upload->initialize($config);
                //Uploading Image
                $this->upload->do_upload('image');
                //Getting Uploaded Image File Data
                $imgdata = $this->upload->data();
                $imgerror = $this->upload->display_errors();

                // print_r($imgerror);die();
                if ($imgerror == '') {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                    $config['new_image'] = $this->config->item('upload_path_user_thumb') . $imgdata['file_name'];
                    $dataimage = $imgdata['file_name'];
                    $filename = $_FILES['image']['tmp_name'];

                    $config['maintain_ratio'] = FALSE;
                    $imgedata = exif_read_data($this->upload->upload_path . $this->upload->file_name, 'IFD0');


                    list($width, $height) = getimagesize($filename);

                    $config['width'] = $this->config->item('user_thumb_width');

                    $config['height'] = $this->config->item('user_thumb_height');

                    //$config['master_dim'] = 'auto';


                    $this->load->library('image_lib', $config);

                    if ($this->image_lib->resize()) {

                        $this->image_lib->clear();
                        $config = array();

                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $this->config->item('upload_path_user_thumb') . $imgdata['file_name'];

                        switch ($imgedata['Orientation']) {
                            case 3:
                                $config['rotation_angle'] = '180';
                                break;
                            case 6:
                                $config['rotation_angle'] = '270';
                                break;
                            case 8:
                                $config['rotation_angle'] = '90';
                                break;
                        }

                        $this->image_lib->initialize($config);
                        $this->image_lib->rotate();
                    }
                } else {
                    $thumberror = '';
                    $dataimage = '';
                }
            }
            
            
            //generate the google code and password 
            require_once(BASEPATH . 'Authenticator/rfc6238.php');
            $authenticatore_secrete = TokenAuth6238::generateRandomClue(16);

            $investorData['google_code'] = $authenticatore_secrete;
            $password = $this->password_generate(8);
            $password_reset_token = time() . rand(100, 20000);
            $insert_data = array(
                "name" => $this->security->xss_clean(ucwords($this->input->post('name'))),
                "email" => $this->security->xss_clean($this->input->post('email')),
                "contact_no" => $this->security->xss_clean($this->input->post('contact_no')),
                "address2" => $this->security->xss_clean($this->input->post('address2')),
                "address1" => $this->security->xss_clean($this->input->post('address1')),
                "country_id" => $this->security->xss_clean($this->input->post('country_id')),
                "state_id" => $this->security->xss_clean($this->input->post('state_id')),
                "city" => $this->security->xss_clean($this->input->post('city')),
                "zipcode" => $this->security->xss_clean($this->input->post('zipcode')),
                "image" => $dataimage,
                "status" => 'Enable',
                "email_verify" => '1',
                "password" => sha1($password),
                "reset_token" => $password_reset_token,
                "created_datetime" => date('Y-m-d H:i:s'),
                "created_ip" => $this->input->ip_address(),
                "modified_ip" => $this->input->ip_address(),
                "modified_datetime" => date('Y-m-d H:i:s'),
                "created_browser" => $this->security->xss_clean($this->agent->browser()),
                "created_os" => $this->security->xss_clean($this->agent->platform()),
                "added_by" => $this->data['adminID'],
                "modified_browser" => $this->security->xss_clean($this->agent->browser()),
                "modified_os" => $this->security->xss_clean($this->agent->platform()),
                "modified_by" => $this->data['adminID'],
            );
            $user = $this->common->insert_data_getid($insert_data, "user");
            if ($user) {
                
                // send the email to the user
                $name = ucwords($this->input->post('name'));
                $email = $this->security->xss_clean($this->input->post('email'));

                $site_logo = base_url() . '/assets/images/logo.jpg';
                $url = $this->config->item('front_url');

                $year = date('Y');
                $mailData = $this->common->select_data_by_id('email_format', 'id', 3, '*', array());
                $subject = str_replace('%site_name%', $this->data['app_name'], $mailData[0]['subject']);
                $mailformat = $mailData[0]['emailformat'];
                //$activation_link = '<a href="' . site_url('../Login/verifyemail/' . $password_reset_token) . '" class="btn-primary" itemprop="url" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #348eda; margin: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Confirm email address</a>';
                $activation_link = '';
                $this->data['mail_body'] = str_replace("%site_logo%", $site_logo, str_replace("%name%", $name, str_replace("%activation_link%", $activation_link, str_replace("%password%", $password, str_replace("%email%", $email, str_replace("%url%", $url, str_replace("%site_name%", $this->data['app_name'], str_replace("%year%", $year, stripslashes($mailformat)))))))));
                
                $this->data['mail_header'] = $this->data['app_name'];
                $this->data['mail_footer'] = '<a href="' . site_url() . '">' . $this->data['app_name'] . '</a> | Copyright &copy;' . $year . ' | All rights reserved</p>';
                $mail_body = $this->load->view('mail', $this->data, true);
                
                $this->sendEmail($this->data['app_name'], $this->data['app_email'], $email, $subject, $mail_body);

                $this->session->set_flashdata('success', 'User added successfully.');
                redirect('User', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'There is an error occured. please try after again');
                redirect('User', 'refresh');
            }
        }
    }

    function password_generate($chars) {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }

    public function edit($id) {
        $sub_id = base64_decode($id);
        $this->data['info'] = $this->common->select_data_by_condition('user', array('user.id' => $sub_id), '*', '', '', '', '', array());
        if (empty($this->data['info'])) {
            $this->session->set_flashdata('error', 'No information found!');
            redirect('User', 'refresh');
        } else {
            $this->load->view('user/edit', $this->data);
        }
    }

    public function editnew($id) {
        $sub_id = base64_decode($id);

        $this->form_validation->set_rules('name', 'User name', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('contact_no', 'Contact no', 'required|trim|strip_tags|xss_clean');
       

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="error">', '</div>'));
            redirect('User/edit' . $id, 'refresh');
        } else {
            $info = $this->common->select_data_by_condition('user', array('user.id' => $sub_id), '*', '', '', '', '', array());
            $dataimage = $info[0]['image'];
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != null && $_FILES['image']['size'] > 0) {

                $config['upload_path'] = $this->config->item('upload_path_user');
                $config['allowed_types'] = $this->config->item('upload_user_allowed_types');
                $config['file_name'] = rand(10, 99) . time();
                $this->load->library('upload');
                //$this->load->library('image_lib');
                // Initialize the new config
                $this->upload->initialize($config);
                //Uploading Image
                $this->upload->do_upload('image');
                //Getting Uploaded Image File Data
                $imgdata = $this->upload->data();
                $imgerror = $this->upload->display_errors();

                // print_r($imgerror);die();
                if ($imgerror == '') {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                    $config['new_image'] = $this->config->item('upload_path_user_thumb') . $imgdata['file_name'];
                    $dataimage = $imgdata['file_name'];
                    $filename = $_FILES['image']['tmp_name'];

                    $config['maintain_ratio'] = FALSE;
                    $imgedata = exif_read_data($this->upload->upload_path . $this->upload->file_name, 'IFD0');


                    list($width, $height) = getimagesize($filename);

                    $config['width'] = $this->config->item('user_thumb_width');

                    $config['height'] = $this->config->item('user_thumb_height');

                    //$config['master_dim'] = 'auto';


                    $this->load->library('image_lib', $config);

                    if ($this->image_lib->resize()) {

                        $this->image_lib->clear();
                        $config = array();

                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $this->config->item('upload_path_user_thumb') . $imgdata['file_name'];

                        switch ($imgedata['Orientation']) {
                            case 3:
                                $config['rotation_angle'] = '180';
                                break;
                            case 6:
                                $config['rotation_angle'] = '270';
                                break;
                            case 8:
                                $config['rotation_angle'] = '90';
                                break;
                        }

                        $this->image_lib->initialize($config);
                        $this->image_lib->rotate();
                        if ($info[0]['image'] != '') {
                            if (file_exists($this->config->item('upload_path_user') . $info[0]['image'])) {
                                @unlink($this->config->item('upload_path_user') . $info[0]['image']);
                            }
                            if (file_exists($this->config->item('upload_path_user_thumb') . $info[0]['image'])) {
                                @unlink($this->config->item('upload_path_user_thumb') . $info[0]['image']);
                            }
                        }
                    }
                } else {
                    $thumberror = '';
                    $dataimage = '';
                }
            }
            $update_data = array(
                "name" => $this->security->xss_clean(ucwords($this->input->post('name'))),
                "email" => $this->security->xss_clean($this->input->post('email')),
                "contact_no" => $this->security->xss_clean($this->input->post('contact_no')),
                "address2" => $this->security->xss_clean($this->input->post('address2')),
                "address1" => $this->security->xss_clean($this->input->post('address1')),
                "country_id" => $this->security->xss_clean($this->input->post('country_id')),
                "state_id" => $this->security->xss_clean($this->input->post('state_id')),
                "city" => $this->security->xss_clean($this->input->post('city')),
                "zipcode" => $this->security->xss_clean($this->input->post('zipcode')),
                "image" => $dataimage,
                "modified_ip" => $this->input->ip_address(),
                "modified_datetime" => date('Y-m-d H:i:s'),
                "modified_browser" => $this->security->xss_clean($this->agent->browser()),
                "modified_os" => $this->security->xss_clean($this->agent->platform()),
                "modified_by" => $this->data['adminID'],
            );
            $user = $this->common->update_data($update_data, 'user', 'user.id', $sub_id);
            if ($user) {
                $this->session->set_flashdata('success', 'User updated successfully.');
                redirect('User', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'There is an error occured. please try after again');
                redirect('User', 'refresh');
            }
        }
    }

    function delete() {
        $json = array();
        $json['msg'] = '';
        $json['status'] = 'fail';
        $id = $this->input->post('id');

        $group = $this->common->select_data_by_condition('user', array('user.id' => $id), '*', '', '', '', '', array());
        if (!empty($group)) {
            $res = $this->common->update_data(array('is_deleted' => '1'), 'user', 'user.id', $id);
            if ($res) {
                $json['msg'] = 'Record has been deleted successfully';
                $json['status'] = 'success';
            } else {
                $json['msg'] = 'Sorry! something went wrong Please try later!';
            }
        } else {
            $json['msg'] = 'Sorry! No information found!';
        }
        echo json_encode($json);
        die();
    }

    function update_status() {
        $json = array();
        $json['status'] = 'fail';
        $json['msg'] = '';
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $reason = nl2br($this->input->post('reason'));
        if ($status == 'Enable') {
            $status = 'Disable';
        } else {
            $status = 'Enable';
        }

        $data = $this->common->select_data_by_condition('user', array('user.id' => $id), '*', '', '', '', '', array());
        if (empty($data)) {
            $json['msg'] = 'No information Found!';
        } else {
            $result = $this->common->update_data(array('status' => $status), 'user', 'user.id', $id);
            if ($result) {
                $name = ucfirst($data[0]['name']);
                $email = $data[0]['email'];
                $site_logo = base_url() . '/assets/images/logo.jpg';
                $year = date('Y');
                if ($status == 'Enable') {
                    $mailData = $this->common->select_data_by_id('email_format', 'id', 13, '*', array());
                    $subject = str_replace('%site_name%', $this->data['app_name'], $mailData[0]['subject']);
                    $mailformat = $mailData[0]['emailformat'];
                    $this->data['mail_body'] = str_replace("%site_logo%", $site_logo, str_replace("%name%", $name, str_replace("%reason%", $reason, str_replace("%site_name%", $this->data['app_name'], str_replace("%year%", $year, stripslashes($mailformat))))));
                    //$this->data['mail_header'] = '<img id="headerImage campaign-icon" src="' . $site_logo . '" title="' . $this->data["site_name"] . '" width="250" /> ';
                    $this->data['mail_header'] = $this->data['app_name'];
                    $this->data['mail_footer'] = '<a href="' . site_url() . '">' . $this->data['app_name'] . '</a> | Copyright &copy;' . $year . ' | All rights reserved</p>';
                    $mail_body = $this->load->view('mail', $this->data, true);
                    // echo '<pre>';                    print_r($mail_body); die;
                    $this->sendEmail($this->data['app_name'], $this->data['app_email'], $email, $subject, $mail_body);
                } else {
                    $mailData = $this->common->select_data_by_id('email_format', 'id', 16, '*', array());
                    $subject = str_replace('%site_name%', $this->data['app_name'], $mailData[0]['subject']);
                    $mailformat = $mailData[0]['emailformat'];
                    $this->data['mail_body'] = str_replace("%site_logo%", $site_logo, str_replace("%name%", $name, str_replace("%reason%", $reason, str_replace("%site_name%", $this->data['app_name'], str_replace("%year%", $year, stripslashes($mailformat))))));
                    //$this->data['mail_header'] = '<img id="headerImage campaign-icon" src="' . $site_logo . '" title="' . $this->data["site_name"] . '" width="250" /> ';
                    $this->data['mail_header'] = $this->data['app_name'];
                    $this->data['mail_footer'] = '<a href="' . site_url() . '">' . $this->data['app_name'] . '</a> | Copyright &copy;' . $year . ' | All rights reserved</p>';
                    $mail_body = $this->load->view('mail', $this->data, true);
                    //  echo '<pre>';                    print_r($mail_body); die;
                    $this->sendEmail($this->data['app_name'], $this->data['app_email'], $email, $subject, $mail_body);
                }
                $json['status'] = 'success';
                $json['msg'] = 'Status has been updated';
            } else {
                $json['msg'] = 'Sorry! Something went wrong please try again!';
            }
        }
        echo json_encode($json);
        die();
    }

    public function emailExits() {
        $email = $this->input->post('email');

        if (trim($email) != '') {
            $res = $this->common->check_unique_avalibility('user', 'email', $email, '', '', array('is_deleted' => '0'));

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

    public function emailExitsedit() {
        $email = $this->input->post('email');
        $id = $this->input->post('id');

        if (trim($email) != '') {
            $res = $this->common->check_unique_avalibility('user', 'email', $email, 'user.id', $id, array('is_deleted' => '0'));

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

    public function resendPass() {
        $json = array();
        $json['status'] = 'fail';
        $json['msg'] = '';
        $id = $this->input->post('id');
        $info = $this->common->select_data_by_condition('user', array('id' => $id), '*', '', '', '', '', array());
        if (empty($info)) {
            $json['msg'] = 'No information found!';
            echo json_encode($json);
            die();
        }
        $password = $this->input->post('newpass');

        $info1 = array(
            "password" => sha1($password),
            "modified_ip" => $this->input->ip_address(),
            "modified_datetime" => date('Y-m-d H:i:s'),
        );
        $res = $this->common->update_data($info1, 'user', 'id', $info[0]['id']);

        $name = ucfirst($info[0]['name']);
        $email = $info[0]['email'];

        $site_logo = base_url() . '/assets/images/logo.jpg';

        $year = date('Y');
        $mailData = $this->common->select_data_by_id('email_format', 'id', 5, '*', array());
        $subject = str_replace('%site_name%', $this->data['app_name'], $mailData[0]['subject']);
        $mailformat = $mailData[0]['emailformat'];
        $this->data['mail_body'] = str_replace("%site_logo%", $site_logo, str_replace("%name%", $name, str_replace("%password%", $password, str_replace("%email%", $email, str_replace("%site_name%", $this->data['app_name'], str_replace("%year%", $year, stripslashes($mailformat)))))));
        //$this->data['mail_header'] = '<img id="headerImage campaign-icon" src="' . $site_logo . '" title="' . $this->data["site_name"] . '" width="250" /> ';
        $this->data['mail_header'] = $this->data['app_name'];
        $this->data['mail_footer'] = '<a href="' . site_url() . '">' . $this->data['app_name'] . '</a> | Copyright &copy;' . $year . ' | All rights reserved</p>';
        $mail_body = $this->load->view('mail', $this->data, true);
        //  echo '<pre>';                    print_r($mail_body); die;
        $this->sendEmail($this->data['app_name'], $this->data['app_email'], $email, $subject, $mail_body);

        if ($res) {
            $json['status'] = 'success';
            $json['msg'] = 'Password has been resent successfully.';
        } else {
            $json['msg'] = 'Sorry! something went wrong please try later!';
        }
        echo json_encode($json);
        die();
    }

}
