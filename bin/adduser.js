$(document).ready(function(){
  $("#button_newuser").click(function(){
    $.post("/api/user/new",
      {
        username: $("#text_user").val(),
        passwd: $("#text_passwd").val()
      },
      function(data){
        if(data=="0"){
          infoPopUp("Benutzer erfolgreich erstellt!", 100);
          $("#text_user").val("");
          $("#text_passwd").val("");
          $("#adduser-button-done").removeClass("button-disabled");
        }
        else {
          infoPopUp("Fehler bei der Benutzeranlage!", 100);
        }
      }
    );
  });
  $("#adduser-button-done").click(function(){
    window.location.href = "/";
  });
});
