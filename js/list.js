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
    var newRow = checkBox.parent().parent();
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
  row.find(".list-row-name").html("");
  row.find(".list-row-amount").append("");
  row.find(".list-row-name").append('<input type="text" class="form-control" autocomplete="off" value="'+name+'" required>');
}

function checkItem() {
  var dataId = $(this).data("id");
  $.post({
    url: "api/list/check",
    data: {
      function: "check",
      id: dataId,
      status: $(this).prop("checked")
    },
    success: function () {
      var dataIdSelector = (`[data-id='${dataId}']`);
      var color = $(dataIdSelector).data("color");
      var buttoncolor = $(dataIdSelector).data("buttoncolor");
      $(dataIdSelector).parent().parent().removeClass("bg-danger");
      $(dataIdSelector).parent().parent().find(".dropdown-menu-button").removeClass("btn-danger");

      if($(dataIdSelector).prop("checked")){
        $(dataIdSelector).parent().parent().removeClass(color);
        $(dataIdSelector).parent().parent().addClass("bg-success");
        $(dataIdSelector).parent().parent().find(".dropdown-menu-button").removeClass(buttoncolor);
        $(dataIdSelector).parent().parent().find(".dropdown-menu-button").addClass("btn-success");
      }
      else{
        $(dataIdSelector).parent().parent().removeClass("bg-success");
        $(dataIdSelector).parent().parent().addClass(color);
        $(dataIdSelector).parent().parent().find(".dropdown-menu-button").addClass(buttoncolor);
        $(dataIdSelector).parent().parent().find(".dropdown-menu-button").removeClass("btn-success");
      }
    },
    error: function () {
      $(dataIdSelector).parent().parent().addClass("bg-danger");
      $(dataIdSelector).parent().parent().data("toggle", "popover");
      $(dataIdSelector).parent().parent().data("container", "body");
      $(dataIdSelector).parent().parent().data("placement", "top");
      $(dataIdSelector).parent().parent().data("html", true);
      $(dataIdSelector).parent().parent().data("trigger", "focus");
      $(dataIdSelector).parent().parent().data("content", "Dieses Element konnte nicht gespeichert werden.<br />Bitte die Seite Aktualisieren");
      $(dataIdSelector).parent().parent().attr("title", "Fehler!");
      $(dataIdSelector).parent().parent().popover('show');
    }
  });
}