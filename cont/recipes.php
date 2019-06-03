<script src="/js/search.js" charset="utf-8"></script>

<div class="container mt-5 mb-5">
    <h1>Rezepte</h1>
</div>

<a href="/new-recipe" class="btn btn-primary float-right">Neues Rezept</a>

<div class="input-group mb-3 w-50">
  <div class="input-group-prepend">
    <span class="input-group-text"><i class="fas fa-search"></i></span>
  </div>
  <input type="text" class="form-control" placeholder="suchen..." id="search-recipes">
  <div class="input-group-append">
    <button class="fas fa-times p-2 pl-3 pr-3 rounded-right border-0" id="clear-search-string"></button>
  </div>
</div>


<div class="container mb-4" id="recipes">
<?php
  include $_SESSION["docroot"].'/php/classes.recipe.php';
  $book = new cookbook;

  $i=0;
  $currentLetter = "";
  foreach ($book->getRecipeNames() as $id => $name) {
    $recipeEntryClass = "rounded-lg mt-1 p-1 pl-4 text-decoration-none font-weight-bold text-light";
    if($i%2==0){$recipeEntryClass.=" bg-primary";}
    else{$recipeEntryClass.=" bg-secondary";}

    if((strtoupper(str_split($name)[0]))!=strtoupper($currentLetter)){
      $currentLetter = strtoupper(str_split($name)[0]);
      if($i!=0){
        echo '</div>';
      }
      echo '<div class="container mt-5 d-flex flex-column">';
      echo "<h2>".strtoupper($currentLetter)."</h2>";
    }
    echo "<a href='/recipe/$id' data-letter='$currentLetter' class='$recipeEntryClass'>$name</a>";
    $i++;
  }
?>
</div>