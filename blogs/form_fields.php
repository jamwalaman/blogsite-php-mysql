<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($blog)) {
  header("Location: /");
  exit;
}

?>

<!-- Title -->
<div class="md-form">
  <input type="text" id="title" name="blog[title]" class="form-control <?php echo invalid("title_err", ["arr" => $blog->errors]); ?>" value="<?php echo h($blog->title); ?>" autocomplete="off">
  <label for="title">Title</label>
  <?php echo invalid("title_err", ["add_class" => false, "arr" => $blog->errors]); ?>
</div>

<!-- Content -->
<div class="md-form">
  <textarea id="content" name="blog[content]" class="form-control md-textarea <?php echo invalid("content_err", ["arr" => $blog->errors]); ?>" rows="6"><?php echo h($blog->content); ?></textarea>
  <label for="content">Content</label>
  <?php echo invalid("content_err", ["add_class" => false, "arr" => $blog->errors]); ?>
</div>

<!-- Image -->
<?php if ($blog->image) { ?>
  <small class="text-muted">Current image: <?php echo h($blog->image); ?></small>
  <img src=<?php echo img_link(h($blog->image)) ?> class="img-fluid" alt="Responsive image">
<?php } ?>
<div class="md-form">
  <input type="file" name="image" class="form-control-file <?php echo invalid("image_err", ["arr" => $blog->errors]); ?>" />
  <?php echo invalid("image_err", ["add_class" => false, "arr" => $blog->errors]); ?>
  <!-- TODO resize img using photoshop -->
  <small class="form-text text-muted mb-4"> Image size must be less than 1mb. Image format must jpeg, jpg or png. </small>
</div>

<!-- usr id -->
<input type="hidden" name="blog[user_id]" value="<?php echo $_SESSION['user_id']; ?>">
