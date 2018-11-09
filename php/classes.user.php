<?php
  Class user {
    public $uid, $username, $email, $last_login;
    private $salt;

    function get_info($session_id) {
      include $_SESSION["docroot"].'/php/connect.php';
      $query = "SELECT uid, username, email, last_login, salt FROM `users` WHERE `uid` = (SELECT user FROM `sessions` WHERE `session_id` = \"$session_id\")";
      $result = $mysqli->query($query);
      $user = $result->fetch_assoc();
      $this->uid = $user["uid"];
      $this->username = $user["username"];
      $this->email = $user["email"];
      $this->last_login = $user["last_login"];
      $this->salt = $user["salt"];
      $mysqli->close();
    }

    function change_password($current, $new){
      include $_SESSION["docroot"].'/php/hash.php';
      include $_SESSION["docroot"].'/php/connect.php';
      $current_pwhash = hash_password($current, $this->salt);
      $query = "SELECT `uid` FROM `users` WHERE `uid` = $this->uid AND `password` = '$current_pwhash'";
      $result = $mysqli->query($query);
      if($result->num_rows===1){
        $new_pwdhash = hash_password($new, $this->salt);
        $mysqli->query("UPDATE `users` SET `password` = '$new_pwdhash' WHERE `users`.`uid` = $this->uid;");
        $mysqli->close();
        print_r("0");
      }
      else{
        print_r("1");
      }
    }
  }
?>
