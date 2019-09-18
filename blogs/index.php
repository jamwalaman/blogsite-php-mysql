<?php
include('../private/initialize.php');
$page_title = title('all blogs');
include('../private/header.php');

$current_page = $_GET['page'] ?? 1;
$per_page = 5;
$total_count = Blog::count_all();
$pagination = new Pagination($current_page, $per_page, $total_count);

/* Redirect the users to home page if there's no $current_page.
If the number of $total_count is 10, it means the pagination will be 2 pages long ('/blogs/index.php?page=2')
So if users try a number greater than 2 ( eg '/blogs/index.php?page=3'), they'll be redirected
*/
if ( !$current_page || ($total_count > 0 && $current_page > $pagination->max_num('/blogs/index.php')) ) {
  redirect_to('/');
}

$sql = "SELECT blogs.id, blogs.user_id, username, title, content, create_date FROM users, blogs ";
$sql .= "WHERE users.id = blogs.user_id ";
$sql .= "ORDER BY create_date DESC ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$blogs = Blog::sql_result($sql);

?>

<div class="container my-5">

  <!-- Section heading -->
  <h2 class="h1-responsive font-weight-bold text-center my-5">All Blogs</h2>

  <?php
  // echo $total_count;
  if ($total_count == 0) {
    echo no_blogs_found();
  }

  $count = 0;

  while ($blog = $blogs->fetch_assoc()) {
    $count ++;
  ?>

    <!-- Grid row -->
    <div class="row justify-content-center">
      <!-- Grid column -->
      <div class="col-10 <?php echo $count == 1 ? "pb-5" : "py-5" ?> excerpt_border">

        <!-- Blog title -->
        <h3 class="mb-3"><strong><?php echo h($blog['title']); ?></strong></h3>
        <!-- Blog author -->
        <p>by
          <a href="/users/profile.php?id=<?php echo h(u($blog['user_id'])); ?>" class="font-weight-bold" title="All blogs by <?php echo h($blog['username']) ?>"><?php echo h($blog['username']); ?></a>,
          <?php echo date("d/m/Y", strtotime( h($blog['create_date']) )); ?>
        </p>
        <!-- Excerpt -->
        <p class="dark-grey-text">
          <?php // Only get the first 500 characters from the blog
          echo substr(h($blog['content']), 0, 630) . '...';
          ?>
        </p>
        <!-- Read more button -->
        <a href="blog.php?id=<?php echo h(u($blog['id'])); ?>" class="btn btn-info btn-md">Read more</a>

      </div>
    </div>

  <?php

    }

    echo $pagination->page_links('/blogs/index.php');

    $blogs->free();

  ?>

</div>

<?php include('../private/footer.php'); ?>
