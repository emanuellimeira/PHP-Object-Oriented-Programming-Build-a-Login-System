<?php

// Core Initialization
require_once 'core/init.php';

echo "<div class='maincontainer'>";

// Header
include 'includes/header.php';

//var_dump(Token::check(Input::get('token')));

  if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
      //echo "Submitted!";
      //echo Input::get('username');
      //echo Input::get('password');
      //echo Input::get('password_again');
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'username' => array(
          'required' => true,
          'min' => 2,
          'max' => 20,
          'unique' => 'users'
        ),
        'password' => array(
          'required' => true,
          'min' => 6
        ),
        'password_again' => array(
          'required' => true,
          'matches' => 'password'
        ),
        'name' => array(
          'required' => true,
          'min' => 2,
          'max' => 50
        )
      ));

      if ($validation->passed()) {
          //echo "Passed!";
          //Session::flash('success', 'You registered successfully!');
          //header('Location: index.php');
          $user = new User();
          try {

            $salt = Hash::salt(32);

            //echo "<meta charset='utf-8'><pre>";
            //print_r($salt);
            //echo "</pre>";

            //die();

            $user->create(array(
              'username' => Input::get('username'),
              'password' => Hash::make(Input::get('password'), $salt),
              'salt' => $salt,
              'name' => Input::get('name'),
              'joined' => date('Y-m-d H:i:s'),
              'group' => 1
              //'' => '',
            ));

            Session::flash('home', 'You have been registered and can now log in!');
            //header('Location: index.php');
            Redirect::to(404); // 'index.php'

          } catch (Exception $e) {
            die($e->getMessage());
          }

      } else {
        //print_r($validation->errors());
        foreach ($validation->errors() as $error) {
          echo $error, '<br>';
        }
      }

    } // fim segundo if
  } // fim primeiro if
?>

<form class="" action="" method="post">
  <div class="field form-group">
    <label for="name">Your Name</label>
    <input type="text" class="form-control" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name" autocomplete="off">
  </div>

  <div class="field form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username" value="<?php echo escape(Input::get('username')); ?>" id="username" autocomplete="off">
  </div>

  <div class="field form-group">
    <label for="password">Choose a password</label>
    <input type="password" class="form-control" name="password" value="" id="password" autocomplete="off">
  </div>

  <div class="field form-group">
    <label for="password_again">Enter your password again</label>
    <input type="password" class="form-control" name="password_again" value="" id="password_again" autocomplete="off">
  </div>
  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  <input type="submit" class="btn btn-success" value="Register">

</form>

<?php
  echo "</div> <!-- //maincontainer -->";
  include 'includes/footer.php';
?>
