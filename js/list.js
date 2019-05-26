$(document).ready(function () {
  highlightNewEntry();
  $("input[type=checkbox]").change(checkItem);
  $("#remove").click(deleteCheckeditems);
  $("#nameField").focus();
  $("#anzahl").on("focus", function () { $(this).select(); });
  $("#nameField").on("focus", function () { $(this).select(); });
});

function highlightNewEntry(){
  var cookies = document.cookie;
  var cookieRegExp = new RegExp(/[;]{0,1}\s{0,1}newItem=(\d+)/g);
  var match = cookieRegExp.exec(cookies);
  console.log(cookies);
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
    url: "api/list/del",
    data: {
      function: "del"
    },
    success: function () {
      location.reload();
    }
  });
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
      $(dataIdSelector).parent().parent().removeClass("bg-danger");

      if($(dataIdSelector).prop("checked")){
        $(dataIdSelector).parent().parent().removeClass(color);
        $(dataIdSelector).parent().parent().addClass("bg-success");
      }
      else{
        $(dataIdSelector).parent().parent().removeClass("bg-success");
        $(dataIdSelector).parent().parent().addClass(color);
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