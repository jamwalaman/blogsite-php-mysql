<?php

function nav_link_html($href, $name) {
  $html = "<li class='nav-item";
  if ($_SERVER['PHP_SELF'] == $href) {
    $html .= " active";
  }
  $html .= "'>";
  $html .= "<a class='nav-link' href='$href'>$name</a>";
  $html .= "</li>";
  return $html;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo $page_title; ?></title>
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/css/mdb.min.css" rel="stylesheet">
  <!-- custom styles -->
  <link href="/css/style.css" rel="stylesheet">
</head>

<body>

<!--Main Navigation-->
<nav class="navbar fixed-top navbar-expand-md navbar-dark purple scrolling-navbar">
  <div class="container">
    <a class="navbar-brand" href="/"><strong>Blog Site</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Links -->
      <ul class="navbar-nav mr-auto">
        <?php
          echo nav_link_html('/', 'Home');
          echo nav_link_html('/blogs/index.php', 'All Blogs');
          // Links for logged in user
          if ($session->is_logged_in()) { ?>
            <?php echo nav_link_html('/blogs/create.php', 'Create Blog'); ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo "Hi {$session->username}" ?></a>
              <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
                <a class="dropdown-item" href="<?php echo '/users/profile.php?id=' . $_SESSION['user_id']; ?>">Profile</a>
                <a class="dropdown-item" href="/users/logout.php">Logout</a>
              </div>
            </li>
          <?php } else {
            // No logged in user. Show links to login and sign up page
            echo nav_link_html('/users/login.php', 'Login');
            echo nav_link_html('/users/signup.php', 'Sign Up');
          }
        ?>
      </ul>
    </div>
  </div>
</nav>

<?php

$msg = $session->message();

if(isset($msg) && $msg != '') {

  $session->clear_message(); ?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-auto">

        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
          <?php echo h($msg); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

      </div>
    </div>
  </div>

<?php } ?>
