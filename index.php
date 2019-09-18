<?php
include('private/initialize.php');
$page_title = title('home');
include('private/header.php');

$sql = "SELECT blogs.id, user_id, username, title, content, create_date FROM users, blogs ";
$sql .= "WHERE users.id = blogs.user_id ";
$sql .= "ORDER BY create_date DESC ";
$sql .= "LIMIT 3 ";
$blogs = Blog::sql_result($sql);
?>

<div class="container my-5">

  <?php
  if (Blog::count_all() == 0) {
    echo no_blogs_found();
  }
  ?>

  <!--Carousel Wrapper-->
  <div id="carousel" class="carousel slide" data-ride="carousel">
    <!--Indicators-->
    <ol class="carousel-indicators">
      <li data-target="#carousel" data-slide-to="0" class="active"></li>
      <li data-target="#carousel" data-slide-to="1"></li>
      <li data-target="#carousel" data-slide-to="2"></li>
    </ol>
    <!--/.Indicators-->

    <!--Slides-->
    <div class="carousel-inner" role="listbox">

      <?php
      $count = 0;
      while ($blog = $blogs->fetch_assoc()) {
        $count++;
      ?>

      <div class="carousel-item <?php echo $count == 1 ? "active" : false ?>">

          <div class="jumbotron purple lighten-4 m-2 text-center">
            <h2 class="h2-responsive"><?php echo h($blog['title']) ?></h2>
            <p class="author-bottom-border pb-3">by
              <a href="/users/profile.php?id=<?php echo h(u($blog['user_id'])); ?>" class="font-weight-bold" title="All blogs by <?php echo h($blog['username']) ?>"><?php echo h($blog['username']); ?></a>,
              <?php echo date("d/m/Y", strtotime( h($blog['create_date']) )); ?>
            </p>
            <p><?php echo substr(h($blog['content']), 0, 630) . "...<a href='/blogs/blog.php?id=" . h(u($blog['id'])) . "'>[read more]</a>"; ?></p>
          </div>

      </div>
    <?php } ?>

    </div>
    <!--/.Slides-->
    <!--Controls-->
    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    <!--/.Controls-->
  </div>
  <!--/.Carousel Wrapper-->

</div>

<?php include('private/footer.php'); ?>
