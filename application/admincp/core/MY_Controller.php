<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// this function is the common used function
class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();

        // check the session of admin
        if (!$this->session->userdata('seed_admin')) {
            redirect('Login', 'refresh');
        }

        //Admin details
        $this->data['adminID'] = $this->session->userdata('seed_admin');
        $adminDetails = $this->common->selectRecordById('admin', $this->data['adminID'], 'admin_id');
        $this->data['username'] = $adminDetails['username'];
        $this->data['name'] = ucwords($adminDetails['firstname'] . ' ' . $adminDetails['lastname']);
        $this->data['email'] = $adminDetails['email'];
        $this->data['adminprofileimage'] = $adminDetails['image'];
        $this->data['admindetail'] = $adminDetails;
        $this->data['admin_role'] = $adminDetails['role'];




        //get site related setting details
        $app_name = $this->common->selectRecordById('settings', '1', 'setting_id');
        $this->data['app_name'] = $app_name['setting_value'];
        $app_name = $this->common->selectRecordById('settings', '2', 'setting_id');
        $this->data['app_email'] = $app_name['setting_value'];
        $smtp_email = $this->common->selectRecordById('settings', '12', 'setting_id');
        $this->data['smtp_email'] = $smtp_email['setting_value'];
        $smtp_pass = $this->common->selectRecordById('settings', '13', 'setting_id');
        $this->data['smtp_pass'] = $smtp_pass['setting_value'];
    }

    //this function is used for the data display on particular format
    function pr($content) {
        echo "<pre>";
        print_r($content);
        echo "</pre>";
    }

    // this function is used for datetime
    function datetime() {
        return date('Y-m-d H:i:s');
    }

    // get the last query from database
    function last_query() {
        echo "<pre>";
        echo $this->db->last_query();
        echo "</pre>";
    }

    // this function is used for the verification of google authenticator
    public function verify_google_auth($code) {
        require_once(BASEPATH . 'Authenticator/rfc6238.php');

        $checkAuth = $this->common->select_data_by_condition('user', array('user_id' => $this->session->userdata('user_id')), '*', '', '', '', '', array());

        if (TokenAuth6238::verify($checkAuth[0]['google_code'], $code)) {
            return true;
        } else {
            return false;
        }
    }

    // used for the send email
    function sendEmail($app_name, $app_email, $to_email, $subject, $mail_body) {
        $this->load->library('email');
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => $this->data['smtp_email'], // change it to yours
            'smtp_pass' => $this->data['smtp_pass'], // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($app_email, $app_name);
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message($mail_body);

        if (!$this->email->send()) {
            return false;
        } else {
            return true;
        }
    }

    // getting the client IP
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    // getting the full date Format
    public function displayFullDateFormat($field) {
        $dateformat = "d/m/Y";
        if (!empty($dateformat)) {
            $dateformat = $dateformat;
            $dateformat = str_replace("Y", "%Y", $dateformat);
            $dateformat = str_replace("m", "%m", $dateformat);
            $dateformat = str_replace("d", "%d", $dateformat);
            $dateformat = str_replace("M", "%b", $dateformat);
            $dateformat = str_replace("F", "%M", $dateformat);
            $dateformat = str_replace("l", "%W", $dateformat);
            $dateformat = str_replace("D", "%a", $dateformat);

            $timeformat = 'H:i';
            if (!empty($timeformat)) {

                if ($timeformat == 'h:i:s a') {
                    $timeformat = str_replace("h", "%h", $timeformat);
                    $timeformat = str_replace("i", "%i", $timeformat);
                    $timeformat = str_replace("s", "%s", $timeformat);
                    $timeformat = str_replace("a", "%p", $timeformat);
                }if ($timeformat == 'h:i:s A') {
                    $timeformat = "%r";
                } else {
                    $timeformat = str_replace("H", "%H", $timeformat);
                    $timeformat = str_replace("i", "%i", $timeformat);
                    $timeformat = str_replace("s", "%s", $timeformat);
                }
            }
            $dbformat = $dateformat . ' ' . $timeformat;
            return 'DATE_FORMAT(' . $field . ',"' . $dbformat . '")';
        }
    }

    // get the last url
    function last_url() {
        return filter_input(INPUT_SERVER, 'HTTP_REFERER', FILTER_SANITIZE_STRING);
    }

    // getting the OS Information
    public function getOS() {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;

        return $os_platform;
    }

    // getting the Browser Information
    public function getBrowser() {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $browser = $value;

        return $browser;
    }

}
