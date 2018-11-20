<?php
  session_start();
  switch($_GET["call"]) {
    case 'list':
      include $_SESSION["docroot"].'/php/edit-list.php';
      break;

    case 'recipes':
      include $_SESSION["docroot"].'/php/edit-recipes.php';
      break;

    case 'user':
      include $_SESSION["docroot"].'/php/edit-user.php';
      break;

    default:
      echo "API call not defined";
      break;
  }
?>
