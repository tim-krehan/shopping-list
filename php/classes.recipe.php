<?php
  class unit {
    public $ID, $Name, $Standard;
    function __construct(){}
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
    function __construct(){
      include $_SESSION["docroot"].'/php/connect.php';
      $result = $mysqli->query("SELECT * FROM `Einheit`;");
      while($item = $result->fetch_assoc()){
        $this->addItem($item["ID"], $item["Name"], $item["Standard"]);
      }
      $mysqli->close();
    }
    function getID($Name){
      include $_SESSION["docroot"].'/php/connect.php';
      $selectQuery = $mysqli->prepare("SELECT `ID` FROM `Einheit` WHERE `Name` = ?;");
      $selectQuery->bind_param("s", $Name);
      $selectQuery->execute();
      $result = $selectQuery->get_result();
      $ID = $result->fetch_assoc();
      return $ID["ID"];
    }
  }

  class ingredient {
    public $ID, $Menge, $Einheit, $Name;
    function __construct($ID, $Menge, $Einheit, $Name){
      $this->ID = $ID;
      $this->Menge = $Menge;
      $this->Einheit = $Einheit;
      $this->Name = $Name;
    }
  }

  class recipe {
    public $ID, $Name, $Dauer, $Beschreibung;
    public $Zutaten = array();
    function __construct($ID, $Name, $Dauer, $Beschreibung){
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
      $selectQuery = $mysqli->prepare("SELECT * FROM `Rezept` WHERE `ID` = ? ORDER BY Name ASC;");
      $selectQuery->bind_param("s", $ID);
      $selectQuery->execute();
      $recipes = $selectQuery->get_result();
      while($recipe = $recipes->fetch_assoc()){
        $current = new recipe($RID = $recipe["ID"], $RName = $recipe["Name"], $RDuration = $recipe["Dauer"], $RDescription = $recipe["Beschreibung"]);
        $selectIngredientsQuery = $mysqli->prepare("SELECT * FROM `RezeptZutat` WHERE `Rezept` = ?;");
        $selectIngredientsQuery->bind_param("s", $RID);
        $selectIngredientsQuery->execute();
        $recepieIngredients = $selectIngredientsQuery->get_result();
        while($recepieIngredient = $recepieIngredients->fetch_assoc()){
          $IID = $recepieIngredient["Zutat"];
          $IAmount = $recepieIngredient["Menge"];
          $selectUnitQuery = $mysqli->prepare("SELECT `Name` FROM `Einheit` WHERE `ID` = ?;");
          $selectUnitQuery->bind_param("s", $recepieIngredient["Einheit"]);
          $selectUnitQuery->execute();
          $units = $selectUnitQuery->get_result();
          while($unit = $units->fetch_assoc()){$IUnit = $unit["Name"];}
          $selectNamesQuery = $mysqli->prepare("SELECT `Name` FROM `Zutat` WHERE `ID` = ?;");
          $selectNamesQuery->bind_param("s", $recepieIngredient["Zutat"]);
          $selectNamesQuery->execute();
          $names = $selectNamesQuery->get_result();
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
        $selectIngredientsQuery = $mysqli->prepare("SELECT * FROM `RezeptZutat` WHERE `Rezept` = ?;");
        $selectIngredientsQuery->bind_param("s", $RID);
        $selectIngredientsQuery->execute();
        $recepieIngredients = $selectIngredientsQuery->get_result();
        while($recepieIngredient = $recepieIngredients->fetch_assoc()){
          $IID = $recepieIngredient["Zutat"];
          $IAmount = $recepieIngredient["Menge"];
          $selectUnitQuery = $mysqli->prepare("SELECT `Name` FROM `Einheit` WHERE `ID` = ?;");
          $selectUnitQuery->bind_param("s", $recepieIngredient["Einheit"]);
          $selectUnitQuery->execute();
          $units = $selectUnitQuery->get_result();
          while($unit = $units->fetch_assoc()){$IUnit = $unit["Name"];}
          $selectNamesQuery = $mysqli->prepare("SELECT `Name` FROM `Zutat` WHERE `ID` = ?;");
          $selectNamesQuery->bind_param("s", $recepieIngredient["Zutat"]);
          $selectNamesQuery->execute();
          $names = $selectNamesQuery->get_result();
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
          $selectQuery = $mysqli->prepare("SELECT * FROM `Rezept` WHERE `Name`=?;");
          $selectQuery->bind_param("s", $site->Name);
          $selectQuery->execute();
          $result = $selectQuery->get_result();
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
      $insertQuery = $mysqli->prepare("INSERT INTO `Rezept` (`Name`, `Dauer`, `Beschreibung`) VALUES (?, ?, ?);");
      $insertQuery->bind_param("sss", $Name, $Dauer, $Beschreibung);
      $insertQuery->execute();
      $RezeptID = $mysqli->insert_id;
      foreach ($Zutaten as $Zutat) {
        $ZutatID = null;
        $selectIngredientsQuery = $mysqli->prepare("SELECT ID FROM `Zutat` WHERE `Name` LIKE ?;");
        $selectIngredientsQuery->bind_param("s", $Zutat["Name"]);
        $selectIngredientsQuery->execute();
        $result = $selectIngredientsQuery->get_result();
        if($result->num_rows>0){
          $item = $result->fetch_assoc();
          $ZutatID = $item["ID"];
        }
        else{
          $UppercaseName = ucwords($Zutat["Name"]);
          $insertIngredientsQuery = $mysqli->prepare("INSERT INTO `Zutat` (`Name`) VALUES (?);");
          $insertIngredientsQuery->bind_param("s", $UppercaseName);
          $insertIngredientsQuery->execute();
          $ZutatID = $mysqli->insert_id;
        }
        $inserRecipeQuery = $mysqli->prepare("INSERT INTO `RezeptZutat` (`Rezept`,`Menge`,`Einheit`,`Zutat`) VALUES (?,?,?,?);");
        $inserRecipeQuery->bind_param("ssss", $RezeptID, $Zutat["Amount"], $Zutat["Unit"], $ZutatID);
        $inserRecipeQuery->execute();
      }
      $mysqli->close();
    }

    function updateRecipe($ID, $Name, $Dauer, $Beschreibung, $Zutaten){
      include $_SESSION["docroot"].'/php/connect.php';
      $updateQuery = $mysqli->prepare("UPDATE `Rezept` SET `Name` = ?, `Dauer` = ?, `Beschreibung` = ? WHERE `Rezept`.`ID` = ?;");
      $updateQuery->bind_param("ssss", $Name, $Dauer, $Beschreibung, $ID);
      $updateQuery->execute();
      $deleteQuery = $mysqli->prepare("DELETE FROM RezeptZutat WHERE Rezept = ?;");
      $deleteQuery->bind_param("s", $ID);
      $deleteQuery->execute();
      foreach ($Zutaten as $Zutat) {
        $ZutatID = null;
        $selectIngredientsQuery = $mysqli->prepare("SELECT ID FROM `Zutat` WHERE `Name` LIKE ?;");
        $selectIngredientsQuery->bind_param("s", $Zutat["Name"]);
        $selectIngredientsQuery->execute();
        $result = $selectIngredientsQuery->get_result();
        if($result->num_rows>0){
          while($item = $result->fetch_assoc()){ $ZutatID = $item["ID"];}
        }
        else{
          $uppercaseName = ucwords($Zutat["Name"]);
          $insertIngredientsQuery = $mysqli->prepare("INSERT INTO `Zutat` (`Name`) VALUES (?);");
          $insertIngredientsQuery->bind_param("s", $uppercaseName);
          $insertIngredientsQuery->execute();
          $ZutatID = $mysqli->insert_id;
        }
        $insertRecipeIngredientsQuery = $mysqli->prepare("INSERT INTO `RezeptZutat` (`Rezept`,`Menge`,`Einheit`,`Zutat`) VALUES (?,?,?,?);");
        $insertRecipeIngredientsQuery->bind_param("ssss", $ID, $Zutat["Amount"], $Zutat["Unit"], $ZutatID);
        $insertRecipeIngredientsQuery->execute();
      }
    }

    function removeRecipe($ID){
      include $_SESSION["docroot"].'/php/connect.php';
      $deleteQuery = $mysqli->prepare("DELETE FROM `RezeptZutat` WHERE `Rezept`=?;");
      $deleteQuery->bind_param("s", $ID);
      $deleteQuery->execute();
      $deleteQuery = $mysqli->prepare("DELETE FROM Rezept WHERE ID=?;");
      $deleteQuery->bind_param("s", $ID);
      $deleteQuery->execute();
      $mysqli->close();
    }

    function getAllIngredientsContaining($q){
      include $_SESSION["docroot"].'/php/connect.php';
      $values = array();
      $filterValue = "%$q%";
      $selectQuery = $mysqli->prepare("SELECT Name FROM Zutat WHERE Name LIKE ? ORDER BY Name ASC");
      $selectQuery->bind_param("s", $filterValue);
      $selectQuery->execute();
      $result = $selectQuery->get_result();
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
