<?php
session_start();
include $_SESSION["docroot"].'/config/config.php';
include $_SESSION["docroot"].'/php/connect.php';
include $_SESSION["docroot"].'/php/hash.php';

$selectQuery = $mysqli->prepare('SELECT `uid`,`username`,`password`,`salt` FROM users WHERE `username`=?;');
$selectQuery->bind_param("s", $_POST['user']);
$selectQuery->execute();
$result = $selectQuery->get_result();

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

    $insertQuery = $mysqli->prepare('INSERT INTO `sessions` (`session_id`, `user`, `expires`) VALUES (?,?,?);');
    $insertQuery->bind_param("sss", $token, $userdetails["uid"], $session_expiry);
    $insertQuery->execute();

  }
  else
  {
    setcookie("token", "false", 0, "/", "");
    header("Location: /");
    exit(1);
  }
  $lastLoginDate = date("Y-m-d H:i:s");
  $updateQuery = $mysqli->prepare("UPDATE `users` SET `last_login` = ? WHERE `uid` = ?;");
  $updateQuery->bind_param("ss", $lastLoginDate, $userdetails["uid"]);
  $updateQuery->execute();
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