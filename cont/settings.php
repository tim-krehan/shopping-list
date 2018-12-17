<script src="/bin/settings.js" charset="utf-8"></script>
<link rel="stylesheet" href="/style/settings.css">
<h1>Settings</h1>
<?php
  include $_SESSION["docroot"].'/php/classes.user.php';
  $user = new user;
  $user->get_info($_COOKIE["token"]);
?>
<div class="settings">
  <h2>User</h2>
  <div class="userprofile-pane pane">
    <div class="userprofile">
      <span><font class="attribute">Benutzername</font><input class="change-attribute-input" id="username-input" type="text" name="username" placeholder="<?php echo $user->username; ?>"></span>
      <span><font class="attribute">Email</font><input class="change-attribute-input" id="mail-input" type="email" name="username" placeholder="<?php echo $user->email; ?>"></span>
      <span><font class="attribute">Letzter Login</font><font><?php echo $user->last_login; ?></font></span>
    </div>
    <button class="button" id="userSaveButton">Speichern</button>
  </div>
  <div class="userpassword-pane pane">
    <div class="userpassword">
      <span><font class="attribute">Altes Passwort</font><input class="change-attribute-input password-input" id="old-password-input" type="password" name="username" placeholder="********"></span>
      <span><font class="attribute">Neues Passwort</font><input class="change-attribute-input password-input" id="new-password-input" type="password" name="username" placeholder="********"></span>
      <span><font class="attribute">Passwort bestätigen</font><input class="change-attribute-input password-input" id="check-password-input" type="password" name="username" placeholder="********"></span>
    </div>
    <button class="button button-disabled" id="passwordSaveButton" disabled>Speichern</button>
  </div>
  <div class="import-export-pane">
    <h2>Import / Export</h2>
    <p>Hiermit werden alle Rezepte und sich zurzeit auf der Shoppingliste befindlichen Einträge als Download zur Verfügung gestellt. Diese Datei kann dann an anderer Stelle wieder Importiert werden, oder als Backup abgespeichert werden.</p>
    <button type="button" id="export-recipe-button" class="button">Export Rezepte</button>
    <button type="button" id="export-list-button" class="button">Export Shoppingliste</button>
    <p>Der Import kann benutzt werden, um alle Daten von einer exportierten Datei in diese Datenbank einzupflegen. Hierbei werden nur die Einträge in der Shoppingliste, sowie die Rezepte beachtet. Die Benutzer bleiben unberührt!</p>
    <button type="button" id="import-button" class="button">Import ...</button>
  </div>
</div>
