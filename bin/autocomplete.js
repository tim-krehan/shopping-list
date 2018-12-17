function autocomplete(textelement, values) {
  var currentFocus;
  textelement.addEventListener("input", function(e){
    var a, b, i, val = this.value;
    closeAllLists();
    if(!val){ return false;}
    currentFocus = -1;
    a = document.createElement("div");
    a.setAttribute("id", this.id + "ingredientAutocomplete-list");
    a.setAttribute("class", "ingredientAutocomplete-items");
    this.parentNode.appendChild(a);
    for (var i = 0; i < values.length; i++) {
      if(values[i].substr(0, val.length).toUpperCase() == val.toUpperCase()){
        b = document.createElement("div");
        b.innerHTML = "<strong>" + values[i].substr(0, val.length) + "</strong>";
        b.innerHTML += values[i].substr(val.length);
        b.innerHTML += "<input type='hidden' value='" + values[i] + "'>";
        b.addEventListener("click", function(e){
          textelement.value = this.getElementsByTagName("input")[0].value;
          closeAllLists();
        });
        a.appendChild(b);
      }
    }
  });
  textelement.addEventListener("keydown", function(e){
    var x = document.getElementById(this.id + "ingredientAutocomplete-list");
    if (x) {x.getElementsByTagName("div");}
    if (e.keyCode == 40) {
      currentFocus++;
      addActive(x);
    }
    else if (e.keyCode == 38) {
      currentFocus--;
      addActive(x);
    }
    else if (e.keyCode == 13) {
      e.preventDefault();
      if (currentFocus > -1) {
        if (x) {
          var y = $("#"+x.id).parent().find("input");
          x.childNodes[currentFocus].click();
          y.focus();
        }
      }
    }
  });
  function addActive(x) {
    if(!x) {return false;}
    removeActive(x);
    if(currentFocus>=x.childNodes.length){currentFocus=0;}
    if(currentFocus<0){currentFocus = (x.childNodes.length-1);}
    x.childNodes[currentFocus].classList.add("ingredientAutocomplete-active");
  }
  function removeActive(x) {
    for (var i = 0; i < x.childNodes.length; i++) {
      x.childNodes[i].classList.remove("ingredientAutocomplete-active");
    }
  }
  function closeAllLists(elmnt){
    var x = document.getElementsByClassName("ingredientAutocomplete-items");
    for (var i = 0; i < x.length; i++) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
  document.addEventListener("click", function(e){
      closeAllLists(e.target);
  });
}
var values = [];
$(document).ready(function(){
  $.ajax({
    type: "POST",
    url: "/api/recipes/auto",
    data: {},
    success: function(data){
      values = data.split("||");
    }
  });
});
