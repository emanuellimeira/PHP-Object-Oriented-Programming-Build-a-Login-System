<?php
  require_once 'core/init.php';

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
          Session::flash('success', 'You registered successfully!');
          header('Location: index.php');
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
  <div class="field">
    <label for="name">Your Name</label>
    <input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name" autocomplete="off">
  </div>

  <div class="field">
    <label for="username">Username</label>
    <input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>" id="username" autocomplete="off">
  </div>

  <div class="field">
    <label for="password">Choose a password</label>
    <input type="password" name="password" value="" id="password" autocomplete="off">
  </div>

  <div class="field">
    <label for="password_again">Enter your password again</label>
    <input type="password" name="password_again" value="" id="password_again" autocomplete="off">
  </div>
  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  <input type="submit" value="Register">

</form>
