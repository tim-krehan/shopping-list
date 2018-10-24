<?php ?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/master.css">
    <link rel="stylesheet" href="/style/adduser.css">
</head>
<h1>Benutzer hinzufügen</h1>
<form class="adduser" action="/php/adduser_action.php" method="post">
  <label for="text_user">Benutzername</label><input id="text_user" type="text" name="username" value="" placeholder="user1" required>
  <label for="text_passwd">Passwort</label><input id="text_passwd" type="Password" name="passwd" value="" placeholder="********" required>
  <input id="button_newuser" class="button" type="submit" name="" value="Neuer Benutzer">
</form>
