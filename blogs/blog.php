<?php
include('../private/initialize.php');

$id = $_GET['id'] ?? false;

$blog = Blog::find_blog_by_id($id);

if(!$id || !$blog) {
  redirect_to('/');
}

// show 5 recent blogs from the author of this blog
$sql = "SELECT id, title FROM blogs ";
// the user_id won't be shown in the url, so don't have to use escape_string
$sql .= "WHERE user_id = {$blog['user_id']} ";
$sql .= "ORDER BY create_date DESC ";
$sql .= "LIMIT 5";
$recent_user_blogs = Blog::sql_result($sql);

$page_title = title( h($blog['title']), ['change_case' => false] );
include('../private/header.php');

?>

<div class="container my-5">

  <div class="row">
    <div class="col-md">
      <h2 class="h1-responsive font-weight-bold pb-3"><?php echo h($blog['title']); ?></h2>
    </div>
  </div>

  <div class="row">

    <div class="col-md-9">

      <div class="pl-3 author-border-left">
        <!-- Username -->
        <p class="m-0">by
          <a href="/users/profile.php?id=<?php echo h(u($blog['user_id'])); ?>" class="font-weight-bold" title="All blogs by <?php echo h($blog['username']) ?>"><?php echo h($blog['username']); ?></a>
        </p>
        <!-- Create and update dates -->
        <p class="text-muted font-italic">
          <?php
          $create_date = date('l d M Y, h:ia', strtotime(h($blog['create_date'])));
          $update_date = date('l d M Y, h:i:sa', strtotime(h($blog['update_date'])));
          echo $create_date;
          // echo '<p>' . $update_date . '</p>';
          if ( strtotime(h($blog['create_date'])) < strtotime(h($blog['update_date'])) ) {
            $time_now = date('l d M Y, h:i:sa');
            $seconds = strtotime($time_now) - strtotime($update_date);
            echo " (Updated ";
            echo "<a href='#' class='material-tooltip-main' data-toggle='tooltip' title='" . date('l d M Y, h:i:a', strtotime(h($blog['update_date']))) . "'>" . time_ago_en(time() - $seconds) . "</a>";
            echo ")";
          }
          ?>
        </p>
      </div>

      <p id="content"><?php echo h($blog['content']); ?></p>

      <?php
      if (isset($_SESSION['user_id']) && $blog['user_id'] === $_SESSION['user_id']) { ?>
        <a href="update.php?id=<?php echo h(u($blog['id'])); ?>" class="btn btn-primary btn-md">Update blog</a>
        <a href="delete.php?id=<?php echo h(u($blog['id'])); ?>" class="btn btn-danger btn-md">Delete blog</a>
      <?php } ?>

    </div>

    <div class="col-md-3">

      <div class="card border-light">
        <div class="card-header">Recent blogs by <?php echo h($blog['username']); ?></div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <?php
            while($recent_blog = $recent_user_blogs->fetch_assoc()) {
              echo "<li class='list-group-item'><a href='/blogs/blog.php?id=" . h(u($recent_blog['id'])) . "' title= '" . h($recent_blog['title']) . "'>";
              // show the full title if the character length is less than 60. Otherwise show only the first 60 characters
              echo strlen($recent_blog['title']) < 60 ? h($recent_blog['title']) : substr(h($recent_blog['title']), 0, 60) . '...';
              echo "</a></li>";
            }
            ?>
          </ul>
        </div>
      </div>

    </div>

  </div>

</div>

<?php include('../private/footer.php'); ?>
