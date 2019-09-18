<?php
require_once('../private/initialize.php');

// Log out the user
$session->logout();
$session->message('Logout successful.');
redirect_to('/');

?>
