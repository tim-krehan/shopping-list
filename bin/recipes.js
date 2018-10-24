$(document).ready(function(){
  $("#recipes font").click(function(){
    window.location.href = "/recipe/"+$(this).data("id");
  });
  $("#new-recipe").click(function(){
    window.location.href = "new-recipe";
  });
});
