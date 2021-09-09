<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$CI = & get_instance();



/*

  | -------------------------------------------------------------------

  |  Facebook API Configuration

  | -------------------------------------------------------------------

  |

  | To get an facebook app details you have to create a Facebook app

  | at Facebook developers panel (https://developers.facebook.com)

  |

  |  facebook_app_id               string   Your Facebook App ID.

  |  facebook_app_secret           string   Your Facebook App Secret.

  |  facebook_login_redirect_url   string   URL to redirect back to after login. (do not include base URL)

  |  facebook_logout_redirect_url  string   URL to redirect back to after logout. (do not include base URL)

  |  facebook_login_type           string   Set login type. (web, js, canvas)

  |  facebook_permissions          array    Your required permissions.

  |  facebook_graph_version        string   Specify Facebook Graph version. Eg v3.2

  |  facebook_auth_on_load         boolean  Set to TRUE to check for valid access token on every page load.

 */

$CI->data['sem_setting'] = $CI->common->select_data_by_condition('sem', array(), 'setting_value', 'setting_id', 'ASC', '', '', array());
$CI->data['FacebookAppid'] = $CI->data['sem_setting'][0]['setting_value'];
$CI->data['FacebookAppSecret'] = $CI->data['sem_setting'][1]['setting_value'];
$config['facebook_app_id'] = $CI->data['FacebookAppid'];
$config['facebook_app_secret'] = $CI->data['FacebookAppSecret'];
$config['facebook_login_redirect_url'] = 'Login/facebooklogin';
$config['facebook_logout_redirect_url'] = 'Dashboard/logout';
$config['facebook_login_type'] = 'web';
$config['facebook_permissions'] = array('email');
$config['facebook_graph_version'] = 'v3.2';
$config['facebook_auth_on_load'] = TRUE;
