<?php
  if($_SERVER["REQUEST_URI"]!="/new-recipe"){
    $submitFunction = "update";
    $title = "Bearbeiten";
    $script = '<script src="/bin/edit-recipe.js" charset="utf-8"></script>';
    $additionalInput = "<input type='hidden' name='id' value=''>";
  }
  else{
    $submitFunction = "new";
    $title = "Neu";
    $script = '';
    $additionalInput = "";
  }
?>
<script src="/bin/manageRecipe.js" charset="utf-8"></script>
<script src="/bin/autocomplete.js" charset="utf-8"></script>
<?php echo $script; ?>
<div class="container mt-5">
  <h1><?php echo $title ?></h1>
</div>


<form action="/api/recipes/<?php echo $submitFunction; ?>" method="post">
  <?php echo $additionalInput; ?>

  <div class="form-group">
    <label for="recipeName">Titel</label>
    <input type="text" class="form-control" id="recipeName" name="recipeName" aria-describedby="recipeHelp" placeholder="Titel" required>
    <small id="recipeHelp" class="form-text text-muted">Titel des Rezepts, wird in der Rezepteübersicht angezeigt.</small>
  </div>

  <div class="form-group">
    <label for="recipeDuration">Dauer</label>
    <input type="number" class="form-control" id="recipeDuration" name="recipeDuration" aria-describedby="durationHelp" placeholder="30 min" min="0" step="0.1" required>
    <small id="durationHelp" class="form-text text-muted">Zubereitungszeit in Minuten.</small>
  </div>

  <div class="form-group">
    <label for="recipeDescription">Beschreibung</label>
    <textarea class="form-control" id="recipeDescription" name="recipeDescription" rows="3" rows="8" cols="80" spellcheck="true" required></textarea>
  </div>

  <label>Zutaten</label>

  <div class="ingredientRow form-group d-flex flex-row">
    <input type="number" class="form-control col-2" name="ingredient[1][Amount]" value="1" min="0" step="0.1">
    <select class="ingredientUnit col-2 ml-1 mr-1 rounded" name="ingredient[1][Unit]">
      <?php
        include $_SESSION["docroot"].'/php/classes.recipe.php';
        $unitList = new unitList;
        foreach ($unitList->units as $unit) {
          if($unit->Standard){$selected="selected";}else{$selected=NULL;}
          echo "<option value='$unit->ID' $selected>$unit->Name</option>";
        }
      ?>
    </select>

    <div class="input-group">
      <input type="text" data-apiurl="/api/recipes/auto" data-strlen="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownMenuAutocomplete-1" class="autocomplete-ingredient form-control dropdown"  name="ingredient[1][Name]" placeholder="Zutat" autocomplete="off" required>
      
      <div class="dropdown-menu" aria-labelledby="dropdownMenuAutocomplete-1">
        <button class="dropdown-item" type="button" data-value="-1">Tippen um zu suchen... </button>
      </div>

      <div class="input-group-append">
        <span class="input-group-text p-0"><button onclick="removeItem(this);" class="removeItem fas fa-trash-alt bg-transparent rounded-right border-0 p-2 pl-3 pr-3 text-danger"></button></span>
      </div>
    </div>

  </div>


  <div class="form-group">
    <button type="button" data-count="1" class="btn btn-secondary" id="addItem"><i class="fas fa-plus"></i> Zutat</button>
  </div>
  
  <div class="form-group float-right">
    <a class="btn btn-danger text-light" id="cancel">Abbrechen</a>
    <button type="submit" class="btn btn-primary">Speichern</button>
  </div>
</form>