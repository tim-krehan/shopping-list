<script src="/js/list.js" charset="utf-8"></script>
<div class="container mt-5">
  <h1>Liste</h1>
</div>
<div class="container">
  <form action="api/list/new" method="post" class="d-flex flex-column">
    <button type="button" id="remove" class="btn btn-primary align-self-end mt-4">Auswahl entfernen</button>
    <?php
    include $_SESSION["docroot"] . '/php/classes.list.php';
    $units = new units;
    $shopping = new shopping;

    $div_item_row_classes = "d-flex flex-row justify-content-start align-items-center rounded-lg mt-1 text-light";
    $div_item_checkbox_classes = "align-self-center p-1 pl-2";
    $input_item_checkbox_classes = "checkbox";
    $div_item_quantity_classes = "p-1 col-3";
    $div_item_name_classes = "p-1 font-weight-bold";
    $div_item_menu = "ml-auto mr-2";
    $button_dropdown_classes = "dropdown-menu-button btn text-light pt-0 pb-0";

    foreach ($shopping->list as $index => $item) {
      if ($index % 2 == 0) {
        $color_theme = "bg-primary";
      } else {
        $color_theme = "bg-secondary";
      }
      if ($item->Erledigt) {
        $div_item_row_color_classes = "bg-success";
        $checked = "checked";
      } else {
        $div_item_row_color_classes = $color_theme;
        $checked = "";
      }

      print_r("<div class='list-row $div_item_row_classes $div_item_row_color_classes'>");
        print_r("<div class='$div_item_checkbox_classes'>");
          print_r("<div class='custom-control custom-checkbox'>");
            print_r("<input type='checkbox' class='$input_item_checkbox_classes custom-control-input' data-color='$color_theme' id='$item->ID-checkbox' data-id='$item->ID' $checked>");
            print_r("<label class='custom-control-label' for='$item->ID-checkbox'></label>");
          print_r("</div>");
        print_r("</div>");
        print_r("<div class='list-row-amount $div_item_quantity_classes' data-amount='$item->Anzahl' data-unit='$item->Einheit'>$item->Anzahl $item->Einheit</div>");
        print_r("<div class='list-row-name $div_item_name_classes'>$item->Name</div>");
        print_r("<div class='$div_item_menu dropdown'>");
          print_r("<button type='button' class='$button_dropdown_classes' id='dropdown-menu-button-dataID-" . $item->ID . "' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>");
            print_r("<i class='fas fa-angle-down'></i>");
          print_r("</button>");
          print_r("<div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdown-menu-button-dataID-" . $item->ID . "'>");
            print_r("<button type='button' class='edit-listitem dropdown-item'><i class='fas fa-edit'></i> Bearbeiten</button>");
            print_r("<button type='button' class='del-listitem dropdown-item'><i class='fas fa-trash-alt'></i> Löschen</button>");
          print_r("</div>");
        print_r("</div>");
      print_r("</div>");
    }
    ?>

    <div class="input-group mb-3 mt-3" data-id='new'>
      <div class="input-group-prepend col-3 p-0">
        <input type='number' name='anzahl' value='1' step=".25" class='form-control w-50 mr-1'>
        <select class="form-control w-50 mr-1" name="einheit">
          <?php
          foreach ($units->list as $index => $unit) {
            if ($unit->Standard) {
              $selected = "selected";
            } else {
              $selected = NULL;
            }
            print_r("<option value='$unit->ID' $selected>$unit->Name</option>");
          }
          ?>
        </select>
      </div>
      <input type="text" name='name' class="form-control" id="nameField" placeholder="Item" aria-label="Item" aria-describedby="button-addon2" autocomplete='off' required>
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fas fa-plus"></i></button>
      </div>
    </div>
  </form>
</div>