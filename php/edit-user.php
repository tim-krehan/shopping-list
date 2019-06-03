<?php
  include $_SESSION["docroot"].'/php/classes.user.php';
  $user = new user;
  if($_GET["function"]!="new"){
    $user->get_info($_COOKIE["token"]);
  }
  
  switch ($_GET["function"]) {
    case 'change-pw':
      $user->change_password($_POST["current"], $_POST["new"]);
      break;

    case 'change-theme':
      $user->change_theme($_POST["theme"]);
      break;

    case 'change-mail':
      $user->change_mail($_POST["mail"]);
      break;

    case 'change-username':
      $user->change_username($_POST["username"]);
      break;

    case 'new':
      $user->new($_POST["username"], $_POST["passwd"]);
      break;

    default:
      // code...
      break;
  }
?>
