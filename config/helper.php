<?php

function get_is_installed($CONFIG) {
  $installed = false;
  // connect to database and check if tables exist
  $conn = new mysqli($CONFIG['host'], $CONFIG['username'], $CONFIG['passwd'], $CONFIG['database']);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SHOW TABLES LIKE 'Zutat'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $installed = true;
  }
  $conn->close();
  return $installed;
}

?>