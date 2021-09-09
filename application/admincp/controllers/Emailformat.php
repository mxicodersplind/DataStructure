<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// this function is used for the emailformate management add, update
class Emailformat extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        $this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
        $this->data['title'] = 'Email Templates : ' . $this->data['app_name'];

        //Load header and save in variable
        $this->data['header'] = $this->load->view('header', $this->data, true);
        $this->data['sidebar'] = $this->load->view('sidebar', $this->data, true);
        $this->data['footer'] = $this->load->view('footer', $this->data, true);
    }

    // load the view file
    public function index() {
       
        $this->load->view('emailformat/index', $this->data);
    }

    // get the all email formate data
    function getdata() {

        $columns = array('title', 'subject');
        $request = $this->input->get();

        $condition = array('type' => $request['type1']);
        $join_str = array();


        $getfiled = "id,title,subject";
        $this->db->order_by("email_format.id", "desc");
        echo $this->common->getDataTableSource('email_format', $columns, $condition, $getfiled, $request, $join_str, '');

        die();
    }

    // fetch the information and load the edit view mode
    public function edit($id) {

        $id = base64_decode($id);

        $email_format = $this->common->select_data_by_condition('email_format', array('id' => $id), '*', '', '', '', '', array());

        if (empty($email_format)) {
            $this->session->set_flashdata('error', 'No information found!');
            redirect('Emailformat/index');
        }
        $this->data['editinfo'] = $email_format[0];
        $this->data['formattype'] = $email_format[0]['type'];

        $this->load->view('emailformat/edit', $this->data);
    }

    
    // update the email format
    function update() {


        $redirect = '';
        $last_url = $this->input->post('last_url_params');
        if ($last_url != '') {
            $redirect = $last_url;
        } else {
            $redirect = 'Emailformat/index';
        }

        $id = base64_decode($this->input->post('id'));
        $tabledata = $this->common->select_data_by_condition('email_format', array('id' => $id), '*', '', '', '', '', array());
        if (empty($tabledata)) {
            $this->session->set_flashdata('error', 'No information found!');
            redirect('Emailformat/index', 'refresh');
        }


        $this->form_validation->set_rules('esubject', 'Subject', 'required');
        $this->form_validation->set_rules('eemailformat', 'Email Format', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<p>', '<p>'));
            redirect($redirect, 'refresh');
        }


        $subject = $this->input->post('esubject');
        $emailformat = $this->input->post('eemailformat');


        $data = array(
            'subject' => $subject,
            'emailformat' => $emailformat,
        );

        if ($this->common->update_data($data, 'email_format', 'id', $id)) {

            $this->session->set_flashdata('success', 'Email format has been updated successfully');
            redirect($redirect, 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Sorry! Something went wrong please try later!');
            redirect($redirect, 'refresh');
        }
    }

}
