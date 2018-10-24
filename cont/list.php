<script src="/bin/list.js" charset="utf-8"></script>
<link rel="stylesheet" href="/style/list.css">
<h1>Liste</h1>
<button type="button" id="remove" class="button">Auswahl entfernen</button>
<form id="neu" action="php/edit-list.php" method="post">
  <input type="hidden" name="function" value="new">
<div id="list">
  <?php
    include $_SESSION["docroot"].'/php/classes.list.php';
    $units = new units;
    $shopping = new shopping;
    $parity = "odd";
    foreach ($shopping->list as $item){
      if($parity=="even"){$parity="odd";}else{$parity="even";}
      if($item->Erledigt){$checked="checked";}else{$checked=NULL;}
      echo "<div class='list_row $parity $checked' data-id='".$item->ID."'>";
        echo "<input type='checkbox' class='check' $checked>";
        echo "<font class='list_row_count' data-id='$item->ID'>$item->Anzahl $item->Einheit</font>";
        echo "<font class='list_row_name' data-id='$item->ID'>$item->Name</font>";
      echo "</div>";
    }
    echo "<div class='list_row new' data-id='new'>";
      echo "<input type='checkbox' class='check' disabled />";
      echo "<span class='list_row_count' id='list_row_count_input'>";
        echo "<input type='number' name='anzahl' value='1' id='list_row_anzahl_input'>";
          echo "<select name='einheit' id='list_row_einheit_input'>>";
          foreach ($units->list as $unit) {
            if($unit->Standard){$selected="selected";}else{$selected=NULL;}
            echo "<option value='$unit->ID' $selected>$unit->Name</option>";
          }
          echo "</select>";
        echo "</span>";
      echo "<input class='list_row_name' type='text' name='name' value='' id='nameField' autocomplete='off' required /> <input type='submit' name='submit' value='+' id='add'>";
    echo "</div>";
  ?>
</div>
</form>
<div id="saved"><font>SAVED!</font></div>
<div id="error"><font>Netzwerkfehler!<br /> Bitte aktualisieren.</font></div>
