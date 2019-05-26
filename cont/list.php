<script src="/js/list.js" charset="utf-8"></script>
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
      $div_item_menu = "ml-auto mr-2";

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

        print_r("<div class='list-row $div_item_row_classes $div_item_row_color_classes'>");
            print_r("<div class='$div_item_checkbox_classes'><input type='checkbox' class='$input_item_checkbox_classes' data-color='$color_theme' data-id='$item->ID' $checked></div>");
            print_r("<div class='$div_item_quantity_classes'>$item->Anzahl $item->Einheit</div>");
            print_r("<div class='$div_item_name_classes'>$item->Name</div>");
            print_r("<i href='#' class='fas fa-angle-right $div_item_menu'></i>");
        print_r("</div>");
      }
    ?>

    <div class="input-group mb-3 mt-3" data-id='new'>
      <div class="input-group-prepend col-3 p-0">
        <input type='number' name='anzahl' value='1' class='w-50'>
        <select class="w-50" name="einheit">
          <?php
            foreach ($units->list as $index => $unit) {
              if($unit->Standard){$selected="selected";}else{$selected=NULL;}
              print_r("<option value='$unit->ID' $selected>$unit->Name</option>");
            }
          ?>
        </select>
      </div>
      <input type="text" name='name' class="form-control" id="nameField" placeholder="Item" aria-label="Item" aria-describedby="button-addon2"  autocomplete='off' required>
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-plus"></i></button>
      </div>
    </div>

  </form>
</div>
