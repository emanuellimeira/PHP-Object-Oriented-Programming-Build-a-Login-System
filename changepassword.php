<?php
// Core Initialization
require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
  Redirect::to('index.php');
}
if (Input::exists()) {
  if (Token::check(Input::get('token'))) {
    echo "Ok!"; // stop here - starts again in the next step
  }
}
?>

<form class="" action="" method="post">
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
