<script src="/bin/list.js" charset="utf-8"></script>
<div class="container mt-5">
  <h1>Liste</h1>
</div>
<div class="container">
  <form action="api/list/new" method="post" class="d-flex flex-column">
    <button type="button" id="remove" class="btn btn-primary align-self-end mt-4">Auswahl entfernen</button>
    <?php
      include $_SESSION["docroot"].'/php/classes.list.php';
      $units = new units;
      $shopping = new shopping;

      $div_item_row_classes = "d-flex flex-row justify-content-start align-items-center rounded-lg mt-1 text-light";
      $div_item_checkbox_classes = "align-self-center p-1 pl-2";
      $input_item_checkbox_classes = "checkbox";
      $div_item_quantity_classes = "p-1 col-3";
      $div_item_name_classes = "p-1 font-weight-bold";

      foreach ($shopping->list as $index => $item) {
        if($index%2==0){$color_theme = "bg-primary";}
        else{$color_theme = "bg-secondary";}
        if($item->Erledigt){
          $div_item_row_color_classes = "bg-success";
          $checked = "checked";
        }
        else{
          $div_item_row_color_classes = $color_theme;
          $checked = "";
        }

        print_r("<div class='$div_item_row_classes $div_item_row_color_classes'>");
            print_r("<div class='$div_item_checkbox_classes'><input type='checkbox' class='$input_item_checkbox_classes' data-color='$color_theme' data-id='$item->ID' $checked></div>");
            print_r("<div class='$div_item_quantity_classes'>$item->Anzahl $item->Einheit</div>");
            print_r("<div class='$div_item_name_classes'>$item->Name</div>");
        print_r("</div>");
      }
      print_r("<div class='$div_item_row_classes  d-flex flex-row align-items-center' data-id='new'>");
            print_r("<div class='$div_item_checkbox_classes col-0'><input type='checkbox' class='$input_item_checkbox_classes' disabled></div>");

            print_r("<div class='$div_item_quantity_classes'>");
              print_r("<input type='number' name='anzahl' value='1' class='m-1 p-0 col-4' id='list_row_anzahl_input'>");
              print_r("<select name='einheit' class='p-0 m-1 col-5'>");
              foreach ($units->list as $index => $unit) {
              if($unit->Standard){$selected="selected";}else{$selected=NULL;}
                print_r("<option value='$unit->ID' $selected>$unit->Name</option>");
              }
              print_r("</select>");
            print_r("</div>");

            print_r("<div class='$div_item_name_classes col-9 align-self-end'>");
              print_r("<input type='text' name='name' id='nameField' class='col-8 w-100' autocomplete='off' required />");
              print_r("<input class='btn bg-secondary ml-1 col-2' type='submit' name='submit' value='+' id='add'>");
            print_r("</div>");
      print_r("</div>");
    ?>
  </form>
</div>
