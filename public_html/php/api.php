<?php
  session_start();
  $_SESSION["docroot"] =  __DIR__;
  switch($_GET["call"]) {
    case 'list':
      include $_SESSION["docroot"].'/edit-list.php';
      break;

    case 'recipes':
      include $_SESSION["docroot"].'/edit-recipes.php';
      break;

    case 'user':
      include $_SESSION["docroot"].'/edit-user.php';
      break;

    default:
      echo "API call not defined";
      break;
  }
?>
