function autocomplete() {
    var apiurl = $(this).data("apiurl");
    var search = $(this).val();
    var elem = $(this);
    if (search.length > $(this).data("strlen")) {
        $.post({
            url: apiurl,
            data: {
                q: search
            },
            success: function (data) { 
                createAutocompleteDropdown(elem, JSON.parse(data));
            }
        });
    }
}
function createAutocompleteDropdown(elem, values) {
    var dropdownmenue = $('[aria-labelledby=' + elem.attr("id") + ']');
    var dropdownItems = dropdownmenue.find(".dropdown-item");
    dropdownItems.remove();

    if (!(dropdownmenue.hasClass("show"))){
        elem.click();
    }

    for (index = 0; index < values.length; index++) {
        var value = values[index];
        var regex = new RegExp((elem).val(), "ig");
        var displayvalue = value.replace(regex, ("<b><u>" + (elem).val() + "</u></b>"));

        var button = $("<button class=\"dropdown-item\" type=\"button\" data-val='" + value + "' aria-textfield='" + elem.attr("id") + "'>" + displayvalue + "</button>");
        button.click(dropdownButtonClick);
        
        dropdownmenue.append(button);
    }
}
function dropdownButtonClick() {
    var string = $(this).data("val");
    $('#' + $(this).attr("aria-textfield")).val(string);
    $('[aria-labelledby=' + $('#' + $(this).attr("aria-textfield")).attr("id") + ']').find(".dropdown-item").remove();
    $('[aria-labelledby=' + $('#' + $(this).attr("aria-textfield")).attr("id") + ']').append('<button class="dropdown-item" type="button" data-value="-1">Tippen um zu suchen... </button>');
}