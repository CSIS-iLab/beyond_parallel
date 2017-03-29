jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.wa_chpcs_plugin', {
        init : function(ed, url) {

                // register command for when button is clicked
                ed.addCommand('wa_chpcs_insert_shortcode', function() {

                var wa_chpcs_selected = false;
                var wa_chpcs_content = wa_chpcs_selected = tinyMCE.activeEditor.selection.getContent();
                var h2titleclass = prompt("Please, enter your slider ID", "");
                             
                    if(h2titleclass != '') {

                        if (h2titleclass.length != 0){
                        h2titleclass = ' id= "'+h2titleclass+'"';

                        wa_chpcs_content = '[carousel-horizontal-posts-content-slider-pro'+h2titleclass+']';

                        tinymce.execCommand('mceInsertContent', false, wa_chpcs_content);

                        }
                    }      
                });

            // register buttons - trigger above command when clicked
            ed.addButton('wa_chpcs_button', {title : 'Insert shortcode', cmd : 'wa_chpcs_insert_shortcode', image: url + '/b_img.png' });
        },   
    });
    tinymce.PluginManager.add('wa_chpcs_button', tinymce.plugins.wa_chpcs_plugin);
});