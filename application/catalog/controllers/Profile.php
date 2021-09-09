<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Cookie
 *
 * @author Mxicoders
 */
// This function is used for the profile update of the user
class Profile extends MY_Controller {

    public function __construct() {
        parent::__construct();


        $this->data['title'] = $this->data['site_name'] . ': Profile';

        //redirect to dashboard if already login
        if (!$this->session->userdata('user_id')) {
            redirect('Login', 'refresh');
        }
        if ($this->session->userdata('user_id')) {
            $user = $this->common->select_data_by_condition('user', array('id' => $this->session->userdata('user_id'), "user_type" => 0), '*', '', '', '', '', array());
            $this->data['logged_use'] = $user[0];
        }

        $this->data['afterheader'] = $this->load->view('afterheader', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
    }

    // load the user profile view
    public function index() {
        $this->load->view('profile/index', $this->data);
    }

    
    // update the user profile data
    public function updateuserdata() {
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('fullname', 'Full Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="error">', '</div>'));
            redirect('Profile', 'refresh');
        } else {
            $info = $this->common->select_data_by_condition('user', array('id' => $user_id), '*', '', '', '', '', array());
            $dataimage = $info[0]['image'];
         
            // create the thumb and upload a new image
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != null && $_FILES['image']['size'] > 0) {

                $config['upload_path'] = $this->config->item('upload_path_user_rm');
                $config['allowed_types'] = $this->config->item('upload_user_allowed_types');
                $config['file_name'] = rand(10, 99) . time();
                $this->load->library('upload');
                $this->upload->initialize($config);
                $this->upload->do_upload('image');
                //Getting Uploaded Image File Data
                $imgdata = $this->upload->data();
                $imgerror = $this->upload->display_errors();

                if ($imgerror == '') {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                    $config['new_image'] = $this->config->item('upload_path_user_thumb_rm') . $imgdata['file_name'];
                    $dataimage = $imgdata['file_name'];
                    $filename = $_FILES['image']['tmp_name'];

                    $config['maintain_ratio'] = FALSE;
                    $imgedata = exif_read_data($this->upload->upload_path . $this->upload->file_name, 'IFD0');
                    list($width, $height) = getimagesize($filename);
                    $config['width'] = $this->config->item('user_thumb_width');
                    $config['height'] = $this->config->item('user_thumb_height');

                    $this->load->library('image_lib', $config);

                    if ($this->image_lib->resize()) {
                        $this->image_lib->clear();
                        $config = array();
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $this->config->item('upload_path_user_thumb_rm') . $imgdata['file_name'];

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
                        
                        // remove the old image from the server
                        if ($info[0]['image'] != '') {
                            if (file_exists($this->config->item('upload_path_user_rm') . $info[0]['image'])) {
                                @unlink($this->config->item('upload_path_user_rm') . $info[0]['image']);
                            }
                            if (file_exists($this->config->item('upload_path_user_thumb_rm') . $info[0]['image'])) {
                                @unlink($this->config->item('upload_path_user_thumb_rm') . $info[0]['image']);
                            }
                        }
                    }
                } else {
                    $thumberror = '';
                    $dataimage = '';
                }
            }
            
            // update data into the database
            $update_data = array(
                "name" => ucwords($this->input->post('fullname')),
                "image" => $dataimage,
                "modified_datetime" => date('Y-m-d H:i:s')
            );
            $user = $this->common->update_data($update_data, 'user', 'id', $user_id);
            if ($user) {
                $this->session->set_flashdata('success', 'User info updated successfully.');
                redirect('Profile', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Sorry! something went wrong Please try later!');
                redirect('Profile', 'refresh');
            }
        }
    }

    
    // change password and update password for the user
    public function updatepassword() {
        $json = array();
        $json['status'] = 'fail';
        $json['msg'] = '';
        $user_id = $this->session->userdata('user_id');
        $password = $this->input->post('password');
        $cnfpassword = $this->input->post('cnfpassword');

        
        // check the validations and conditions
        if (empty($password)) {
            $json['status'] = 'error';
            $json['msg'] = 'Password is required.';
        } else if (empty($cnfpassword)) {
            $json['status'] = 'error';
            $json['msg'] = 'Confirm Password is required.';
        } else if ($password != $cnfpassword) {
            $json['status'] = 'error';
            $json['msg'] = 'Do not match Password.';
        } else {
            
            // update password to database
            $update_data = array(
                "password" => sha1($password),
                "modified_datetime" => date('Y-m-d H:i:s')
            );
            $user = $this->common->update_data($update_data, 'user', 'id', $user_id);
            if ($user) {
                $json['status'] = 'success';
                $json['msg'] = 'Password updated successfully.';
            } else {
                $json['status'] = 'error';
                $json['msg'] = 'There is an error occured. please try after again.';
            }
        }


        echo json_encode($json);
        die();
    }

}
