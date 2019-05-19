<?php
  class unit {
    public $ID, $Name, $Standard;
  }
  class unitList {
    public $units = array();

    function addItem($ID, $Name, $Standard){
      $unit = new unit;
      $unit->ID = $ID;
      $unit->Name = $Name;
      $unit->Standard = $Standard;
      array_push($this->units, $unit);
    }
    function unitList(){
      include $_SESSION["docroot"].'/php/connect.php';
      $result = $mysqli->query("SELECT * FROM `Einheit`");
      while($item = $result->fetch_assoc()){
        $this->addItem($item["ID"], $item["Name"], $item["Standard"]);
      }
      $mysqli->close();
    }
    function getID($Name){
      include $_SESSION["docroot"].'/php/connect.php';
      $result = $mysqli->query("SELECT `ID` FROM `Einheit` WHERE `Name` = '$Name'");
      $ID = $result->fetch_assoc();
      return $ID["ID"];
    }
  }

  class ingredient {
    public $ID, $Menge, $Einheit, $Name;
    function ingredient($ID, $Menge, $Einheit, $Name){
      $this->ID = $ID;
      $this->Menge = $Menge;
      $this->Einheit = $Einheit;
      $this->Name = $Name;
    }
  }

  class recipe {
    public $ID, $Name, $Dauer, $Beschreibung;
    public $Zutaten = array();
    function recipe($ID, $Name, $Dauer, $Beschreibung){
      $this->ID = $ID;
      $this->Name = $Name;
      $this->Dauer = $Dauer;
      $this->Beschreibung = $Beschreibung;
    }
    function addIngredient($ID, $Menge, $Einheit, $Name){
      $current = new ingredient($ID, $Menge, $Einheit, $Name);
      array_push($this->Zutaten, $current);
    }
  }

  class cookbook {
    public $sites = array();
    function getRecipe($ID){
      include $_SESSION["docroot"].'/php/connect.php';
      $recipes = $mysqli->query("SELECT * FROM `Rezept` WHERE `ID` = $ID ORDER BY Name ASC");
      while($recipe = $recipes->fetch_assoc()){
        $current = new recipe($RID = $recipe["ID"], $RName = $recipe["Name"], $RDuration = $recipe["Dauer"], $RDescription = $recipe["Beschreibung"]);
        $recepieIngredients = $mysqli->query("SELECT * FROM `RezeptZutat` WHERE `Rezept` = $RID");
        while($recepieIngredient = $recepieIngredients->fetch_assoc()){
          $IID = $recepieIngredient["Zutat"];
          $IAmount = $recepieIngredient["Menge"];
          $units = $mysqli->query("SELECT `Name` FROM `Einheit` WHERE `ID` = ".$recepieIngredient["Einheit"]);
          while($unit = $units->fetch_assoc()){$IUnit = $unit["Name"];}
          $names = $mysqli->query("SELECT `Name` FROM `Zutat` WHERE `ID` = ".$recepieIngredient["Zutat"]);
          while($name = $names->fetch_assoc()){$IName = $name["Name"];}
          $current->addIngredient($IID, $IAmount, $IUnit, $IName);
        }
        array_push($this->sites, $current);
      }
      $mysqli->close();
    }

    function fillCookbook(){
      include $_SESSION["docroot"].'/php/connect.php';
      $recipes = $mysqli->query("SELECT * FROM `Rezept` ORDER BY Name ASC");
      while($recipe = $recipes->fetch_assoc()){
        $current = new recipe($RID = $recipe["ID"], $RName = $recipe["Name"], $RDuration = $recipe["Dauer"], $RDescription = $recipe["Beschreibung"]);
        $recepieIngredients = $mysqli->query("SELECT * FROM `RezeptZutat` WHERE `Rezept` = $RID");
        while($recepieIngredient = $recepieIngredients->fetch_assoc()){
          $IID = $recepieIngredient["Zutat"];
          $IAmount = $recepieIngredient["Menge"];
          $units = $mysqli->query("SELECT `Name` FROM `Einheit` WHERE `ID` = ".$recepieIngredient["Einheit"]);
          while($unit = $units->fetch_assoc()){$IUnit = $unit["Name"];}
          $names = $mysqli->query("SELECT `Name` FROM `Zutat` WHERE `ID` = ".$recepieIngredient["Zutat"]);
          while($name = $names->fetch_assoc()){$IName = $name["Name"];}
          $current->addIngredient($IID, $IAmount, $IUnit, $IName);
        }
        array_push($this->sites, $current);
      }
      $mysqli->close();
    }

    function importCookbook(){
      include $_SESSION["docroot"].'/php/connect.php';
      $units = new unitList();
      $failed_sites = array();
      $succeeded_sites = array();
      $import = json_decode($_POST["content"]);
      if($import->sites!=null){
        foreach ($import->sites as $site) {
          $result = $mysqli->query("SELECT * FROM `Rezept` WHERE `Name`='$site->Name'");
          if($result->num_rows>0){
            array_push($failed_sites, $site);
          }
          else{
            array_push($succeeded_sites, $site);
            $Zutaten = array();
            foreach($site->Zutaten as $Zutat) {
              $nZutat = null;
              $nZutat["ID"] = $Zutat->ID;
              $nZutat["Amount"] = $Zutat->Menge;
              $nZutat["Unit"] = $units->getID($Zutat->Einheit);
              $nZutat["Name"] = $Zutat->Name;
              array_push($Zutaten, $nZutat);
            }
            $this->newRecipe($site->Name, $site->Dauer, $site->Beschreibung, $Zutaten);
          }
        }
        if(sizeof($failed_sites)==0){
          print_r("0");
        }
        else{
          print_r(json_encode($failed_sites));
        }
      }
    }

    function newRecipe($Name, $Dauer, $Beschreibung, $Zutaten){
      include $_SESSION["docroot"].'/php/connect.php';
      $mysqli->query("INSERT INTO `Rezept` (`Name`, `Dauer`, `Beschreibung`) VALUES ('$Name', '$Dauer', '$Beschreibung')");
      $RezeptID = $mysqli->insert_id;
      foreach ($Zutaten as $Zutat) {
        $ZutatID = null;
        $result = $mysqli->query("SELECT ID FROM `Zutat` WHERE `Name` LIKE '".$Zutat["Name"]."'");
        if($result->num_rows>0){
          $item = $result->fetch_assoc();
          $ZutatID = $item["ID"];
        }
        else{
          $mysqli->query("INSERT INTO `Zutat` (`Name`) VALUES ('".ucwords($Zutat["Name"])."')");
          $ZutatID = $mysqli->insert_id;
        }
        $mysqli->query("INSERT INTO `RezeptZutat` (`Rezept`,`Menge`,`Einheit`,`Zutat`) VALUES ('{$RezeptID}','{$Zutat["Amount"]}','{$Zutat["Unit"]}','{$ZutatID}');");
      }
      $mysqli->close();
    }

    function updateRecipe($ID, $Name, $Dauer, $Beschreibung, $Zutaten){
      include $_SESSION["docroot"].'/php/connect.php';
      $mysqli->query("UPDATE `Rezept` SET `Name` = '$Name', `Dauer` = '$Dauer', `Beschreibung` = '$Beschreibung' WHERE `Rezept`.`ID` = $ID;");
      $mysqli->query("DELETE FROM RezeptZutat WHERE Rezept = $ID");
      foreach ($Zutaten as $Zutat) {
        $ZutatID = null;
        $result = $mysqli->query("SELECT ID FROM `Zutat` WHERE `Name` LIKE '".$Zutat["Name"]."'");
        if($result->num_rows>0){
          while($item = $result->fetch_assoc()){ $ZutatID = $item["ID"];}
        }
        else{
          $mysqli->query("INSERT INTO `Zutat` (`Name`) VALUES ('".ucwords($Zutat["Name"])."')");
          $ZutatID = $mysqli->insert_id;
        }
        $mysqli->query("INSERT INTO `RezeptZutat` (`Rezept`,`Menge`,`Einheit`,`Zutat`) VALUES ('{$ID}','{$Zutat["Amount"]}','{$Zutat["Unit"]}','{$ZutatID}');");
      }
    }

    function removeRecipe($ID){
      include $_SESSION["docroot"].'/php/connect.php';
      $mysqli->query("DELETE FROM `RezeptZutat` WHERE `Rezept`=$ID");
      $mysqli->query("DELETE FROM Rezept WHERE ID=$ID");
      $mysqli->close();
    }

    function getAllIngredients(){
      include $_SESSION["docroot"].'/php/connect.php';
      $values = array();
      $result = $mysqli->query("SELECT Name FROM Zutat ORDER BY Name ASC");
      while($item = $result->fetch_assoc()){
        array_push($values, $item["Name"]);
      }
      print_r(json_encode($values));
      $mysqli->close();
    }

    function getRecipeNames(){
      include $_SESSION["docroot"].'/php/connect.php';
      $result = $mysqli->query("SELECT ID, Name FROM `Rezept` ORDER BY Name ASC");
      $recipeList = array();
      while ($item = $result->fetch_assoc()) {
        $recipeList[$item["ID"]] = $item["Name"];
      }
      $mysqli->close();
      return $recipeList;
    }
  }
?>
