$(document).ready(function(){
  var recipes = $("#recipes a");
  var headerLetters = $("#recipes h2");
  $("#search-recipes").on("keyup", searchRecipe(recipes, headerLetters));
  $("#clear-search-string").click(clearSearchString);
});

function searchRecipe(recipes, headerLetters) {
  return function () {
    var search = $("#search-recipes").val().toUpperCase();
    for (var i = 0; i < recipes.length; i++) {
      if (recipes[i].innerHTML.toUpperCase().indexOf(search) > -1) {
        recipes[i].style.display = "";
      }
      else {
        recipes[i].style.display = "none";
      }
    }
    for (var j = 0; j < headerLetters.length; j++) {
      if (($("*[data-letter='" + headerLetters[j].innerHTML + "']:visible")).length > 0) {
        headerLetters[j].style.display = "";
      }
      else {
        headerLetters[j].style.display = "none";
      }
    }
  };
}

function clearSearchString(){
  $("#search-recipes").val("");
  $("#search-recipes").focus();
  $("#search-recipes").keyup();
}