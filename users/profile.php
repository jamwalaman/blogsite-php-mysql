<?php

include('../private/initialize.php');

$id = $_GET['id'] ?? false;

$user = User::find_by_id($id);

$current_page = $_GET['page'] ?? 1;
$per_page = 5;
$total_count = Blog::count_all(['user_id' => $id]);
$pagination = new PaginationProfile($current_page, $per_page, $total_count);

if ( !$id || !$user || !$current_page || ($total_count > 0 && $current_page > $pagination->max_num('/users/profile.php?id='. $id)) ) {
  redirect_to('/');
}

$sql = "SELECT blogs.id, title, content, create_date FROM users ";
$sql .= "INNER JOIN blogs ON users.id = blogs.user_id ";
$sql .= "WHERE user_id = '" . $database->escape_string($id) . "' ";
$sql .= "ORDER BY create_date DESC ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$blogs = Blog::sql_result($sql);

$pt = 'profile: ' . h($user->username);
$page_title = title( $pt, ['uppercase' => ucfirst($pt)] );
include('../private/header.php');

?>

<div class="container my-5">

  <h2 class="h1-responsive font-weight-bold text-center my-5">All blogs by <?php echo h($user->username); ?></h2>

  <?php

  if ($total_count == 0) {
    echo no_blogs_found(['note_heading' => "No blogs by " . h($user->username)]);
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
        <p><?php echo date("d/m/Y", strtotime( h($blog['create_date']) )); ?></p>
        <!-- Excerpt -->
        <p class="dark-grey-text">
          <?php // Only get the first 500 characters from the blog
          echo substr(h($blog['content']), 0, 630) . '...';
          ?>
        </p>
        <!-- Read more button -->
        <a href="/blogs/blog.php?id=<?php echo h(u($blog['id'])); ?>" class="btn btn-info btn-md">Read more</a>

      </div>
    </div>

  <?php }

    echo $pagination->page_links('/users/profile.php?id='. $id);

  ?>

</div>

<?php include('../private/footer.php'); ?>
