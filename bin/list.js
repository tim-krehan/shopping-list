$(document).ready(function(){
  $(".check").change(function(){
    var dataId = $(this).parent().data("id");
    $.ajax({
      type: "POST",
      url: "api/list/check",
      data: {
        id: dataId,
        status: $(this).prop("checked")
      },
      success: function(){infoPopUp("SAVED!", 100);},
      error: function(){infoPopUp("Netzwerkfehler! Bitte aktualisieren.", 100);}
    });
    if($(this).prop("checked")){$("[data-id='"+dataId+"']").addClass("checked");}
    else{$("[data-id='"+dataId+"']").removeClass("checked");}
  });
  $("#remove").click(function(){
    $.ajax({
      type: "POST",
      url: "api/list/del",
      success: function(){
        location.reload();
      }
    });
  });
  $("#nameField").focus();
  $("#anzahl").on("focus", function(){$(this).select();});
  $("#nameField").on("focus", function(){$(this).select();});
});
