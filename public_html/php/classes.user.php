<?php
  Class user {
    public $uid, $username, $email, $theme, $last_login;
    private $salt;

    function get_info($session_id) {
      include $_SESSION["docroot"].'/php/connect.php';
      $selectQuery = $mysqli->prepare("SELECT uid, username, email, theme, last_login, salt FROM `users` WHERE `uid` = (SELECT user FROM `sessions` WHERE `session_id` = ?);");
      $selectQuery->bind_param("s", $session_id);
      $selectQuery->execute();
      $result = $selectQuery->get_result();
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
      $selectQuery = $mysqli->prepare("SELECT `uid` FROM `users` WHERE `uid` = ? AND `password` = ?;");
      $selectQuery->bind_param("ss", $this->uid, $current_pwhash);
      $selectQuery->execute();
      $result = $selectQuery->get_result();
      if($result->num_rows===1){
        $new_pwdhash = hash_password($new, $this->salt);
        $updateQuery = $mysqli->prepare("UPDATE `users` SET `password` = ? WHERE `users`.`uid` = ?;");
        $updateQuery->bind_param("ss", $new_pwdhash, $this->uid);
        $updateQuery->execute();
        $mysqli->close();
        print_r("0");
      }
      else{
        print_r("1");
      }
    }

    function change_mail($mailaddress){
      include $_SESSION["docroot"].'/php/connect.php';
      $this->mail = $mailaddress;
      $updateQuery = $mysqli->prepare("UPDATE `users` SET `email` = ? WHERE `users`.`uid` = ?;");
      $updateQuery->bind_param("ss", $mailaddress, $this->uid);
      $updateQuery->execute();
      $mysqli->close();
    }

    function change_username($newname){
      include $_SESSION["docroot"].'/php/connect.php';
      $this->username = $newname;
      $selectQuery = $mysqli->prepare("SELECT * FROM `users` WHERE `username` =  ?;");
      $selectQuery->bind_param("s", $this->username);
      $selectQuery->execute();
      $result = $selectQuery->get_result();
      if($result->num_rows==0){
        $updateQuery = $mysqli->prepare("UPDATE `users` SET `username` = ? WHERE `users`.`uid` = ?;");
        $updateQuery->bind_param("ss", $newname, $this->uid);
        $updateQuery->execute();
        print_r("0");
      }
      else{
        print_r("1");
      }
      $mysqli->close();
    }

    function change_theme($theme){
      include $_SESSION["docroot"].'/php/connect.php';
      $updateQuery = $mysqli->prepare("UPDATE `users` SET `theme` = ? WHERE `users`.`uid` = ?;");
      $updateQuery->bind_param("ss", $theme, $this->uid);
      $updateQuery->execute();
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
      
      $selectQuery = $mysqli->prepare("SELECT `uid` FROM `users` WHERE `username` = ?;");
      $selectQuery->bind_param("s", $uname);
      $selectQuery->execute();
      $result = $selectQuery->get_result();
      if($result->num_rows==0){
        $salt = create_salt();
        $passhash = hash_password($password, $salt);
        $insertQuery = $mysqli->prepare("INSERT INTO `users` (`username`, `password`, `salt`, `last_login`) VALUES (?, ?, ?, CURRENT_TIMESTAMP);");
        $insertQuery->bind_param("sss", $uname, $passhash, $salt);
        $insertQuery->execute();
        $result = $insertQuery->get_result();
        unset($salt);
        unset($password);
        
        $selectQuery = $mysqli->prepare("SELECT count(*) AS \"count\" FROM `users`;");
        $selectQuery->execute();
        $result = $selectQuery->get_result();
        if($result["count"] === 1){
          $CONFIG["first_launch"] = false;
          file_put_contents(
            $_SESSION["docroot"].'/config/config.php',
            '<?php '."\r\n".'$CONFIG = '.var_export($CONFIG, true).";\n\r?>"
          );
        }
        
        print_r(0);
      }
      else{print_r(1);}
      $mysqli->close();
    }
  }
?>
