<?php
session_start();
include $_SESSION["docroot"].'/php/connect.php';
include $_SESSION["docroot"].'/php/hash.php';

$salt = create_salt();
$password = hash_password($_POST["passwd"], $salt);

$result = $mysqli->query("INSERT INTO `users` (`username`, `password`, `salt`, `last_login`) VALUES ('".$_POST["username"]."', '".$password."', '".$salt."', CURRENT_TIMESTAMP);");
$mysqli->close();

unset($salt);
unset($password);
header("Location: /");
?>
