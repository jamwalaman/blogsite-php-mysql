<?php
include('../private/initialize.php');

if(!isset($_GET['id'])) {
  $session->message("No blog found.");
  redirect_to('/');
}

$id = $_GET['id'];
$blog = Blog::find_by_id($id);

// Redirect to the home page if no blog found or if the logged in user didne't create the blog
if($blog == false || $blog->user_id !== $_SESSION['user_id']) {
  $session->message("Not allowed to update another user's blog.");
  redirect_to('/');
}

if(is_post_request()) {

  // Save record using post parameters
  $blog->merge_attributes($_POST['blog']);
  $result = $blog->save();

  if($result === true) {
    $session->message('Blog updated successfully.');
    redirect_to('/blogs/blog.php?id=' . $id);
  } else {
    // show errors
  }

} else {

  // display the form

}

$pt = 'update blog: ' . $blog->title;
$page_title = title( $pt, ['uppercase' => ucfirst($pt)] );

include('../private/header.php');
?>

<div class="container my-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">

      <?php
      if (!empty($blog->errors)) {
        echo form_error_box("Couldn't update the blog.");
      }
      ?>

      <!-- Material form login -->
      <div class="card">

        <h5 class="card-header info-color white-text text-center py-4">
          <strong>Update blog</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">

          <!-- Form -->
          <form novalidate style="color: #757575;" method="post" action="/blogs/update.php?id=<?php echo h(u($id));?>">

            <?php include('form_fields.php'); ?>

            <!-- Go back link -->
            <a href="/blogs/blog.php?id=<?php echo h(u($blog->id)); ?>" class="btn btn-light btn-md">Go back</a>
            <!-- Update blog button -->
            <button class="btn btn-primary btn-md" type="submit">Update</button>

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
