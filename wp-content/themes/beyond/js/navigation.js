/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function() {
    var container, button, menu, links, subMenus, i, len;

    container = document.getElementById('site-navigation');
    if (!container) {
        return;
    }

    button = container.getElementsByTagName('button')[0];
    if ('undefined' === typeof button) {
        return;
    }

    menu = container.getElementsByTagName('ul')[0];

    // Hide menu toggle button if menu is empty and return early.
    if ('undefined' === typeof menu) {
        button.style.display = 'none';
        return;
    }

    menu.setAttribute('aria-expanded', 'false');
    if (-1 === menu.className.indexOf('nav-menu')) {
        menu.className += ' nav-menu';
    }

    button.onclick = function() {
        if (-1 !== container.className.indexOf('toggled')) {
            container.className = container.className.replace(' toggled', '');
            button.setAttribute('aria-expanded', 'false');
            menu.setAttribute('aria-expanded', 'false');
        } else {
            container.className += ' toggled';
            button.setAttribute('aria-expanded', 'true');
            menu.setAttribute('aria-expanded', 'true');
        }
    };

    // Get all the link elements within the menu.
    //links = menu.getElementsByTagName('a');
    //subMenus = menu.getElementsByTagName('ul');

    // Set menu items with submenus to aria-haspopup="true".
    //for (i = 0, len = subMenus.length; i < len; i++) {
    // subMenus[i].parentNode.setAttribute('aria-haspopup', 'true');
    //}

    // Each time a menu link is focused or blurred, toggle focus.
    //for (i = 0, len = links.length; i < len; i++) {
    // links[i].addEventListener('focus', toggleFocus, true);
    // links[i].addEventListener('blur', toggleFocus, true);
    //}

    /**
     * Sets or removes .focus class on an element.
     
    function toggleFocus() {
        var self = this;

        // Move up through the ancestors of the current link until we hit .nav-menu.
        while (-1 === self.className.indexOf('nav-menu')) {

            // On li elements toggle the class .focus.
            if ('li' === self.tagName.toLowerCase()) {
                if (-1 !== self.className.indexOf('focus')) {
                    self.className = self.className.replace(' focus', '');
                } else {
                    self.className += ' focus';
                }
            }

            self = self.parentElement;
        }
    }

*/


})();

/**
 * mobile menu toggle.
 */
(function($) {

        $(".search-icon").click(function() {
            var imageSearch = my_data.template_directory_uri + '/assets/images/search-icon.svg';
            var imageClose = my_data.template_directory_uri + '/assets/images/close-icon-yellow.svg';

            $(".search-input").toggle("slide");

            $(".search-icon span").toggle("slow");
            $(".search-icon img").toggleClass("imageClosed");

            $('.search-icon img').attr('src', function(index, attr) {
                return attr == imageSearch ? imageClose : imageSearch;
            });

        });



        $(document).ready(function() {
            $(".mobile-navigation .sub1>a").attr("href", "#");

            var cyellow = "#eee";
            var cwhite = "#FFC726"
            $('#nav-icon4').click(function() {
                $(this).toggleClass('open');
                $('#nav-icon4').attr('background-color', function(index, attr) {
                    return attr == cwhite ? cyellow : cwhite;
                });
            });
        });




        $(".mobile-navigation .menu-item-has-children.sub1").click(function() {
            $(".sub-menu", this).toggle("slow");
        });


        $(function() {
            $('a[href*="#"]:not([href="#"])').click(function() {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top - 100
                        }, 1000);
                        return false;
                    }
                }
            });
        });


        $(".social-share-wrapper").on("click", function() {
                $(".sharemedia").toggle("slide");
            });


        })(jQuery);
