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
      $result = $mysqli->query("SELECT * FROM `ViewEinkauf` ORDER BY `ViewEinkauf`.`Name` ASC");
      while($item = $result->fetch_assoc()){
        $this->addItem($item["ID"], $item["Anzahl"], $item["Einheit"], $item["Name"], $item["Erledigt"]);
      }
      $mysqli->close();
    }

    function newItem($anzahl, $einheit, $name){
      include $_SESSION["docroot"].'/config/config.php';
      include $_SESSION["docroot"].'/php/connect.php';
      if(!is_int($einheit)){
        $unit_query = "SELECT * FROM `Einheit` WHERE `Name` = \"$einheit\"";
        $result = $mysqli->query($unit_query);
        while($row = $result->fetch_assoc()){
          $einheit = $row["ID"];
        }
      }
      $insertQuery = "INSERT INTO `Einkauf` (`Anzahl`, `Einheit`, `Name`, `Erledigt`) VALUES (".$anzahl.", ".$einheit.", '".$name."', 0)";
      $mysqli->query($insertQuery);
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
      $mysqli->query("DELETE FROM `Einkauf` WHERE `Erledigt`=1");
      $mysqli->close();
    }

    function check($id, $status){
      include $_SESSION["docroot"].'/config/config.php';
      include $_SESSION["docroot"].'/php/connect.php';
      $mysqli->query("UPDATE `Einkauf` SET `Erledigt` = $status WHERE `Einkauf`.`ID` = $id");
      $mysqli->close();
    }

    function import(){
      $import = json_decode($_POST["content"]);
      $units = new units();
      foreach($import->list as $item){
        $this->newItem($item->Anzahl, $units->getID($item->Einheit), $item->Name);
      }
      print_f("0");
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
      $result = $mysqli->query("SELECT * FROM `Einheit`");
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
