<?php

session_start(); // global settings

$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => 'localhost',
    'username' => 'root',
    'password' =>  '',
    'db' => 'estudos_skillfeed'
  ),
  'remember' => array(
    'cookie_name' => 'hash',
    'cookir_expiry' => 604800
  ),

  'session' => array(
    'session_name' => 'user'
  )
);

spl_autoload(function($class) {
  require_once 'classes/'. $class . '.php';
});

require_once 'functions/sanitize.php';
