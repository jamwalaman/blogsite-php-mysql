<?php
include('private/initialize.php');
$page_title = title('home');
include('private/header.php');
?>

<div class="container my-5">

  <?php
  if (Blog::count_all() == 0) {
    echo no_blogs_found();
  }
  ?>

  <div class="row excerpt_border">

    <!-- Most recent blog -->
    <div class="col-md-6">
      <?php foreach(Blog::find_all() as $i => $blog) {
        if ($blog['image'] && $i === 1) { ?>
          <img class="img-fluid" src='<?php echo img_link(h($blog['image'])) ?>' alt="Blog image">
          <?php echo home_content(["heading" => "h2", "excerpt" => true]);
        }
      } ?>
    </div>
    <!-- More recent blogs -->
    <div class="col-md-6">
      <?php foreach(Blog::find_all() as $i => $blog) {
        if ($blog['image'] && $i >=2) { ?>
          <div class="row <?php echo $i === 3 ? "py-4" : false ?>">
            <div class="col-md-6">
              <img class="img-fluid" src='<?php echo img_link(h($blog['image'])) ?>' alt="Blog image">
            </div>
            <div class="col-md-6">
              <?php echo home_content() ?>
            </div>
          </div><!-- end row -->
        <?php if ($i === 4) break; }
      } ?>
    </div>

  </div><!-- end row -->

  <!-- Even more recent blogs -->
  <div class="row row-cols-1 row-cols-md-4 pt-4">
    <?php foreach(Blog::find_all() as $i => $blog) {
      if($blog['image'] && $i >= 4) { ?>
        <div class="col mb-4">
          <img class="img-fluid" src='<?php echo img_link(h($blog['image'])) ?>' alt="Blog image">
          <?php echo home_content(["heading" => "h5", "excerpt" => true, "length" => 180, "margin" => "my-3"]) ?>
        </div>
      <?php if ($i === 11) break; }
    } ?>
  </div>

</div><!-- end container -->

<?php include('private/footer.php'); ?>
