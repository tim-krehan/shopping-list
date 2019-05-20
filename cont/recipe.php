<script src="/bin/recipe.js" charset="utf-8"></script>
<?php
  include $_SESSION["docroot"].'/php/classes.recipe.php';
  include $_SESSION["docroot"].'/php/classes.parsedown.php';
  $book = new cookbook;
  $book->getRecipe($_GET["number"]);
  $recipe = $book->sites[0];
?>

<div class="dropdown text-right mt-4">
  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Menü
  </button>
  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#" id="addToList"><i class="fas fa-cart-plus"></i> Zur Einkaufsliste hinzufügen</a>
    <a class="dropdown-item" href="/edit-recipe/<?php echo $recipe->ID; ?>"><i class="fas fa-edit"></i> Bearbeiten</a>
    <a class="dropdown-item" href="#" id="delRecipe"><i class="fas fa-trash-alt"></i> Löschen</a>
  </div>
</div>

<?php
  echo '<div class="container mb-5">';
    echo "<h1 data-recipeid='$recipe->ID'>$recipe->Name</h1>";
  echo '</div>';

  echo '<div class="card mw-50 mb-3">';
    echo "<div class='card-body' id='ingredients'>";
    echo "<h2 class='card-title'>Zutaten</h2>";
    foreach($recipe->Zutaten as $index => $Zutat){
      if($index%2==0){$div_item_row_color_classes="bg-primary";}
      else{$div_item_row_color_classes="bg-secondary";}
      print_r("<div class='d-flex flex-row rounded m-1 p-1 pl-3 font-weight-bold text-light $div_item_row_color_classes' data-amount='$Zutat->Menge' data-unit='$Zutat->Einheit' data-name='$Zutat->Name'>");
        print_r("<div class='p-0 col-3 d-flex flex-row'>$Zutat->Menge $Zutat->Einheit</div>");
        print_r("<div class='col-7'>$Zutat->Name</div>");
      print_r("</div>");
    }
    echo "</div>";

    echo "<div class='card-body'>";
    echo "<h2 class='card-title'>Zubereitung</h2>";
    foreach(explode("\r\n", $recipe->Beschreibung) as $paragraph){
      echo "<p>$paragraph</p>";
    }
    echo "</div>";

  echo '</div>';
?>