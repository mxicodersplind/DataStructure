<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('send_sms_otp')) {

    function send_sms_otp($mobile_number, $otp_number, $otp_type, $otp_for, $otp_for_id, $otp_status) {
        $CI = & get_instance();
        $old_otp_list = $CI->common->select_data_by_condition('otp', array('otp_type' => $otp_type, 'otp_for' => $otp_for,
            'otp_for_id' => $otp_for_id, 'otp_status' => 'Open', 'otp_number !=' => $otp_number), 'otp_id', '', '', '', '', array());
        foreach ($old_otp_list as $old_otp) {
            $otp_update = array('otp_status' => 'Closed');
            $CI->common->update_data($otp_update, 'otp', 'otp_id', $old_otp['otp_id']);
        }
        $apiSetting = $CI->common->select_data_by_id('api', 'id', 7, 'field_value', array());
        $token = $apiSetting[0]['field_value'];
        $apiSetting = $CI->common->select_data_by_id('api', 'id', 8, 'field_value', array());
        $service_id = $apiSetting[0]['field_value'];
        $CI->load->library('clxsms', array('token' => $token,'service_id'=>$service_id));
        $body="Use Code {$otp_number} for {$otp_type} - {$CI->data['site_name']}";
        $result = $CI->clxsms->send_sms($CI->data['site_name'],array($mobile_number),$body);
        $current_date = date('Y-m-d H:i:s');
        $expired_date = date('Y-m-d H:i:s', strtotime('+20 minutes', strtotime($current_date)));
        $cur_otp_list = $CI->common->select_data_by_condition('otp', array('otp_type' => $otp_type, 'otp_for' => $otp_for,
            'otp_for_id' => $otp_for_id, 'otp_status' => 'Open', 'otp_number' => $otp_number), 'otp_id', '', '', '', '', array());
        if (count($cur_otp_list) == 0) {
            //store new otp
            $current_date = date('Y-m-d H:i:s');
            $expired_date = date('Y-m-d H:i:s', strtotime('+20 minutes', strtotime($current_date)));
            $new_otp_data = array('otp_number' => $otp_number,
                'created_date' => $current_date,
                'expired_date' => $expired_date,
                'otp_type' => $otp_type,
                'otp_for' => $otp_for,
                'otp_for_id' => $otp_for_id,
                'otp_status' => $otp_status
            );
            $CI->common->insert_data($new_otp_data, 'otp');
        }
        return true;
    }

}

if (!function_exists('verify_sms_otp')) {
    function verify_sms_otp($otp_number, $otp_type, $otp_for, $otp_for_id,$update_status) {
        $CI = & get_instance();
        $otp_detail = $CI->common->select_data_by_condition('otp', array('otp_number' => $otp_number, 'otp_type' => $otp_type, 'otp_for' => $otp_for, 'otp_for_id' => $otp_for_id,
            'otp_status' => 'Open'), 'otp_number,expired_date,otp_id', '', '', '', '', array());
        if (empty($otp_detail)) {
            return array('verify' => FALSE, 'message' => 'Invalid OTP code');
        }
        if (strtotime(date('Y-m-d H:i:s')) > strtotime($otp_detail[0]['expired_date'])) {
            return array('verify' => FALSE, 'message' => 'OTP code is expired');
        }
        if($update_status){
            $update_otp_data = array('otp_status' => 'Verified');
            $CI->common->update_data($update_otp_data, 'otp', 'otp_id', $otp_detail[0]['otp_id']);
            return array('verify' => TRUE, 'message' => 'OPT is verified');        
        }else{
            return array('verify' => TRUE, 'message' => 'OPT is verified');
        }
    }

}