<?php

include('../private/initialize.php');
$page_title = title('login');
include('../private/header.php');

page_not_for_loggedin_user();

$errors = [];
$email = '';
$password = '';

if(is_post_request()) {

  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if(is_blank($email)) {
    $errors["email_err"] = "Email cannot be blank.";
  }
  if(is_blank($password)) {
    $errors["password_err"] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    $user = User::find_by_email($email);
    // test if user found and password is correct
    if($user != false && $user->verify_password($password)) {
      // Mark user as logged in
      $session->login($user);
      $session->message('Login successful.');
      redirect_to('/users/profile.php?id=' . $_SESSION['user_id']);
    } else {
      // email not found or password does not match
      $errors["unsuccessful"] = "Log in was unsuccessful. Password and email don't match";
    }

  }

}

?>

<div class="container my-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">

      <?php if (array_key_exists("unsuccessful", $errors)) {
        echo form_error_box($errors["unsuccessful"]);
      } ?>

      <!-- Material form login -->
      <div class="card">

        <h5 class="card-header info-color white-text text-center py-4">
          <strong>Login</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">

          <!-- Form -->
          <form novalidate class="text-center" style="color: #757575;" method="post" action="<?php echo h($_SERVER["PHP_SELF"]);?>">

            <!-- Email -->
            <div class="md-form">
              <input type="email" id="email" name="email" value="<?php echo h($email); ?>" class="form-control <?php echo invalid("email_err", ["arr" => $errors]); ?>">
              <label for="email">E-mail</label>
              <?php echo invalid("email_err", ["add_class" => false, "arr" => $errors]); ?>
            </div>

            <!-- Password -->
            <div class="md-form">
              <input type="password" id="password" name="password" class="form-control <?php echo invalid("password_err", ["arr" => $errors]); ?>">
              <label for="password">Password</label>
              <?php echo invalid("password_err", ["add_class" => false, "arr" => $errors]); ?>
            </div>

            <!-- Sign in button -->
            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Sign in</button>

            <!-- Register -->
            <p>Or <a href="/signup.php">Sign Up</a> </p>

          </form>
          <!-- Form -->

        </div>

      </div>
      <!-- Material form login -->

    </div>
    <!-- end col -->
  </div>

</div>

<?php include('../private/footer.php'); ?>
