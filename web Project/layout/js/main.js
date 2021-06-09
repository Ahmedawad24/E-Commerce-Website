window.onscroll = function() {
  if (pageYOffset >= 600) {
    //change it with anmite
    $(".topnav").css("background", "#fff");
  } else {
    //change it with anmite
    $(".topnav").css("background", "rgba(255, 255, 255, 0.07)");
  }
};

$(".center").click(function() {
  $(".search").animate({
    width: "toggle"
  });
});

$(".click").click(function() {
  $(".sub-menu").animate({
    height: "toggle"
  });
});
$(".menu").click(function() {
  $(".menu-bar").fadeToggle();
  $(".menu").toggleClass("fas fa-times");
  $(".menu").toggleClass("fas fa-bars");
});

$("#login").click(function() {
  $(".log").fadeIn("slow");
});
$("#signup").click(function() {
  $(".sign").fadeIn("slow");
});
$(".click").click(function() {
  $(".log").fadeOut("slow");
  $(".sign").fadeOut("slow");
  $(".click").toggleClass("fas fa-times");
  $(".click").toggleClass("far fa-user");
});
