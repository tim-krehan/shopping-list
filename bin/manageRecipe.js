$(document).ready(function () {
  $("#addItem").click(addItem);
  $("#cancel").click(function(){window.history.back()});
  $("input[type=number]").on("focus", function () { $(this).select(); });
  $("input[type=text]").on("focus", function () { $(this).select(); });

  // $(".ingredientName").on("focus", function () {
  //   autocomplete(this, values);
  // });
  // $(".ingredientName").keydown(function (x) {
  //   if ((x.keyCode == 9) && ($(this).parent().parent().next().prop("class") != $(this).parent().parent().prop("class"))) {
  //     $(this).parent().parent().find(".addIngredient").click();
  //   }
  // });
  // $(".ingredientAmount").on("focus", function () { $(this).select(); });

});

function removeItem(elem) {
  if ($(".removeItem").length > 1) {
    $(elem).parent().parent().parent().parent().remove();
  }
  if ($(".removeItem").length == 1) {
    $(".ingredientRow").find("input[type=text]").val("");
    $(".ingredientRow").find("input[type=number]").val("1");
  }
}

function addItem() {
  var dataID = parseInt($("#addItem").data("count")) + 1;
  $("#addItem").data("count", dataID);
  
  var clone = $($(".ingredientRow")[0]).clone();

  clone.find("input[type=text]").attr("name", ("ingredient[" + dataID + "][Name]"));
  clone.find("input[type=text]").val("");
  clone.find("input[type=text]").on("focus", function () { $(this).select(); });
  clone.find("input[type=number]").attr("name", ("ingredient[" + dataID + "][Amount]"));
  clone.find("input[type=number]").val("1");
  clone.find("input[type=number]").on("focus", function () { $(this).select(); });
  clone.find("select").attr("name", ("ingredient[" + dataID + "][Unit]"));

  $(".ingredientRow").last().after(clone);

  clone.find("input[type=number]").focus();
}