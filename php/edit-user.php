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

    case 'done':
      // remove the NEW_USERS_ALLOWED file to prevent further user creation
      if (file_exists($_SESSION["docroot"].'/config/NEW_USERS_ALLOWED')) {
        unlink($_SESSION["docroot"].'/config/NEW_USERS_ALLOWED');
      }
      print_r(0);
      break;

    case 'new':
      // to create new users, ensure the file "NEW_USERS_ALLOWED" is present within the config directory
      if (file_exists($_SESSION["docroot"].'/config/NEW_USERS_ALLOWED')) {
        $user->new($_POST["username"], $_POST["passwd"]);
      }
      else {
        echo 1;
      }
      break;

    default:
      // code...
      break;
  }
?>
