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
  $session->message("Not allowed to delete another user's blog.");
  redirect_to('/');
}

if(is_post_request()) {

  // Delete blog
  $result = $blog->delete();
  // And if there's blog image, delete it from the uploads folder
  if ($blog->image) {
    unlink('../uploads/'.$blog->image);
  }
  $session->message('Blog deleted successfully.');
  redirect_to('/');

} else {
  // Display form
}

$pt = 'delete blog: ' . $blog->title;
$page_title = title( $pt, ['uppercase' => ucfirst($pt)] );

include('../private/header.php');

?>

<div class="container my-5">

  <div class="row justify-content-center">
    <div class="col-10">

      <div class="card border-light mb-3">
        <div class="card-header">Confirm delete</div>
        <div class="card-body">
          <h5 class="card-title"><?php echo h($blog->title); ?></h5>
          <p class="card-text"><?php echo substr(h($blog->content), 0, 630) . '...'; ?></p>
          <!-- Form -->
          <form novalidate method="post" action="/blogs/delete.php?id=<?php echo h(u($id));?>">
            <!-- Go back link -->
            <a href="/blogs/blog.php?id=<?php echo h(u($blog->id)); ?>" class="btn btn-light btn-md">Go back</a>
            <!-- Delete blog button -->
            <button class="btn btn-danger btn-md" type="submit">Delete</button>
          </form>
        </div>
      </div>

    </div>
  </div>

</div>

<?php include('../private/footer.php'); ?>
