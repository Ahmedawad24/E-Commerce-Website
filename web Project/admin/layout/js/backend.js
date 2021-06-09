$(function() {
  "use strict";
  //dashboard

  $(".toggle-info");

  // SelectBoxIt
  $("select").selectBoxIt({
    autoWidth: false
  });

  // hide placeholder on form foucs..
  // login page
  $("[placeholder]")
    .focus(function() {
      $(this).attr("data-text", $(this).attr("placeholder"));
      $(this).attr("placeholder", " ");
    })
    .blur(function() {
      $(this).attr("placeholder", $(this).attr("data-text"));
    });
  // login page
  var pass = $(".password");

  $(".show-pass").hover(
    function() {
      pass.attr("type", "text");
    },
    function() {
      pass.attr("type", "password");
    }
  );

  $(".confirm").click(function() {
    return confirm("Are you sure?");
  });

  $(".cat h3").click(function() {
    $(this)
      .next(".full-view")
      .slideToggle();
  });

  window.onscroll = function() {
    if (pageYOffset >= 150) {
      //change it with anmite
      $(".topnav").css("background", "rgba(255, 255, 255, 0.5)");
    } else {
      //change it with anmite
      $(".topnav").css("background", "#fff");
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
});
