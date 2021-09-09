<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('verifydocument')) {

    function verifydocument($man, $bfn, $bln, $bco, $doType, $docCountry, $imagePath, $docid, $userid) {
        $CI = & get_instance();
        $CI->load->model('common');
        $apiSetting = $CI->common->select_data_by_id('api', 'id', 1, 'field_value', array());
        $apiUsername = $apiSetting[0]['field_value'];
        $apiSetting = $CI->common->select_data_by_id('api', 'id', 2, 'field_value', array());
        $apiPassword = $apiSetting[0]['field_value'];
        $CI->load->library('mindglobal', array('username' => $apiUsername, 'password' => $apiPassword));
        $path = $imagePath;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $scanData = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $result = $CI->mindglobal->createConsumer($man, $bfn, $bln, $bco, $doType, $docCountry, $scanData);
        if (isset($result['state'])) {
            $mtid = $result['mtid'];
            $status = constant('DOC_STATUS_' . $result['state']);
            $updateDoc = ['status' => $status, 'mtid' => $mtid, 'verified_date' => date('Y-m-d H:i:s')];
            $CI->common->update_data($updateDoc, 'user_kyc', 'id', $docid);
            if ($status == DOC_STATUS_A) {
                $updateUser = ['kyc_verified' => 'Yes'];
                $CI->common->update_data($updateUser, 'users', 'id', $userid);
                return TRUE;
            }
        }
        return FALSE;
    }
    function check_status($mtid,$docid,$userid) {
        $CI = & get_instance();
        $CI->load->model('common');
        $apiSetting = $CI->common->select_data_by_id('api', 'id', 1, 'field_value', array());
        $apiUsername = $apiSetting[0]['field_value'];
        $apiSetting = $CI->common->select_data_by_id('api', 'id', 2, 'field_value', array());
        $apiPassword = $apiSetting[0]['field_value'];
        $CI->load->library('mindglobal', array('username' => $apiUsername, 'password' => $apiPassword));
        $result = $CI->mindglobal->check_status($mtid);
        if (isset($result['state'])) {
            $mtid = $result['mtid'];
            $status = constant('DOC_STATUS_' . $result['state']);
            $updateDoc = ['status' => $status, 'mtid' => $mtid, 'verified_date' => date('Y-m-d H:i:s')];
            $CI->common->update_data($updateDoc, 'user_kyc', 'id', $docid);
            if ($status == DOC_STATUS_A) {
                $updateUser = ['kyc_verified' => 'Yes'];
                $CI->common->update_data($updateUser, 'users', 'id', $userid);
                return TRUE;
            }
        }
        return FALSE;
    }

}