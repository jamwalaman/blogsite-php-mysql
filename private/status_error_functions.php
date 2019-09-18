<?php

function require_login() {
  global $session;
  if(!$session->is_logged_in()) {
    redirect_to('/');
  } else {
    // Do nothing, let the rest of the page proceed
  }
}

function page_not_for_loggedin_user() {
  global $session;
  if($session->is_logged_in()) {
    redirect_to('/');
  } else {
    // Do nothing, let the rest of the page proceed
  }
}

function display_session_message() {
  global $session;
  $msg = $session->message();
  if(isset($msg) && $msg != '') {
    $session->clear_message();
    $html = "<div class='container'>";
    $html .= "<div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>";
    $html .= h($msg);
    $html .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
    $html .= "<span aria-hidden='true'>&times;</span>";
    $html .= "</button></div></div>";
    return $html;
  }
}

?>
