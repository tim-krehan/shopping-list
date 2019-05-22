<?php
  class item {
    public $ID, $Anzahl, $Einheit, $Name, $Erledigt;
    function item($ID, $Anzahl, $Einheit, $Name, $Erledigt){
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

    function shopping(){
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
      $mysqli->close();
    }

    function newItems($itemList){
      foreach ($itemList as $item) {
        $this->newItem($item["amount"], $item["unit"], $item["name"]);
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
    function unit($ID, $Name, $Standard){
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

    function units(){
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
