<?php
session_start();
include $_SESSION["docroot"].'/config/config.php';
include $_SESSION["docroot"].'/php/connect.php';

$mysqli->query('DELETE FROM `sessions` WHERE `session_id`=\''.$_COOKIE["token"].'\';');

unset($_SESSION);
session_destroy();

setcookie("token", "logout", 0, "/", "");
header("Location: /../");
?>
