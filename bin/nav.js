$(document).ready(function(){
  $("#navigation nav font").click(function(){
    window.location.href = "/"+$(this).data("url");
  });
  $('#burgerMenue').click(function(){
    $(this).toggleClass('open');
    if(!($("#navigation").data("open"))){
      $("#navigation").css("left", "0");
      $("#navigation").data("open", true);
    }
    else if($("#navigation").data("open")){
      $("#navigation").css("left", "100%");
      $("#navigation").data("open", false);}
  });
  $("#logout").click(function(){
    window.location.href = "/php/logout.php";
  });
  $("#settings").click(function(){
    window.location.href = "/settings";
  });
});
