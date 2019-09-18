<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($user)) {
  header("Location: /");
  exit;
}

?>

<!-- Username -->
<div class="md-form">
  <input type="text" id="username" name="user[username]" class="form-control <?php echo invalid("username_err"); ?>" value="<?php echo h($user->username); ?>">
  <label for="username">Username</label>
  <?php echo invalid("username_err", ["add_class" => false]); ?>
  <small class="form-text text-muted mb-4"> Username can only have numbers and letters with no spaces. </small>
</div>

<!-- Email -->
<div class="md-form">
  <input type="email" id="email" name="user[email]" class="form-control <?php echo invalid("email_err"); ?>" value="<?php echo h($user->email); ?>">
  <label for="email">E-mail</label>
  <?php echo invalid("email_err", ["add_class" => false]); ?>
  <small class="form-text text-muted mb-4"> You won't be getting any emails. This is what you use to login </small>
</div>

<!-- Password -->
<div class="md-form">
  <input type="password" id="password" name="user[password]" class="form-control <?php echo invalid("password_err"); ?>">
  <label for="password">Password</label>
  <?php echo invalid("password_err", ["add_class" => false]); ?>
</div>

<!-- Confirm Password -->
<div class="md-form">
  <input type="password" id="confirm_password" name="user[confirm_password]" class="form-control <?php echo invalid("pass_confirm_err"); ?>">
  <label for="confirm_password">Confirm Password</label>
  <?php echo invalid("pass_confirm_err", ["add_class" => false]); ?>
</div>
