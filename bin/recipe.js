$(document).ready(function(){
  $("#editingMenu").click(function(){
    $(this).css("display", "none");
    $("#editingMenuOpen").css("transform", "translate(0, 0)");
  });
  $("#closeMenue").click(function(){
    $("#editingMenu").css("display", "block");
    $(this).parent().css("transform", "translate(0, -12em)");
  });
  $("#edit-recipe").click(function(){
    window.location.href = "/edit-recipe/"+$("#recipeHeader").data("recipeid");
  });
  $("#delRecipe").click(function(){
    if(!(confirm("Wirklich löschen?"))){return;}
    $.ajax({
      type: "POST",
      url: "/php/edit-recipes.php",
      data: {
        function: "del",
        id: $("#recipeHeader").data("recipeid")
      },
      success: function(data){
        window.location.href = "/recipes";
      }
    });
  });
  $(".removeIngredient").click(function(){
    if($(".removeIngredient").length>1){
      $(this).parent().remove();
    }
  });
  $(".ingredientName").focus(function(x){
    autocomplete(this, values);
  });
  $(".ingredientName").on("focus", function(){$(this).select();});
  $(".ingredientAmount").on("focus", function(){$(this).select();});
  $("#addToListButton").click(function(){
    var list = [];
    var ingredientsList = $("#ingredients").children();
    ingredientsList.each(function(){
      var amount = $(this).find(".ingredients_row_amount").html();
      var unit = $(this).find(".ingredients_row_unit").html();
      var name = $(this).find(".ingredients_row_name").html();
      list.push({amount: amount, unit: unit, name: name});
    });
    $.ajax({
      type: "POST",
      url: "/php/edit-list.php",
      data: {
        list: list,
        function: "multiple"
      },
      success: function(data){
        window.location = "/";
      }
    });
  });
});
