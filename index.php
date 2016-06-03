<?php

// Core Initialization
require_once 'core/init.php';

// Header
include 'includes/header.php';



/*Teste de Configuração video "06. Config Class"
echo Config::get('mysql/host'); // 'localhost'
var_dump(Config::get('mysql/host/index'));


DB::getInstance();

$user = DB::getInstance()->query("SELECT username FROM users\ WHERE username =?", array('alex'));
if ($user->error()) {
  echo "No user";
} else {
  echo "Ok!";
}

$user = DB::getInstance()->get('users', array('username', '=', 'alex'));

if (!$user->count()) {
  echo "No user";
} else {
  echo "Ok!";
}

$user = DB::getInstance()->query("SELECT * FROM users");

$user = DB::getInstance()->get('users', array('username', '=', 'alex'));


if (!$user->count()) {
  echo "No user";
} else {
  foreach ($user->results() as $user) {
    echo $user->username, '<br>';
  }
  echo $user->results()[0]->username;
  echo $user->first()->username;
}

$user = DB::getInstance()->insert('users', array(
  'username'  => 'Dale',
  'password'  => 'password',
  'salt'      => 'salt'
));

$userUpdate = DB::getInstance()->update('users', 13, array(
  'username' => 'TesteUpdate',
  'password'  => 'newpassword',
  'name' => 'Emanuel Limeira'
));

if (Session::exists('success')) {
  echo Session::flash('success');
}
*/


echo "<div class='maincontainer'>";

if (Session::exists('home')) {
  echo '<p>' . Session::flash('home') .  '</p>';
}

//print Session::get(Config::get('session/session_name'));

$user = new User();
//echo $user->data()->username;
if ($user->isLoggedIn()) {

  echo "<p class='label label-success'>Success! You are logged in!</p><br><br>";
  ?>
  <p>
    Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->name); ?></a>
  </p>

  <ul>
    <li><a href="update.php">Update</a></li>
    <li><a href="changepassword.php">Change Password</a></li>
    <li><a href="logout.php">Logout</a></li>

  </ul>
  <?php
  // User Permission
  if ($user->hasPermission('admin')) {
    echo "<p>You are an Administrator!</p>";
  }

} else {
  echo "<p>You need to <a href='login.php'>log in</a> or <a href='register.php'>register</a></p>";
}

echo "</div> <!-- //maincontainer -->";

include 'includes/footer.php';
