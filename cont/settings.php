<link rel="stylesheet" href="/style/settings.css">
<h1>Settings</h1>
<h2>User</h2>
<?php
  include $_SESSION["docroot"].'/php/connect.php';
  $token = $_COOKIE["token"];
  $query = "SELECT username, email, last_login FROM `users` WHERE `uid` = (SELECT user FROM `sessions` WHERE `session_id` = \"$token\")";
  $result = $mysqli->query($query);
  $user = $result->fetch_assoc();
?>
<div class="userprofile">
  <span><font class="attribute">Benutzername</font><input class="change-attribute-input" type="text" name="username" value="<?php echo $user["username"]; ?>"></span>
  <span><font class="attribute">Email</font><input class="change-attribute-input" type="text" name="username" value="<?php echo $user["email"]; ?>"></span>
  <span><font class="attribute">Letzter Login</font><font><?php echo $user["last_login"]; ?></font></span>
</div>
<button class="button" id="safeButton">Speichern</button>
