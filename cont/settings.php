<link rel="stylesheet" href="/style/settings.css">
<h1>Settings</h1>
<?php
  include $_SESSION["docroot"].'/php/connect.php';
  $token = $_COOKIE["token"];
  $query = "SELECT username, email, last_login FROM `users` WHERE `uid` = (SELECT user FROM `sessions` WHERE `session_id` = \"$token\")";
  $result = $mysqli->query($query);
  $user = $result->fetch_assoc();
?>
<div class="settings">
  <h2>User</h2>
  <div class="userprofile-pane pane">
    <div class="userprofile">
      <span><font class="attribute">Benutzername</font><input class="change-attribute-input" type="text" name="username" placeholder="<?php echo $user["username"]; ?>"></span>
      <span><font class="attribute">Email</font><input class="change-attribute-input" type="text" name="username" placeholder="<?php echo $user["email"]; ?>"></span>
      <span><font class="attribute">Letzter Login</font><font><?php echo $user["last_login"]; ?></font></span>
    </div>
    <button class="button" id="saveButton">Speichern</button>
  </div>
  <div class="userpassword-pane pane">
    <div class="userpassword">
      <span><font class="attribute">Altes Passwort</font><input class="change-attribute-input" type="text" name="username" placeholder="********"></span>
      <span><font class="attribute">Neues Passwort</font><input class="change-attribute-input" type="text" name="username" placeholder="********"></span>
      <span><font class="attribute">Passwort bestätigen</font><input class="change-attribute-input" type="text" name="username" placeholder="********"></span>
    </div>
    <button class="button" id="saveButton">Speichern</button>
  </div>
  <div class="import-export-pane">
    <h2>Import / Export</h2>
    <p>Hiermit werden alle Rezepte und sich zurzeit auf der Shoppingliste befindlichen Einträge als Download zur Verfügung gestellt. Diese Datei kann dann an anderer Stelle wieder Importiert werden, oder als Backup abgespeichert werden.</p>
    <button type="button" name="export-button" class="button">Export</button>
    <p>Der Import kann benutzt werden, um alle Daten von einer exportierten Datei in diese Datenbank einzupflegen. Hierbei werden nur die Einträge in der Shoppingliste, sowie die Rezepte beachtet. Die Benutzer bleiben unberührt!</p>
    <button type="button" name="import-button" class="button">Import ...</button>
  </div>
</div>
