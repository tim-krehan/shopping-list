<?php
  include $_SESSION["docroot"].'/php/classes.recipe.php';
  $book = new cookbook;

  switch ($_GET["function"]) {
    case 'del':
      $book->removeRecipe($_POST["id"]);
      break;

    case 'new':
      $book->newRecipe($_POST["recipeName"], $_POST["recipeDuration"], $_POST["recipeDescription"], $_POST["ingredient"]);
      header('Location: /recipes');
      break;

    case 'auto':
      $book->getAllIngredientsContaining($_POST["q"]);
      break;

    case 'edit':
      $book->getRecipe($_POST["id"]);
      echo json_encode($book->sites[0]);
      break;

    case 'update':
      $book->updateRecipe($_POST["id"], $_POST["recipeName"], $_POST["recipeDuration"], $_POST["recipeDescription"], $_POST["ingredient"]);
      header(("Location: /recipe/".$_POST["id"]));
      break;

    case 'export':
      $book->fillCookbook();
      echo json_encode($book);
      break;

    case 'import':
      $book->importCookbook();
      break;

    default:
      // code...
      break;
  }
?>
