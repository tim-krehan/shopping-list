<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/style/fontawesome/css/all.css">
  <link rel="stylesheet" href="/style/main.css">
  <script src="/js/jquery.js"></script>
  <script src="/js/adduser.js" charset="utf-8"></script>
  <title>Benutzer hinzufügen</title>
</head>
<body>
  <div class="container">
    <h1>Benutzer hinzufügen</h1>

    <div class="form-group">
      <label for="username">Benutzername</label>
      <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Benutzername" autocomplete="off">
      <small id="usernameHelp" class="form-text text-muted">Einen Benutzer für die ShoppingList erstellen.</small>
    </div>

    <div class="form-group">
      <label for="password">Passwort</label>
      <input type="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="**********">
      <small id="passwordHelp" class="form-text text-muted">Ihr Passwort wird verschlüsselt in der Datenbank gespeichert.</small>
    </div>

    <div class="form-group d-flex flex-row justify-content-end">
      <a id="newuser" class="btn btn-primary text-light">Neuer Benutzer</a>
      <a id="done" class="btn btn-success text-light ml-1 disabled">Fertigstellen</a>
    </div>

  </div>


  <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
