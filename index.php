<?php
// Core Initialization
require_once 'core/init.php';

// Teste de Configuração video "06. Config Class"
//echo Config::get('mysql/host'); // 'localhost'
//var_dump(Config::get('mysql/host/index'));


// DB::getInstance();

// $user = DB::getInstance()->query("SELECT username FROM users\ WHERE username =?", array('alex'));
// if ($user->error()) {
//   echo "No user";
// } else {
//   echo "Ok!";
// }

$user = DB::getInstance()->get('users', array('username', '=', 'bill'));

if (!$user->count()) {
  echo "No user";
} else {
  echo "Ok!";
}
