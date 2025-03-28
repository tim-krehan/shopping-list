<?php

$CONFIG = array();

include_once $_SESSION["docroot"].'/config/helper.php';

if (getenv('DB_HOST') && getenv('DB_DATABASE') && getenv('DB_USERNAME') && getenv('DB_PASSWORD')) {
  // write to console "Using environment variables for database connection"
  $CONFIG['host'] = getenv('DB_HOST');
  $CONFIG['database'] = getenv('DB_DATABASE');
  $CONFIG['username'] = getenv('DB_USERNAME');
  $CONFIG['passwd'] = getenv('DB_PASSWORD');
  $CONFIG['installed'] = get_is_installed($CONFIG);
} else {
  $CONFIG['installed'] = false;
  $CONFIG['host'] = '';
  $CONFIG['database'] = '';
  $CONFIG['username'] = '';
  $CONFIG['passwd'] = '';
}
?>
