<?php
  include $_SESSION["docroot"].'/config/config.php';
  $mysqli = new mysqli(
    $host = $CONFIG['host'],
    $username = $CONFIG['username'],
    $passwd = $CONFIG['passwd'],
    $database = $CONFIG['database']
  );
  if (!is_null($mysqli->connect_error))
  {
      header("Location: /error/DBConnFailed");
      exit;
  }
?>
