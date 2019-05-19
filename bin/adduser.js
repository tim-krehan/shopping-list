$(document).ready(function () {
    $("#newuser").click(function () {
        $.post({
            url: "/api/user/new",
            data: {
                username: $("#username").val(),
                passwd: $("#password").val()
            },
            success: function (data) {
                if (data == "0") {
                    userPopover("Erfolg!", ("Der Benutzer " + $("#username").val() + " wurde erfolgreich erstellt!<br>Wenn keine Benutzer mehr erstellt werden müssen, mit \"Fertigstellen\" bestätigen."));
                    $("#username").val("");
                    $("#password").val("");
                    $("#done").removeClass("disabled");
                }
                else{
                    userPopover("Fehler!", "Bei der Benutzeranlage ist ein Fehler aufgetreten! Bitte versuchen Sie es erneut.<br>Sollte dieser fehler häufiger auftreten, wenden Sie sich bitte an den Serveradministrator.")
                }
            },
            error: function (){
                userPopover("Fehler!", "Es scheint, als wäre keine Verbindung mit der ShoppingList möglich.<br>Bitte Prüfen Sie ihre Netzwerkverbindung!");
            }
        });
    });
    $("#adduser-button-done").click(function () {
        window.location.href = "/";
    });
});
function userPopover(title, text){
    $("#newuser").data("toggle", "popover");
    $("#newuser").data("container", "body");
    $("#newuser").data("placement", "bottom");
    $("#newuser").data("html", true);
    // $("#newuser").data("trigger", "focus");
    $("#newuser").attr("title", title);
    $("#newuser").data("content", text);
    $("#newuser").popover('show');
}
