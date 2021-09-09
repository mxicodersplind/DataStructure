<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


// home page and other pages management add,update
class Pages extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');


        $this->data['title'] = 'Pages : ' . $this->data['app_name'];
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

    // load main page of pages
    public function index() {
        $this->load->view('pages/index', $this->data);
    }

    // fetch and get the details
    public function gettabledata() {
        $request = $this->input->get();
        
        $join_str = array();
        $condition = array('pages.status' => 'Enable');
        $columns = array('pages.page_id', 'pages.pagetitle', 'pages.description', 'pages.status');
        $getfiled = "pages.page_id, pages.pagetitle, pages.description, pages.status";
        echo $this->common->getDataTableSource('pages', $columns, $condition, $getfiled, $request, $join_str, '');
        die();
    }

    // load the add view
    public function add() {
        $this->load->view('pages/add', $this->data);
    }

    
    // check the validation on server side and insert the new page data
    public function addnew() {
        $this->form_validation->set_rules('page_title', 'Page Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="error">', '</div>'));
            redirect('Pages', 'refresh');
        } 
        else {
            $page_title = $this->input->post('page_title');
            $description = (($this->input->post('description')));

            $insert_data = array(
                'pagetitle' => $page_title,
                'description' => $description,
                "created_at" => date('Y-m-d H:i:s'),
                "created_ip" => $this->input->ip_address(),
                "modified_at" => date('Y-m-d H:i:s'),
                "modified_ip" => $this->input->ip_address(),
            );
            $user = $this->common->insert_data_getid($insert_data, "pages");

            if ($user) {
                $this->session->set_flashdata('success', 'Page added successfully.');
                redirect('Pages', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'There is an error occured. please try after again');
                redirect('Pages', 'refresh');
            }
        }
    }

    // get the info and load the edit view mode
    public function edit($id) {
        $sub_id = base64_decode($id);
        $this->data['info'] = $this->common->select_data_by_condition('pages', array('pages.page_id' => $sub_id), '*', '', '', '', '', array());
        if (empty($this->data['info'])) {
            $this->session->set_flashdata('error', 'No information found!');
            redirect('Pages', 'refresh');
        } else {
            $this->load->view('pages/edit', $this->data);
        }
    }

    
    // update the page data 
    public function editnew($id) {
        $sub_id = base64_decode($id);
        $this->form_validation->set_rules('page_title', 'Page Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="error">', '</div>'));
            redirect('Pages/edit' . $id, 'refresh');
        } 
        else {
            $page_title = $this->input->post('page_title');
            $description = (($this->input->post('description')));

            $update_data = array(
                'pagetitle' => $page_title,
                'description' => $description,
                "modified_at" => date('Y-m-d H:i:s'),
                "modified_ip" => $this->input->ip_address(),
            );
            $user = $this->common->update_data($update_data, 'pages', 'pages.page_id', $sub_id);

            if ($user) {
                $this->session->set_flashdata('success', 'Page updated successfully.');
                redirect('Pages', 'refresh');
            } else {
                $this->session->set_flashdata('error', 'There is an error occured. please try after again');
                redirect('Pages', 'refresh');
            }
        }
    }

}
