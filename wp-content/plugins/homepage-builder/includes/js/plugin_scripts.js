(function($) {
    'use strict';

    //trigger on document ready
    jQuery(document).ready(function($) {
        /*Draggable Area*/
        $('.left_container .page_item').draggable({
            helper: 'clone',
            revert: 'invalid',
            scope: 'related_pages_scope',
            cursor: 'move',
            zIndex: 5
        });

        /*Droppable Area*/
        $('.right_container').droppable({
            accept: '.page_item',
            scope: 'related_pages_scope',
            hoverClass: 'hover-over-draggable',
            tolerance: 'touch',
            drop: function(event, ui) {

                //define items for use
                var drop_helper = $('.right_container').find('.droppable-helper');
                var page_item = ui.draggable.clone();

                //on drop trigger actions
                page_item.find('.remove_item').addClass('active');
                page_item.append('<input type="hidden" name="related_pages[]" value="' + page_item.attr('data-page-id') + '"/>');

                //add this new item to the end of the droppable list
                drop_helper.before(page_item);
                drop_helper.removeClass('active');

                trigger_remove_page_item_action();

            },
            over: function(event, ui) {
                //when hovering over the droppable area, display the drop helper
                $('.right_container').find('.droppable-helper').addClass('active');

            },
            out: function(event, ui) {
                $('.right_container').find('.droppable-helper').removeClass('active');
            }
        });



    });



    $(document).ready(function() {



        // custom css expression for a case-insensitive contains()



        $('#search_box').keyup(function() {
            filter(this);
        });

        function filter(element) {
            var value = $(element).val();

            $("label").each(function() {
                if ($(this).text().indexOf(value) > -1) {
                    $(this).parent().parent().show();
                } else {
                    $(this).parent().parent().hide();
                }
            });
        }






        // use the :checked selector to find any that are checked
        if ($('input#position_array').val() != undefined) {

            var postID = $(this).attr('id');
            var start_positions = $('input#position_array').val();
            var featured_post = $('input#featured_post').val();

            var new_array = start_positions.split(',');
            new_array.splice(0, 0, featured_post);

            //console.log(new_array);
            $.each(new_array, function(index, val) {
                $("input[data-id='" + val + "']").attr('data-sort-position', index);
                var title = $("input[data-id='" + val + "']").attr('data-name');
                //console.log(val);
                $('.right_container').append("<div class='page_item " + val + " ' data-page-id=" + val + "  id='" + val + "-sortable'><div class='page_title'>" + title + "</div><div class='remove_item active'> Remove </div><input type='hidden' name='related_pages[]' value=" + val + " data-place=''/>")
            });
        };

        $(':checkbox').on('click', function() {
            // use the :checked selector to find any that are checked
            if ($(this).is(':checked')) {

                var post = [];
                $.each($("input[data-post-type='post']:checked"), function() {

                    var postID = $(this).attr('id');
                    var postName = $(this).attr('data-name');

                    if ($(".right_container ." + postID).length == 0) {
                        $('.right_container').append("<div class='page_item " + postID + " ' data-page-id=" + postID + "  id='" + postID + "-sortable'><div class='page_title'>" + postName + "</div><div class='remove_item active'> Remove </div><input type='hidden' name='related_pages[]' value=" + postID + " data-place=''/>")
                    }


                });

            } else {

                var thisID = $(this).attr('id');
                $(".page_item[data-page-id='" + thisID + "'] ").remove();
                $(this).attr('data-sort-position', '0');

            }
            sortEventHandler_update();

        });

        //After moving item
        var sortEventHandler = function(event, ui) {

            var sortedIDs = $(".right_container").sortable("toArray");

            //console.log(sortedIDs);
            var checkID = $(".page_item", this).attr('data-page-id');
            var updatedPosition = ui.item.index();


            $(".page_item").each(function(index) {
                //console.log( index + ": " + $( this ).attr('data-page-id') );
                var thisID = $(this).attr('data-page-id');
                updatePosition(thisID, index)
            });
            //$("input[id='"+checkID+"']").attr('data-sort-position', false);
            updateArray();
        };

        var updateArray = function() {
            var positionArray = [];
            $(".page_item").each(function(index) {
                var thisID = $(this).attr('data-page-id');

                positionArray.push(thisID);



            });

            var featured = positionArray.shift();

            var new_positionArray = positionArray;


            $('input#position_array').val(new_positionArray);

            $('input#featured_post').val(featured);


        };

        var sortEventHandler_update = function() {

            var array = $(".right_container .page_item").toArray();
            //console.log(array)

            $(array).each(function(index, value) {
                var thisID = $(this).attr('data-page-id');
                //var thisIndex = $(this).index('.right_container');
                console.log(index + ": " + thisID);
                updatePosition(thisID, index)
            });
            //$("input[id='"+checkID+"']").attr('data-sort-position', false);
            updateArray();
        };

        var updatePosition = function(thisID, index) {
            //console.log(thisID + ": " + index);

            $('.left_container input').each(function() {
                var listID = $(this).attr('id');
                var newID = thisID;
                var listIndex = index + 1;
                if (listID == newID) {
                    $(this).attr('data-sort-position', listIndex);
                }
            });
            updateArray();
        }

        // Remove button functionality
        $('.right_container').on('click', '.remove_item', function() {
            var checkID = $(this).parent('div').attr('data-page-id');
            $(this).parent('div').remove();
            //console.log(checkID);
            $("input[id='" + checkID + "']:checked").attr('checked', false);
            $("input[id='" + checkID + "']:checked").attr('data-page-id', '0');
            sortEventHandler_update();
            updateArray();
        });


        /*Sortable Area*/
        $('.right_container').sortable({
            items: '.page_item',
            cursor: 'move',
            containment: 'parent',
            placeholder: 'my-placeholder',
            stop: sortEventHandler
        });

    });

})(jQuery);
