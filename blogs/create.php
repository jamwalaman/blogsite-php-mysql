<?php

include('../private/initialize.php');
$page_title = title('create blog');
require_login();

include('../private/header.php');

if(is_post_request()) {

  // Create record using post parameters
  $blog = new Blog($_POST['blog']);
  $result = $blog->save();

  if($result === true) {
    $new_id = $blog->id;
    $session->message('Blog created successfully.');
    redirect_to('/blogs/blog.php?id=' . $new_id);
  } else {
    // show errors
  }

} else {
  // display the form
  $blog = new Blog;
}

?>

<div class="container my-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">

      <?php
      if (!empty($blog->errors)) {
        echo form_error_box("Couldn't create the blog.");
      }
      ?>

      <!-- Material form login -->
      <div class="card">

        <h5 class="card-header info-color white-text text-center py-4">
          <strong>Ceate blog</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">

          <!-- Form -->
          <form novalidate class="text-center" style="color: #757575;" method="post" action="<?php echo h($_SERVER["PHP_SELF"]);?>">

            <?php include('form_fields.php'); ?>

            <!-- Create blogbutton -->
            <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Create</button>

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
