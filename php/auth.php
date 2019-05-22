<?php
  include $_SESSION["docroot"].'/config/config.php';
  include $_SESSION["docroot"].'/php/connect.php';
  if(!(preg_match("/error.+/", $_SERVER["REQUEST_URI"])))
  {
    # clear expired sessions from the database
    $mysqli->query('DELETE FROM `sessions` WHERE `expires` < NOW();');

    if(isset($_COOKIE["token"])){
      $token = $_COOKIE["token"];
    }
    else{
      $token = "-1";
    }

    $selectQuery = $mysqli->prepare('SELECT * FROM `sessions` WHERE `session_id` = ?;');
    $selectQuery->bind_param("s", $token);
    $selectQuery->execute();
    $result = $selectQuery->get_result();

    if(($result->num_rows) == 0 && (!(in_array("site", array_keys($_GET))) || $_GET["site"]!="login"))
    {
      header('Location: /login/url='.$_SERVER["REQUEST_URI"]);
    }
    $mysqli->close();
  }
?>
