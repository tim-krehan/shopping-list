<?php
  session_start();
  include $_SESSION["docroot"].'/php/classes.list.php';
  $shopping = new shopping;

  switch ($_POST["function"]) {
    case 'new':
      $shopping->newItem($_POST["anzahl"], $_POST["einheit"], $_POST["name"]);
      header("Location: /list");
      break;

    case 'multiple':
      $shopping->newItems($_POST["list"]);
      break;

    case 'del':
      $shopping->removeChecked();
      break;

    case 'check':
      $shopping->check($_POST["id"], $_POST["status"]);
      break;

    case 'export':
      echo json_encode($shopping);
      break;

    default:
      // code...
      break;
  }
?>
