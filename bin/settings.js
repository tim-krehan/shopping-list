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
  $("#export-recipe-button").click(function(){
    $.post("/php/edit-recipes.php", {function:"export"}, function(data){
      downloadObjectAsJson(data, "recipes");
    });
  });
});
