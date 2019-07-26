$(document).ready(function () {
  $(window).scroll(function () {
    if ($(this).scrollTop() > 80) {
      $('#nav2').fadeIn();
    } else {
      $('#nav2').fadeOut();
    }

    $('.scrolledup').click(function () {
      $("html, body").animate({
        scrollTop: 0
      }, 600);
      return false;
    });
  });      
});