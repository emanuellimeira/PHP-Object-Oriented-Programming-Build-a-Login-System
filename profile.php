<?php

// Core Initialization
require_once 'core/init.php';

echo "<div class='maincontainer'>";

// Header
include 'includes/header.php';

if (!$username = Input::get('user')) {
  Redirect::to('index.php');
} else {
  $user = new User($username);
  if (!$user->exists()) {
    Redirect::to(404);
  } else {
    //echo "User exists!";
    $data = $user->data();
  }
  ?>

  <h3><?php echo escape($data->name); ?></h3>
  <p>Username: <?php echo escape($data->username); ?></p>


  <?php
}


  echo "</div> <!-- //maincontainer -->";
  include 'includes/footer.php';
