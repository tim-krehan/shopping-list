$(document).ready(function(){
  $("#button_newuser").click(function(){
    $.post("/php/edit-user.php",
      {
        function: "new-user",
        username: $("#text_user").val(),
        passwd: $("#text_passwd").val()
      },
      function(data){
        if(data==0){
          infoPopUp("Benutzer erfolgreich erstellt!");
          $("#text_user").val("");
          $("#text_passwd").val("");
          $("#adduser-button-done").removeClass("button-disabled");
        }
        else {
          infoPopUp("Fehler bei der Benutzeranlage!");
        }
      }
    );
  });
  $("#adduser-button-done").click(function(){
    window.location.href = "/";
  });
});
