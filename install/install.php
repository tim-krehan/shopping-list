<?php
  session_start();
  if (!($_SESSION["docroot"]))
  {
     $_SESSION["docroot"] = str_replace("/install", "", __DIR__);
  }

  header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
  header("Pragma: no-cache"); // HTTP 1.0.
  header("Expires: 0"); // Proxies.
  include $_SESSION["docroot"].'/config/config.php';

  $mods_enabled = array("mod_rewrite");
  $missing_mods = array();
  if(function_exists("apache_get_modules")){
    $apache_mods = apache_get_modules();
    foreach($mods_enabled as $mod){
      if(!(in_array($mod, $apache_mods))){
        array_push($missing_mods, $mod);
      }
    }
  }

  if(!(class_exists('mysqli'))){ #php-mysql not installed
      array_push($missing_mods, "mysql");
  }

  if(sizeof($missing_mods)>0){
    header("Location: /cont/error.php?id=php_modules&missing_mods=".serialize($missing_mods));
  }

  if($CONFIG["installed"]==true){
    header("Location: /");
    exit;
  }
?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/fontawesome/css/all.css">
    <link rel="stylesheet" href="/style/main.css">
    <script src="/js/jquery.js"></script>
  </head>
  <body>

    <div class="container">
      <h1>Installation</h1>
      <form action="install_action.php" method="post">
        <div class="form-group">
          <label for="databaseHost">Datenbankhost</label>
          <input type="text" name="dbhost" class="form-control" id="databaseHost" aria-describedby="databaseHostHelp" placeholder="localhost" autocomplete="off" required>
          <small id="databaseHostHelp" class="form-text text-muted">Der Host, auf dem die Datenbank läuft.</small>
        </div>
        
        <div class="form-group">
          <label for="databaseName">Datenbankname</label>
          <input type="text" name="database" class="form-control" id="databaseName" aria-describedby="databaseNameHelp" placeholder="shopping-list" autocomplete="off" required>
          <small id="databaseNameHelp" class="form-text text-muted">Der Name der Datenbank.</small>
        </div>
        
        <div class="form-group">
          <label for="username">Benutzername</label>
          <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="shopping-user" autocomplete="off" required>
          <small id="usernameHelp" class="form-text text-muted">Der Benutzer mit Rechten auf die Datenbank.</small>
        </div>
        
        <div class="form-group">
          <label for="passwd">Passwort</label>
          <input type="password" name="passwd" class="form-control" id="passwd" aria-describedby="passwdHelp" placeholder="********" autocomplete="off" required>
          <small id="passwdHelp" class="form-text text-muted">Passwort für den Datenbankbenutzer.</small>
        </div>

        <button type="submit" class="btn btn-primary">Installieren</button>

      </form>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
