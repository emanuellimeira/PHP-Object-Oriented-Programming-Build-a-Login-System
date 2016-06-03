<?php

// Core Initialization
require_once 'core/init.php';

echo "<div class='maincontainer'>";

// Header
include 'includes/header.php';

if (Input::exists()) {
  //echo "teste";
  if(Token::check(Input::get('token'))) {

    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'username' => array('required' => true),
      'password' => array('required' => true)
    ));
    if($validation->passed()) {
      //echo "Passou!";
      $user = new User();
      $remember = (Input::get('remember') === 'on') ? true : false;
      $login = $user->login(Input::get('username'), Input::get('password'), $remember);

      if ($login) {
        //echo "logado!";
        Redirect::to('index.php');
      } else {
        echo "<p class='label label-danger'>Sorry, logging in failed.</p><br><br>";
      }

    } else {
      foreach($validation->errors() as $error) {
        echo $error, '<br>';
      }
    }

  }
}
?>

<form class="" action="" method="post">

  <div class="field form-group">
    <label for="username">Username:</label>
    <input type="text" class="form-control" name="username" id="username" autocomplete="off">
  </div>

  <div class="field form-group">
    <label for="password">Password:</label>
    <input type="password" class="form-control" name="password" id="password" autocomplete="off">
  </div>

  <div class="field form-group">
    <label for="remember">
      <input type="checkbox" name="remember" id="remember"> Remember me
    </label>
  </div>

  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  <input type="Submit" class="btn btn-primary" value="Login">
</form>

<?php
  echo "</div> <!-- //maincontainer -->";
  include 'includes/footer.php';
?>
