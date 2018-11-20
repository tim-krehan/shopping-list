<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/master.css">
    <link rel="stylesheet" href="/style/adduser.css">
    <script src="/bin/jquery.js" charset="utf-8"></script>
    <script src="/bin/index.js" charset="utf-8"></script>
    <script src="/bin/adduser.js" charset="utf-8"></script>
</head>
<h1>Benutzer hinzufügen</h1>
<div class="adduser">
  <label for="text_user">Benutzername</label><input id="text_user" type="text" name="username" placeholder="user" required>
  <label for="text_passwd">Passwort</label><input id="text_passwd" type="password" name="passwd" placeholder="********" required>
  <input id="button_newuser" class="button" type="submit" name="" value="Neuer Benutzer">
</div>
<button class="button button-disabled" id="adduser-button-done">Fertig</button>

<!-- Only here in install/adduser -->
<div id="info-popup"><font id="info-popup-text"></font></div>
