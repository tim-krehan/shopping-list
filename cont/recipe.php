<link rel="stylesheet" href="/style/recipe.css">
<script src="/bin/recipe.js" charset="utf-8"></script>
<?php
  include $_SESSION["docroot"].'/php/classes.recipe.php';
    include $_SESSION["docroot"].'/php/classes.parsedown.php';
  $book = new cookbook;
  $book->getRecipe($_GET["number"]);
  $recipe = $book->sites[0];

  echo "<h1 data-recipeid='$recipe->ID'>$recipe->Name</h1>";
  echo "<h2>Zutaten</h2>";
  echo "<button id='addToListButton' class='button'>Zur Einkaufsliste hinzufügen</button>";
  echo "<div id='ingredients'>";
  $parity="odd";
  foreach($recipe->Zutaten as $Zutat){
    if($parity=="even"){$parity="odd";}else{$parity="even";}
    echo "<span class='ingredients_row $parity'><font class='ingredients_row_amount'>$Zutat->Menge</font><font class='ingredients_row_unit'>$Zutat->Einheit</font><font class='ingredients_row_name'>".$Zutat->Name."</font></span>";
  }
  echo "</div>";
  echo "<h2>Zubereitung</h2>";
  $parsedown = new Parsedown;
  echo $parsedown->text($recipe->Beschreibung);
?>
<div id="editingMenu"></div>
<div id="editingMenuOpen">
  <font id="closeMenue">⬆</font>
  <font id="edit-recipe">✎</font>
  <font id="delRecipe">✘</font>
</div>
