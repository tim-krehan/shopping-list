<?php
  Class user {
    public $uid, $username, $email, $theme, $last_login;
    private $salt;

    function get_info($session_id) {
      include $_SESSION["docroot"].'/php/connect.php';
      $query = "SELECT uid, username, email, theme, last_login, salt FROM `users` WHERE `uid` = (SELECT user FROM `sessions` WHERE `session_id` = \"$session_id\")";
      $result = $mysqli->query($query);
      $user = $result->fetch_assoc();
      $this->uid = $user["uid"];
      $this->username = $user["username"];
      $this->email = $user["email"];
      $this->theme = $user["theme"];
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

    function change_theme($theme){
      include $_SESSION["docroot"].'/php/connect.php';
      $result = $mysqli->query("UPDATE `users` SET `theme` = '$theme' WHERE `users`.`uid` = $this->uid;");
      if($result){
        print_r("0");
      }
      else{
        print_r("1");
      }
    }

    function new($uname, $password){
      include $_SESSION["docroot"].'/php/connect.php';
      include $_SESSION["docroot"].'/php/hash.php';

      $query = "SELECT `uid` FROM `users` WHERE `username` = '$uname'";
      $result = $mysqli->query($query);
      if($result->num_rows==0){
        $salt = create_salt();
        $passhash = hash_password($password, $salt);
        $query = "INSERT INTO `users` (`username`, `password`, `salt`, `last_login`) VALUES ('$uname', '$passhash', '$salt', CURRENT_TIMESTAMP);";
        $result = $mysqli->query($query);
        unset($salt);
        unset($password);
        print_r(0);
      }
      else{print_r(1);}
      $mysqli->close();
    }
  }
?>
