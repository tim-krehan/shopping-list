$(document).ready(function(){
  var recipeID = window.location.href.split("/")[(window.location.href.split("/").length-1)];
  $("#FormSubmitfunction").prop("value", "update");
  $.ajax({
    type: "POST",
    url: "/php/edit-recipes.php",
    data: {
      function: "edit",
      id: recipeID
    },
    success: function(data){
      var recipe = JSON.parse(data);
      $("#FormSubmitfunction").after("<input type='hidden' name='id' value='"+recipe.ID+"'>");
      $("#RecipeFormName").val(recipe.Name);
      $("#recipeDurationInput").val(recipe.Dauer);
      $("#recipeDescription").val(recipe.Beschreibung);
      for (var i = 0; i < recipe.Zutaten.length; i++) {
        $("#ingredientLine"+(i+1)+" .ingredientAmount").val(recipe.Zutaten[i].Menge);
        $("#ingredientLine"+(i+1)+" .ingredientUnit option").filter(function(){
          return $(this).text() === recipe.Zutaten[i].Einheit;
        }).prop("selected", true);
        $("#ingredientLine"+(i+1)+" .ingredientName").val(recipe.Zutaten[i].Name);
        if(i+1<recipe.Zutaten.length){$(".addIngredient")[i].click();}
      }
    }
  });
});
