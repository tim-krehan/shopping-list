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
  var cookieRegExp = new RegExp(/;?\s+newItem=(\d+)/g);
  var match = cookieRegExp.exec(cookies);
  if(match!=null){  
    var newID = match[1];
    var checkBox = $("[data-id=" + newID + "]");
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
      var color = $("[data-id='" + dataId + "'").data("color");
      
      $("[data-id='" + dataId + "'").parent().parent().removeClass("bg-danger");

      if($("[data-id='" + dataId + "'").prop("checked")){
        $("[data-id='" + dataId + "'").parent().parent().removeClass(color);
        $("[data-id='" + dataId + "'").parent().parent().addClass("bg-success");
      }
      else{
        $("[data-id='" + dataId + "'").parent().parent().removeClass("bg-success");
        $("[data-id='" + dataId + "'").parent().parent().addClass(color);
      }
    },
    error: function () {
      $("[data-id='" + dataId + "'").parent().parent().addClass("bg-danger");
      $("[data-id='" + dataId + "'").parent().parent().data("toggle", "popover");
      $("[data-id='" + dataId + "'").parent().parent().data("container", "body");
      $("[data-id='" + dataId + "'").parent().parent().data("placement", "top");
      $("[data-id='" + dataId + "'").parent().parent().data("html", true);
      $("[data-id='" + dataId + "'").parent().parent().data("trigger", "focus");
      $("[data-id='" + dataId + "'").parent().parent().data("content", "Dieses Element konnte nicht gespeichert werden.<br />Bitte die Seite Aktualisieren");
      $("[data-id='" + dataId + "'").parent().parent().attr("title", "Fehler!");
      $("[data-id='" + dataId + "'").parent().parent().popover('show');
    }
  });
}