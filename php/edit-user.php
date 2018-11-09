<?php
  session_start();
  include $_SESSION["docroot"].'/php/classes.user.php';
  $user = new user;
  $user->get_info($_COOKIE["token"]);

  switch ($_POST["function"]) {
    case 'change-pw':
      $user->change_password($_POST["current"], $_POST["new"]);
      break;

    default:
      // code...
      break;
  }
?>
