<?php

include('../private/initialize.php');
$page_title = title('sign up');
include('../private/header.php');

page_not_for_loggedin_user();

if(is_post_request()) {

  // Create record using post parameters
  $user = new User($_POST['user']);
  $result = $user->save();

  if($result === true) {
    $new_id = $user->id;
    $session->message('User created successfully. You can now login.');
    redirect_to('/users/login.php');
  } else {
    // show errors
  }

} else {
  // display the form
  $user = new User;
}

?>

<div class="container my-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">

      <?php if (!empty($user->errors)) {
        echo form_error_box("Signup unsuccessful");
      } ?>

      <!-- Material form login -->
      <div class="card">

        <h5 class="card-header info-color white-text text-center py-4">
          <strong>Sign Up</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">

          <!-- Form -->
          <form novalidate class="text-center" style="color: #757575;" method="post" action="<?php echo h($_SERVER["PHP_SELF"]);?>">

            <?php include('form_fields.php'); ?>

            <!-- Sign in button -->
            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Sign in</button>

            <!-- Register -->
            <p>Or <a href="/users/login.php">Login</a> </p>

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
