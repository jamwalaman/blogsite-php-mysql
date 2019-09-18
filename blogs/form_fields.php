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
  <input type="text" id="title" name="blog[title]" class="form-control <?php echo invalid("title_err", ["arr" => $blog->errors]); ?>" value="<?php echo h($blog->title); ?>">
  <label for="title">Title</label>
  <?php echo invalid("title_err", ["add_class" => false, "arr" => $blog->errors]); ?>
</div>

<!-- Content -->
<div class="md-form">
  <textarea id="content" name="blog[content]" class="form-control md-textarea <?php echo invalid("content_err", ["arr" => $blog->errors]); ?>" rows="6"><?php echo h($blog->content); ?></textarea>
  <label for="content">Content</label>
  <?php echo invalid("content_err", ["add_class" => false, "arr" => $blog->errors]); ?>
</div>

<!-- usr id -->
<input type="hidden" name="blog[user_id]" value="<?php echo $_SESSION['user_id']; ?>">
