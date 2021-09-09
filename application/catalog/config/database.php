<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;


if ($_SERVER['HTTP_HOST'] == "localhost") {
    $db['default'] = array(
        'dsn' => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => '<database_name>',
        'dbdriver' => 'mysqli',
        'dbprefix' => '<database_prefixname>_',
        'pconnect' => FALSE,
        'db_debug' => TRUE,
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => TRUE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
    );


    $db['databaseblog'] = array(
        'dsn' => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'blog',
        'dbdriver' => 'mysqli',
        'dbprefix' => 'wp_',
        'pconnect' => FALSE,
        'db_debug' => TRUE,
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => TRUE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
    );
} else {
    $db['default'] = array(
        'dsn' => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => 'password',
        'database' => '<database_name>',
        'dbdriver' => 'mysqli',
        'dbprefix' => '<database_prefixname>_',
        'pconnect' => FALSE,
        'db_debug' => TRUE,
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => TRUE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
    );


    $db['databaseblog'] = array(
        'dsn' => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'blog',
        'dbdriver' => 'mysqli',
        'dbprefix' => 'wp_',
        'pconnect' => FALSE,
        'db_debug' => TRUE,
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => TRUE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
    );
}


