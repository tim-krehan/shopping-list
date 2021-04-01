$(document).ready(function () {
  var recipeID = window.location.href.split("/")[(window.location.href.split("/").length - 1)];
  $.post({
    url: "/api/recipes/edit",
    data: {
      id: recipeID
    },
    success: function (data) {
      var recipe = JSON.parse(data);
      $("[name=id]").val(recipe.ID);
      $("#recipeName").val(recipe.Name);
      $("#recipeDuration").val(recipe.Dauer);
      $("#recipeDescription").summernote('code', recipe.Beschreibung);
      for (var i = 1; i <= recipe.Zutaten.length; i++) {
        $((".ingredientRow input[name='ingredient[" + i + "][Amount]']")).val(recipe.Zutaten[(i - 1)].Menge);
        $((".ingredientRow input[name='ingredient[" + i + "][Name]']")).val(recipe.Zutaten[(i - 1)].Name);
        $((".ingredientRow select[name='ingredient[" + i + "][Unit]'] option")).filter(function () {
          return $(this).text() === recipe.Zutaten[(i - 1)].Einheit;
        }).prop("selected", true);
        if (i + 1 <= recipe.Zutaten.length) { $("#addItem").click(); }
      }
    }
  });
});
