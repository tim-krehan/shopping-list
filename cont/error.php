<!DOCTYPE html>
<html>
<head>
    <title>Installationsfehler</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/js/error.js" charset="utf-8"></script>
</head>
<body>
  <div class="container">
    <div class="card border-danger mt-5">
      <div class="card-body">
        <h2 class="card-title">ACHTUNG</h2>
        <h3 class="card-subtitle">Es ist ein Fehler aufgetreten!</h3>
      </div>
      <div class="card-body">
<?php
  switch ($_GET["id"]) {
    case 'ConfigFolderReadOnly':
      echo "<p class='card-text'>Das Installationsskript kann keine Konfigurationdatei im Konfigurationsordner erstellen.</p>";
      echo "<p class='card-text'>Bitte achten Sie darauf, dass es dem Webserver erlaubt ist, Dateien im <code>config</code>-Ordner zu erstellen.</p>";
      break;
    case 'ConfigReadOnly':
      echo "<p class='card-text'>Das Installationsskript kann die Konfigurationdatei im Konfigurationsordner nicht bearbeiten.</p>";
      echo "<p class='card-text'>Bitte achten Sie darauf, dass es dem Webserver erlaubt ist, Dateien im <code>config</code>-Ordner zu bearbeiten.</p>";
      break;
    case 'DBConnFailed':
      echo "<p class='card-text'>Die Shoppingliste konnte nicht auf die Datenbank zugreifen.</p>";
      echo "<p class='card-text'>Vielleicht sind die Datenbank-Zugangsdaten falsch?</p>";
      echo "<p class='card-text'>Diese können entweder bei der Installation, oder im <code>config</code> Ordner angegeben werden.</p>";
      break;
    case 'php_modules':
      echo "<p class='card-text'>Für die vollständige Funktionsweiße fehlt folgende(s) Modul(e):</p><ul>";
      foreach(unserialize($_GET["missing_mods"]) as $mod){
        echo "<li>".$mod."</li>";
      }
      echo "</ul>";
      echo "<p class='card-text'>Bitte informieren Sie den Administrator des Webservers.</p>";
      break;
    case "UserCreationNotAllowed":
      echo "<p class='card-text'>Das Erstellen von Benutzern ist nicht erlaubt.</p>";
      echo "<p class='card-text'>Für die Useranlage muss eine Datei NEW_USERS_ALLOWED im config Verzeichnis existieren.</p>";
      break;
    default:
      echo "<p class='card-text'>Unbekannter Fehler</p>";
      break;
  }
?>
        
      </div>
    </div>
  </div>
  <center>


    <br><br>
    <p><button class="button" id="backButton">Zurück</button></p>
  </center>
</body>
</html>
