$(document).ready(function(){
  $("#delRecipe").click(removeRecipe);
  $("#addToList").click(addToList);
});

function addToList() {
  var list = [];
  var ingredientsList = $("#ingredients").children();
  ingredientsList.each(function () {
    if ($(this).data("unit") != null) {
      var amount = $(this).data("amount");
      var unit = $(this).data("unit");
      var name = $(this).data("name");
      list.push({ amount: amount, unit: unit, name: name });
    }
  });
  $.post({
    url: "/api/list/multiple",
    data: {
      list: list,
      function: "multiple"
    },
    success: function () {
      window.location = "/";
    }
  });
}

function removeRecipe() {
  if (!(confirm("Wirklich löschen?"))) { return; }
  $.post({
    url: "/api/recipes/del",
    data: {
      id: $("[data-recipeid]").data("recipeid")
    },
    success: function () {
      window.location.href = "/recipes";
    }
  });
}

