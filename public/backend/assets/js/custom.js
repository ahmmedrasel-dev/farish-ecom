$(document).ready(function () {

  /*====================================================
                   load-function
   ====================================================*/

  $(window).on('load', function () {
    $('#status').fadeOut(); // will first fade out the loading animation 
    $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
    $('body').delay(350).css({ 'overflow': 'visible' });
  })

});
