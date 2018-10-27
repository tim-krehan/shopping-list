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
  foreach($mods_enabled as $mod){
    if(!(in_array($mod, apache_get_modules()))){
      array_push($missing_mods, $mod);
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
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/master.css">
    <link rel="stylesheet" href="/style/install.css">
  </head>
  <h1>Installation</h1>
  <form class="installer" action="install_action.php" method="post">
    <label for="text_database">Datenbank-Name</label><input id="text_database" type="text" name="database" placeholder="shopping-list" autocomplete="off" required>
    <label for="text_host">Datenbank-Host</label><input id="text_dbhost" type="text" name="dbhost" placeholder="localhost" autocomplete="off" required>
    <label for="text_user">Benutzername</label><input id="text_user" type="text" name="username" placeholder="shopping-list" autocomplete="off" required>
    <label for="text_passwd">Password</label><input id="text_passwd" type="Password" name="passwd" placeholder="********" autocomplete="off" required>
    <input id="button_install" class="button" type="submit" name="" value="Installieren">
  </form>
