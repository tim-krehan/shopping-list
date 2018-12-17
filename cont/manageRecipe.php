<link rel="stylesheet" href="/style/manageRecipe.css">
<script src="/bin/autocomplete.js" charset="utf-8"></script>
<script src="/bin/manageRecipe.js" charset="utf-8"></script>
<?php if($_SERVER["REQUEST_URI"]!="/new-recipe"){
  echo "<h1>Bearbeiten</h1>";
  echo "<script src=\"/bin/edit-recipe.js\" charset=\"utf-8\"></script>";
}
else{
  echo "<h1 id=\"header\">Neu</h1>";
} ?>
<form id="newRecipeForm" autocomplete="off" action="/api/recipes/new" method="post">
  <div><input id="safeRecipe" type="submit" name="" value="Speichern" class="button"> </div>
  <div><font>Name:</font><br /><input id="RecipeFormName" type="text" name="recipeName" placeholder="Name" required="required"></div>
  <div><font>Dauer (Minuten):</font><br /><input type="number" name="recipeDuration" id="recipeDurationInput" value="30"></div>
  <div><font>Beschreibung:</font><br /><textarea placeholder="Beschreibung" name="recipeDescription" id="recipeDescription" rows="8" cols="80" spellcheck="true"></textarea> </div>
  <div><font>Zutaten:</font><br />
    <div id="addIngredients" data-ingredientscount="1">
      <div class="ingredientLine" id="ingredientLine1" data-id="1">
        <input type="number" min="0" step="0.1" class="ingredientAmount" name="ingredient[1][Amount]" value="1">
        <select class="ingredientUnit" name="ingredient[1][Unit]">
          <?php
            include $_SESSION["docroot"].'/php/classes.recipe.php';
            $unitList = new unitList;
            foreach ($unitList->units as $unit) {
              if($unit->Standard){$selected="selected";}else{$selected=NULL;}
              echo "<option value='$unit->ID' $selected>$unit->Name</option>";
            }
          ?>
        </select>
        <div class="ingredientAutocomplete"><input type="text" class="ingredientName" name="ingredient[1][Name]" placeholder="Zutat" required="required"></div>
        <span class="removeIngredient">✘</span>
        <span class="addIngredient">✚</span>
      </div>
    </div>
  </div>
</form>
