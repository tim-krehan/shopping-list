$(document).ready(function () {
  highlightNewEntry();
  $("input[type=checkbox]").change(checkItem);
  $("#remove").click(deleteCheckeditems);
  $("#nameField").focus();
  $("#anzahl").on("focus", function () { $(this).select(); });
  $("#nameField").on("focus", function () { $(this).select(); });
  $(".edit-listitem").click(editItem);
  $(".del-listitem").click(deleteSingleItem);
});

function highlightNewEntry(){
  var cookies = document.cookie;
  var cookieRegExp = new RegExp(/[;]{0,1}\s{0,1}newItem=(\d+)/g);
  var match = cookieRegExp.exec(cookies);
  if(match!=null){  
    var newID = match[1];
    var checkBox = $(`[data-id='${newID}']`);
    var newRow = checkBox.parent().parent().parent();
    newRow.removeClass($(checkBox).data("color"));
    newRow.addClass("alert-primary");
    setTimeout(function () {
      newRow.removeClass("alert-primary");
      newRow.addClass($(checkBox).data("color"));
    }, 1000);
    document.cookie = "newItem=-1"
  }
}

function deleteCheckeditems() {
  $.post({
    url: "api/list/clear",
    success: function () {
      location.reload();
    }
  });
}

function deleteSingleItem() {
  var id = $(this).parent().parent().parent().find("input[type=checkbox]").data("id");
  $.post({
    url: "api/list/del",
    data: {
      id: id
    },
    success: function (data) {
      location.reload();
    }
  });
}

function editItem(){
  var row = $(this).parent().parent().parent();
  var amount = row.find(".list-row-amount").data("amount");
  var unit = row.find(".list-row-amount").data("unit");
  var name = row.find(".list-row-name").html();

  row.find(".list-row-amount").html("");
  row.find(".list-row-amount").addClass("d-flex", "flex-row");
  var options = $("[data-id='new']").find("select").html();
  row.find(".list-row-amount").append(
    '<input type="number" class="form-control w-50 mr-1" step=".25" value="' + amount +'" required>'
  ).append(
    '<select class="form-control w-50 mr-1">'+options+'</select>'
  );
  row.find(".list-row-amount").find("option:selected").attr("selected", false);
  row.find(".list-row-amount").find("option:contains('"+unit+"')").attr("selected", true);

  row.find(".list-row-name").html("");
  row.find(".list-row-name").addClass("w-100");
  row.find(".list-row-name").append('<input type="text" class="form-control ml-auto" autocomplete="off" value="'+name+'" required>');

  row.find(".dropdown").html("");
  row.find(".dropdown").addClass("d-flex", "flex-row");
  var checkButton = $("<button type='button' class='save-list-row-changes btn p-2'><i class='fas fa-check'></i></button>");
  var removeButton = $("<button type='button' class='del-list-row-changes btn p-2'><i class='fas fa-times'></i></button>");
  row.find(".dropdown").append(checkButton);
  row.find(".dropdown").append(removeButton);

  checkButton.click(changeListItem);
  removeButton.click(function(){window.location = window.location;});
}

function changeListItem(){
  var id = $(this).parent().parent().find("input[type=checkbox]").data("id");
  var amount = $(this).parent().parent().find("input[type=number]").val();
  var unit = $(this).parent().parent().find("select option:selected").val();
  var name = $(this).parent().parent().find("input[type=text]").val();
  $.post({
    url: "api/list/change",
    data: {
      id: id,
      anzahl: amount,
      einheit: unit,
      name: name
    },
    success: function(data){
      window.location = window.location;
    }
  });
}

function checkItem() {
  var dataId = $(this).data("id");
  var dataIdSelector = (`[data-id='${dataId}']`);
  $.post({
    url: "api/list/check",
    data: {
      id: dataId,
      status: $(this).prop("checked")
    },
    success: function () {
      var color = $(dataIdSelector).data("color");
      $(dataIdSelector).parent().parent().parent().removeClass("bg-danger");
      $(dataIdSelector).parent().parent().parent().find(".dropdown-menu-button").removeClass("btn-danger");

      if($(dataIdSelector).prop("checked")){
        $(dataIdSelector).parent().parent().parent().removeClass(color);
        $(dataIdSelector).parent().parent().parent().addClass("bg-success");
      }
      else{
        $(dataIdSelector).parent().parent().parent().removeClass("bg-success");
        $(dataIdSelector).parent().parent().parent().addClass(color);
      }
    },
    error: function () {
      $(dataIdSelector).parent().parent().parent().addClass("bg-danger");
      $(dataIdSelector).parent().parent().parent().data("toggle", "popover");
      $(dataIdSelector).parent().parent().parent().data("container", "body");
      $(dataIdSelector).parent().parent().parent().data("placement", "top");
      $(dataIdSelector).parent().parent().parent().data("html", true);
      $(dataIdSelector).parent().parent().parent().data("trigger", "focus");
      $(dataIdSelector).parent().parent().parent().data("content", "Dieses Element konnte nicht gespeichert werden.<br />Bitte die Seite Aktualisieren");
      $(dataIdSelector).parent().parent().parent().attr("title", "Fehler!");
      $(dataIdSelector).parent().parent().parent().popover('show');
    }
  });
}