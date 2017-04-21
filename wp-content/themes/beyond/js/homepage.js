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



})(jQuery);
