function infoPopUp(infotext){
  $("#info-popup-text").text(infotext);
  $("#info-popup-text").css("animation", "none");
  setTimeout(function(){$("#info-popup-text").css("animation", "fade 4s linear");}, 100);
}
