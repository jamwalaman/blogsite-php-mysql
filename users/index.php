<?php
include('../private/initialize.php');
if ($session->is_logged_in()) {
  redirect_to('/users/profile.php?id=' . $_SESSION['user_id']);
} else {
  redirect_to('/');
}
?>
