<?php
  include $_SESSION["docroot"].'/config/config.php';
  include $_SESSION["docroot"].'/php/connect.php';
  if(!(preg_match("/error.+/", $_SERVER["REQUEST_URI"])))
  {
    # clear expired sessions from the database
    $mysqli->query('DELETE FROM `sessions` WHERE `expires` < NOW();');

    $result = $mysqli->query('SELECT * FROM `sessions` WHERE `session_id` = \''.$_COOKIE["token"].'\';');

    if($result->num_rows == 0 && (!(in_array("site", array_keys($_GET))) || $_GET["site"]!="login"))
    {
      header('Location: /login/url='.$_SERVER["REQUEST_URI"]);
    }
    $mysqli->close();
  }
?>
