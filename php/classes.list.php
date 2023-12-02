<?php
  class item {
    public $ID, $Anzahl, $Einheit, $Name, $Erledigt;
    function __construct($ID, $Anzahl, $Einheit, $Name, $Erledigt){
      $this->ID = $ID;
      $this->Anzahl = $Anzahl;
      $this->Einheit = $Einheit;
      $this->Name = $Name;
      $this->Erledigt = $Erledigt;
    }
  }
  class shopping {
    public $list = array();
    private function addItem($ID, $Anzahl, $Einheit, $Name, $Erledigt){
      $current = new item($ID, $Anzahl, $Einheit, $Name, $Erledigt);
      array_push($this->list, $current);
    }

    function __construct(){
      include $_SESSION["docroot"].'/config/config.php';
      include $_SESSION["docroot"].'/php/connect.php';
      $result = $mysqli->query("SELECT * FROM `ViewEinkauf` ORDER BY `ViewEinkauf`.`Name` ASC;");
      while($item = $result->fetch_assoc()){
        $this->addItem($item["ID"], $item["Anzahl"], $item["Einheit"], $item["Name"], $item["Erledigt"]);
      }
      $mysqli->close();
    }

    function newItem($anzahl, $einheit, $name){
      include $_SESSION["docroot"].'/config/config.php';
      include $_SESSION["docroot"].'/php/connect.php';
      if(!is_int($einheit)){
        $selectQuery = $mysqli->prepare("SELECT * FROM `Einheit` WHERE `Name` = ?;");
        $selectQuery->bind_param("s", $einheit);
        $selectQuery->execute();
        $result = $selectQuery->get_result();
        while($row = $result->fetch_assoc()){
          $einheit = $row["ID"];
        }
      }
      $insertQuery = $mysqli->prepare("INSERT INTO `Einkauf` (`Anzahl`, `Einheit`, `Name`, `Erledigt`) VALUES (?, ?, ?, 0);");
      $insertQuery->bind_param("sss", $anzahl, $einheit, $name);
      $result = $insertQuery->execute();
      $insertID = $mysqli->insert_id;
      $mysqli->close();
      return $insertID;
    }

    function newItems($itemList){
      foreach ($itemList as $item) {
        $this->newItem($item["amount"], $item["unit"], $item["name"]);
      }
    }

    function removeSingleItem($id){
      include $_SESSION["docroot"].'/config/config.php';
      include $_SESSION["docroot"].'/php/connect.php';
      $deleteQuery = $mysqli->prepare("DELETE FROM `Einkauf` WHERE `Einkauf`.`ID` = ?;");
      $deleteQuery->bind_param("s", $id);
      $deleteQuery->execute();
      $mysqli->close();
    }

    function changeSingleItem($id, $anzahl, $einheit, $name){
      include $_SESSION["docroot"].'/config/config.php';
      include $_SESSION["docroot"].'/php/connect.php';
      $paramCount = "s";
      $query = "UPDATE `Einkauf` SET";
      if($anzahl!=""){
        $paramCount .= "s";
        $query .= " `Anzahl` = ?";
      }
      if($einheit!=""){
        if(strlen($paramCount)>1){
          $query .= ",";
        }
        $paramCount .= "s";
        $query .= " `Einheit` = ?";
      }
      if($name!=""){
        if(strlen($paramCount)>1){
          $query .= ",";
        }
        $paramCount .= "s";
        $query .= " `Name` = ?";
      }
      if(strlen($paramCount)>1){
        $query .= " WHERE `Einkauf`.`ID` = ?;";
        $updateQuery = $mysqli->prepare($query);
        if($anzahl!="" && $name!=""){
          $updateQuery->bind_param($paramCount, $anzahl, $einheit, $name, $id);
        }
        elseif($anzahl!="" && $name==""){
          $updateQuery->bind_param($paramCount, $anzahl, $einheit, $id);
        }
        elseif($anzahl=="" && $name!=""){
          $updateQuery->bind_param($paramCount, $einheit, $name, $id);
        }
        elseif($anzahl=="" && $name==""){
          $updateQuery->bind_param($paramCount, $einheit, $id);
        }
        $updateQuery->execute();
        $mysqli->close();
      }
    }

    function removeChecked(){
      include $_SESSION["docroot"].'/config/config.php';
      include $_SESSION["docroot"].'/php/connect.php';
      $mysqli->query("DELETE FROM `Einkauf` WHERE `Erledigt`=1;");
      $mysqli->close();
    }

    function check($id, $status){
      include $_SESSION["docroot"].'/config/config.php';
      include $_SESSION["docroot"].'/php/connect.php';
      $updateQuery = $mysqli->prepare("UPDATE `Einkauf` SET `Erledigt` = $status WHERE `Einkauf`.`ID` = ?;");
      $updateQuery->bind_param("s", $id);
      $updateQuery->execute();
      $mysqli->close();
    }

    function import(){
      $import = json_decode($_POST["content"]);
      $units = new units();
      foreach($import->list as $item){
        $this->newItem($item->Anzahl, $units->getID($item->Einheit), $item->Name);
      }
      print_r("0");
    }
  }

  class unit {
    public $ID, $Name, $Standard;
    function __construct($ID, $Name, $Standard){
       $this->ID = $ID;
       $this->Name = $Name;
       $this->Standard = $Standard;
    }
  }
  class units {
    public $list = array();
    private function addItem($ID, $Name, $Standard){
      $current = new unit($ID, $Name, $Standard);
      array_push($this->list, $current);
    }

    function __construct(){
      include $_SESSION["docroot"].'/config/config.php';
      include $_SESSION["docroot"].'/php/connect.php';
      $result = $mysqli->query("SELECT * FROM `Einheit`;");
      while($item = $result->fetch_assoc()){
        $this->addItem($item["ID"], $item["Name"], $item["Standard"]);
      }
      $mysqli->close();
    }

    function getID($Name){
      foreach($this->list as $units){
        if($units->Name==$Name){
          return $units->ID;
        }
      }
    }
  }
?>
