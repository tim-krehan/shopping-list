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
      url: "/api/recipes/del",
      data: {
        id: $("#recipeHeader").data("recipeid")
      },
      success: function(data){
        window.location.href = "/recipes";
      }
    });
  });
  $(".addIngredient").click(function(x){
    var dataID = parseInt($("#addIngredients").data("ingredientscount"))+1;
    $("#addIngredients").data("ingredientscount", dataID);
    clone = $(this).parent().clone(true);
    clone.attr("data-id", dataID);
    clone.attr("id", ("ingredientLine"+dataID));
    clone.find(".ingredientAmount").prop("name", ("ingredient["+dataID+"][Amount]"));
    clone.find(".ingredientUnit").prop("name", ("ingredient["+dataID+"][Unit]"));
    clone.find(".ingredientName").prop("name", ("ingredient["+dataID+"][Name]"));
    clone.find(".ingredientAmount").val(1);
    clone.find(".ingredientUnit").children()[4].setAttribute("selected", true);
    clone.find(".ingredientName").val("");
    clone.appendTo($(this).parent().parent());
    if(x.originalEvent){
      clone.find(".ingredientAmount").focus();
    }
  });
  $(".removeIngredient").click(function(){
    if($(".removeIngredient").length>1){
      $(this).parent().remove();
    }
  });
  $(".ingredientName").on("focus", function(x){
    autocomplete(this, values);
  });
  $(".ingredientName").on("focus", function(){$(this).select();});
  $(".ingredientName").keydown(function(x){
    if((x.keyCode==9)&&($(this).parent().parent().next().prop("class")!=$(this).parent().parent().prop("class"))){
      $(this).parent().parent().find(".addIngredient").click();
    }
  });
  $(".ingredientAmount").on("focus", function(){$(this).select();});
});
