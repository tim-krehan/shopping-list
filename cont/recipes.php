<link rel="stylesheet" href="/style/recipes.css">
<script src="/bin/search.js" charset="utf-8"></script>
<script src="/bin/recipes.js" charset="utf-8"></script>
<h1 id="header">Rezepte</h1>
<button type="button" id="new-recipe" class="button">Neues Rezept</button>
<input type="text" id="searchRecipe" class="search" placeholder="Suchen...">
<div id="recipes">
<?php
  include $_SESSION["docroot"].'/php/classes.recipe.php';
  $book = new cookbook;

  $i=0;
  $currentLetter = "";
  foreach ($book->getRecipeNames() as $id => $name) {
    if($i%2==0){$parity="even";}else{$parity="odd";}

    if((strtoupper(str_split($name)[0]))!=strtoupper($currentLetter)){
      $currentLetter = strtoupper(str_split($name)[0]);
      echo "<h2>".strtoupper($currentLetter)."</h2>";
    }
    echo "<font data-id='$id' data-letter='$currentLetter' class='hover $parity'>$name</font>";
    $i++;
  }
?>
</div>
