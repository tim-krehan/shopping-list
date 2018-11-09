<?php
  Class user {
    public $uid, $username, $email, $last_login;
    function user($session_id) {
      include $_SESSION["docroot"].'/php/connect.php';
      $query = "SELECT uid, username, email, last_login FROM `users` WHERE `uid` = (SELECT user FROM `sessions` WHERE `session_id` = \"$session_id\")";
      $result = $mysqli->query($query);
      $user = $result->fetch_assoc();
      $this->uid = $user["uid"];
      $this->username = $user["username"];
      $this->email = $user["email"];
      $this->last_login = $user["last_login"];
    }
  }
?>
