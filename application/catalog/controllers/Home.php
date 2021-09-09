<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();

        // set the title 
        $this->data['title'] = $this->data['site_name'] . ': Home';
        // check the session of the user
        if ($this->session->userdata('user_id')) {
            $user = $this->common->select_data_by_condition('user', array('id' => $this->session->userdata('user_id'), "user_type" => 0), '*', '', '', '', '', array());
            $this->data['logged_use'] = $user[0];
        }
        // load the home page dynamic section data
        $this->data['sectiondata'] = $this->common->select_data_by_condition('homepagesection', array('status' => 'Enable'), '*', 'seq', 'ASC', '', '', array());

        // load the header and footer
        $this->data['header'] = $this->load->view('header', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
    }

    
    // get the records from the blog
    function getRecords() {
        // Load database
        $db2 = $this->load->database('databaseblog', TRUE);
        $db2->select('`ID`,`post_title`,`post_excerpt`,`post_content`,`guid`');
        $db2->from('blog.wp_posts');
        $db2->where(array("post_status" => "publish"));
        $db2->order_by('ID', 'DESC');
        $db2->limit(5);
        $query = $db2->get();
        $result1 = $query->result_array();

        if (!empty($result1)) {
            foreach ($result1 as $i => $val) {
                $id = $val['ID'];
                $db2->select('wp_postmeta.meta_value');
                $db2->from('blog.wp_posts');
                $db2->join("wp_postmeta", 'wp_postmeta.post_id=wp_posts.ID', "LEFT");
                $db2->where(array("wp_posts.post_parent" => ".$id.", "wp_postmeta.meta_key" => "_wp_attached_file"));
                $query2 = $db2->get();
                $resultmeta = $query2->result_array();

                if (!empty($resultmeta)) {
                    $result1[$i]['imagess'] = "https://www.<pname>.com/blog/wp-content/uploads/" . $resultmeta[0]['meta_value'];
                } else {
                    $result1[$i]['imagess'] = "";
                }
            }
        }

        return $result1;
    }

    // load the business view
    public function business() {
        setcookie('dropurcard-token', null, -1, "/");
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy();
        redirect(base_url() . "business/Register", 'refresh');
    }

    
    //view landing page of site
    public function index() {
        $this->data['blogdata'] = $this->getRecords();
        $this->data['home'] = $this->common->select_data_by_condition('pages', array(), '*', 'page_id', 'ASC', '', '', array());
        $this->data['testimonials'] = $this->common->select_data_by_condition('testimonial', array(), '*', 'id', 'DESC', '', '', array());
        $this->load->view('home/index', $this->data);
    }

}
