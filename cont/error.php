<!DOCTYPE html>
<html>
<head>
    <title>Installationsfehler</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/bin/error.js" charset="utf-8"></script>
    <link rel="stylesheet" href="/style/master.css">
    <link rel="stylesheet" href="/style/error.css">
</head>
<body>
  <center>
    <br>
    <h1>ACHTUNG</h1><br>
    <br>

    Es ist folgender Fehler aufgetreten:
    <br><br>

<?php
switch ($_GET["id"]) {
     case 'ConfigFolderReadOnly':
        echo "Das Installationsskript kann keine Konfigurationdatei im Konfigurationsordner erstellen.<br>Bitte achten Sie darauf, dass es dem Webserver erlaubt ist, Dateien im <code>config</code>-Ordner zu erstellen.";
        break;
     case 'ConfigReadOnly':
        echo "Das Installationsskript kann die Konfigurationdatei im Konfigurationsordner nicht bearbeiten.<br>Bitte achten Sie darauf, dass es dem Webserver erlaubt ist, Dateien im <code>config</code>-Ordner zu bearbeiten.";
        break;
    case 'DBConnFailed':
        echo "Die Shoppingliste konnte nicht auf die Datenbank zugreifen.<br>Vielleicht sind die Datenbank-Zugangsdaten falsch?<br><br>Diese können entweder bei der Installation, oder im <code>config</code> Ordner verändert werden.";
        break;
    case 'php_modules':
        echo "Für die vollständige Funktionsweiße fehlt folgendes Modul: <br><code>";
        foreach(unserialize($_GET["missing_mods"]) as $mod){
          echo "<br>".$mod;
        }
        echo "</code><br><br>Bitte informieren Sie den Administrator des Webservers.";
        break;
     default:
        echo "Unbekannter Fehler";
        break;
 }
?>
    <br><br>
    <p><button class="button" id="backButton">Zurück</button></p>
  </center>
</body>
</html>
