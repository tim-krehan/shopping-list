<?php
session_start();
include $_SESSION["docroot"].'/config/config.php';
include $_SESSION["docroot"].'/php/connect.php';

$deleteQuery = $mysqli->prepare('DELETE FROM `sessions` WHERE `session_id`=?;');
$deleteQuery->bind_param("s", $_COOKIE["token"]);
$deleteQuery->execute();

unset($_SESSION);
session_destroy();

setcookie("token", "logout", 0, "/", "");
header("Location: /../");
?>
