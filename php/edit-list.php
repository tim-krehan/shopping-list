<?php
  include $_SESSION["docroot"].'/php/classes.list.php';
  $shopping = new shopping;

  switch ($_GET["function"]) {
    case 'new':
      $newID = $shopping->newItem($_POST["anzahl"], $_POST["einheit"], $_POST["name"]);
      setcookie("newItem", "$newID", 0, "/", "");
      header("Location: /list");
      break;

    case 'multiple':
      $shopping->newItems($_POST["list"]);
      break;

    case 'change':
      $shopping->changeSingleItem($_POST["id"], $_POST["anzahl"], $_POST["einheit"], $_POST["name"]);
      break;

    case 'del':
      $shopping->removeSingleItem($_POST["id"]);
      break;

    case 'clear':
      $shopping->removeChecked();
      break;

    case 'check':
      $shopping->check($_POST["id"], $_POST["status"]);
      break;

    case 'export':
      echo json_encode($shopping);
      break;

    case 'import':
      $shopping->import();
      break;

    default:
      // code...
      break;
  }
?>
