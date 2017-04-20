/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function($) {

    $(window).load(function() {
        //console.log("hello");
        //
        if ($('#ms-container').length != 0) {
            var container = document.querySelector('#ms-container');
            var msnry = new Masonry(container, {
                itemSelector: '.ms-item',
                columnWidth: '.ms-item',
                originLeft: false
            });
        }
    });

    /*$(document).ready(function() {


        var moveFeatured = function(winWidth) {
  console.log(winWidth);

            if (winWidth > 991) {
                $('#ms-container .featuredCard').insertAfter("#ms-container .ms-item:nth-child(2)");
            }

            if (winWidth < 992) {
                $('#ms-container .featuredCard').insertAfter("#ms-container .ms-item:nth-child(1)");
            }
            if (winWidth < 768) {
                $('#ms-container .featuredCard').insertBefore("#ms-container .ms-item:nth-child(1)");
            }
        }


        var startWidth = $(window).width(); // returns width of browser viewport
        moveFeatured(startWidth);
      

        $(window).resize(function() {
            // This will execute whenever the window is resized
            var newWidth = $(window).width(); // New width
            moveFeatured(newWidth);
        
        });

    });
*/

})(jQuery);
