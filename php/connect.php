<?php
  include $_SESSION["docroot"].'/config/config.php';
  $mysqli = mysqli_init();
  $mysqli->real_connect(
    $CONFIG['host'],
    $CONFIG['username'],
    $CONFIG['passwd'],
    $CONFIG['database']
    3306,
    NULL,
    MYSQLI_CLIENT_SSL
  );
  $mysqli->set_charset("utf8mb4");
  if (!is_null($mysqli->connect_error))
  {
      header("Location: /error/DBConnFailed");
      exit;
  }
?>
