jQuery(document).ready( function() {


/* ar width = jQuery(window).width();


if (width > 980) { // .roll_wrap_link




  jQuery(".roll_wrap_link").click(function() {

        var link = jQuery(this).find("a").attr("href");

        if (link) {
          window.location = jQuery(this).find("a").attr("href");
          return false;

        }

    });


              }

  */
  jQuery('.dh-container').on('mouseenter',
    function (e) {
     // alert('jbt');
     e.stopPropagation();
      jQuery(this).find('.visible_text').slideToggle();
    });


  jQuery('.dh-container').on('mouseleave',
    function (e) {
      // alert('jbt');
      e.stopPropagation();
      jQuery(this).find('.visible_text').slideToggle(500);
    });

})//end function


 jQuery(window).load(function () {
    jQuery('.dh-container').directionalHover();
    jQuery('.dh-container2').directionalHover({
      overlay: ".dh-overlay2",
      speed: 150
    });

    
    



  });



function show_visible_text() {
  e.stopPropagation();
  
}
