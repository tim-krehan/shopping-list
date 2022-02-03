$(document).ready(function () {
  $("#search-recipes").on("keyup", searchRecipe);
  $("#clear-search-string").click(clearSearchString);
});

function searchRecipe() {
  var searchString = $("#search-recipes").val().toUpperCase();
  var recipes = $("#recipes a");

  for (var i = 0; i < recipes.length; i++) {
    if (recipes[i].innerHTML.toUpperCase().indexOf(searchString) > -1) {
      $(recipes[i]).show()
    }
    else {
      $(recipes[i]).hide();
    }
  }
  
  $("#recipes").children().each(index => {
    var container = ($("#recipes").children())[index];
    $(container).removeClass("d-none").addClass("d-flex");
    if(($(container).find("a:visible")).length==0){
      $(container).removeClass("d-flex").addClass("d-none");
    }
  });

}

function clearSearchString() {
  $("#search-recipes").val("");
  $("#search-recipes").focus();
  $("#search-recipes").keyup();
}