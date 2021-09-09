<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// all the front route define here

$route['default_controller'] = 'Dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['p/(:any)'] = "Dashboard/viewcardhtml/$1";
$route['ref/(:any)'] = 'Register/new_ref/$1';
