<?php

function url_for($script_path) {
  // add the leading '/' if not present
  if($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string="") {
  return urlencode($string);
}

function raw_u($string="") {
  return rawurlencode($string);
}

function h($string="") {
  return htmlspecialchars($string, ENT_QUOTES);
}

function error_404() {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500() {
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function title($title, $options=[]) {
  $change_case = $options['change_case'] ?? true;
  $page_title = $title;
  if ($change_case) {
    $page_title = $options['uppercase'] ?? ucwords($title);
  }
  return $page_title . ' | Blog Site';
}

// For forms
function invalid($arr_key, $options = []) {
  global $user;
  $add_class = $options['add_class'] ?? true;
  $arr = $options['arr'] ?? $user->errors;
  $html = '';
  if (array_key_exists($arr_key, $arr)) {
    if ($add_class) {
      $html .= "is-invalid";
    } else {
      $html .= "<div class='invalid-feedback'>";
      $html .= $arr[$arr_key];
      $html .= "</div>";
    }
  }
  return $html;
}

// Form errors
function form_error_box($err) {
  $html = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
  $html .= $err;
  $html .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
  $html .= "<span aria-hidden='true'>&times;</span>";
  $html .= "</button></div>";
  return $html;
}

// Get relative time (from https://stackoverflow.com/a/9619947)
function time_ago_en($time) {

  if(!is_numeric($time)) {
    $time = strtotime($time);
  }

  $periods = array("second", "minute", "hour", "day", "week", "month", "year", "age");
  $lengths = array("60","60","24","7","4.35","12","100");

  $now = time();

  $difference = $now - $time;

  if ($difference <= 10 && $difference >= 0) {
    return $tense = 'just now';
  } elseif ($difference > 0) {
    $tense = 'ago';
  } elseif($difference < 0) {
    $tense = 'later';
  }

  for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
    $difference /= $lengths[$j];
  }

  $difference = round($difference);

  $period =  $periods[$j] . ($difference >1 ? 's' :'');
  return "{$difference} {$period} {$tense} ";

}

function no_blogs_found($options=[]) {
  global $session;
  $note_heading = $options['note_heading'] ?? 'No blogs found.';
  $no_blogs_html = '<div class="row"><div class="col-auto">';
  $no_blogs_html .= '<p class="note note-info"><strong>' . $note_heading . '</strong>';
  if ($_SERVER['PHP_SELF'] !== '/users/profile.php') {
    if ($session->is_logged_in()) {
      $no_blogs_html .= '<a href="/blogs/create.php"> Click here </a>to create a blog</a>';
    } else {
      $no_blogs_html .= '<a href="/users/login.php"> Login </a>to create a blog</a>';
    }
  }
  $no_blogs_html .= '</p></div></div>';
  return $no_blogs_html;
}

function img_link($img) {
  $imgHTML = "../uploads/".$img;
  return $imgHTML;
}

function upld_img_name($img) {
  $imgname = $_SESSION['user_id'] . '_' . str_replace(' ', '_', $img);
  return $imgname;
}

?>
