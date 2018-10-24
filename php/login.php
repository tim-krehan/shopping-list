<?php
session_start();
include $_SESSION["docroot"].'/config/config.php';
include $_SESSION["docroot"].'/php/connect.php';
include $_SESSION["docroot"].'/php/hash.php';


$query = 'SELECT `uid`,`username`,`password`,`salt` FROM users WHERE `username`=\''.$_POST['user'].'\';';
$result = $mysqli->query($query);

if ($result->num_rows == 1)
{
  $userdetails = $result->fetch_assoc();
  if ($userdetails["password"] == hash_password($_POST['pass'], $userdetails["salt"]))
  {
    $token = create_salt(26);
    

    if(isset($_POST["rememberme"]))
    {
      setcookie("token", $token, (time()+2592000), "/", "");
      $session_expiry = date('Y-m-d H:i:s', time()+2592000);
    }
    else 
    {
      setcookie("token", $token, 0, "/", "");
      $session_expiry = date('Y-m-d H:i:s', time()+86400);
    }

    $mysqli->query('INSERT INTO `sessions` (`session_id`, `user`, `expires`) VALUES (\''.$token.'\', \''.$userdetails["uid"].'\', \''.$session_expiry.'\'); ');

  }
    $mysqli->query('UPDATE `users` SET `last_login` = \''.date("Y-m-d H:i:s").'\'  WHERE `uid` = \''.$userdetails["uid"].'\';');
    $mysqli->close();
    header("Location: ".$_POST["refurl"]);
    exit(0);
}
else
{
  setcookie("token", "false", 0, "/", "");
  header("Location: /");
  exit(1);
}
?>
