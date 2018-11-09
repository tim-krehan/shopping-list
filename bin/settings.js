function downloadObjectAsJson(exportObj, exportName){
  var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(exportObj));
  var downloadAnchorNode = document.createElement('a');
  downloadAnchorNode.setAttribute("href",     dataStr);
  downloadAnchorNode.setAttribute("download", exportName + ".json");
  document.body.appendChild(downloadAnchorNode); // required for firefox
  downloadAnchorNode.click();
  downloadAnchorNode.remove();
}
$(document).ready(function(){
  $("#username-input").focus(function(){$(this).css("color", "black");});
  $("#mail-input").focus(function(){$(this).css("color", "black");});

  // change password
  $("#old-password-input").focus(function(){$(this).css("color", "black");});
  $("#new-password-input").focus(function(){$(this).css("color", "black");});
  $("#check-password-input").focus(function(){$(this).css("color", "black");});
  $(".password-input").on("input", function(){
    if(
      (($("#old-password-input").val()).length>0) &&
      (($("#new-password-input").val()).length>0) &&
      (($("#check-password-input").val()).length>0) &&
      ($("#new-password-input").val()==$("#check-password-input").val())
    ){
      $("#passwordSaveButton").prop("disabled", false);
      $("#passwordSaveButton").removeClass("button-disabled");
    }
    else{
      $("#passwordSaveButton").prop("disabled", true);
      $("#passwordSaveButton").addClass("button-disabled");
    }
  });
  $("#passwordSaveButton").click(function(){
    $.post("/php/edit-user.php",
      {
        function: "change-pw",
        current: $("#old-password-input").val(),
        new: $("#new-password-input").val()
      },
      function(data){
        if(data==0){
          $("#old-password-input").val("");
          $("#new-password-input").val("");
          $("#check-password-input").val("");
          infoPopUp("Passwort erfolgreich geändert!");
        }
        else {
          infoPopUp("Altes Passwort Falsch!");
        }
      }
    );
  });

  $("#export-recipe-button").click(function(){
    $.post("/php/edit-recipes.php", {function:"export"}, function(data){
      downloadObjectAsJson(JSON.parse(data), "recipes");
    });
  });
  $("#export-list-button").click(function(){
    $.post("/php/edit-list.php", {function:"export"}, function(data){
      downloadObjectAsJson(JSON.parse(data), "list");
    });
  });
});
