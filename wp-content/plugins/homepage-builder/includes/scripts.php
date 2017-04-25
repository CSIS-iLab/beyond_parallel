<?php

/******************************
* script control
******************************/

/*function hb_load_styles() {


	
		wp_enqueue_style('hb-styles', plugin_dir_url( __FILE__ ) . 'css/plugin_styles.css');

}
add_action('wp_enqueue_scripts', 'hb_load_styles');



function hb_load_scripts() {

	wp_enqueue_script( 'hb-script', plugin_dir_url( __FILE__ ) . 'js/plugin_scripts.js', array( 'jquery', 'jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable' ), 1, false );
}
add_action('wp_enqueue_scripts', 'hb_load_scripts');*/


function your_css_and_js() {
wp_enqueue_style('hb-styles', plugin_dir_url( __FILE__ ) . 'css/plugin_styles.css', array(), 1, 'all' );
wp_enqueue_style('hb-display-styles', plugin_dir_url( __FILE__ ) . 'css/display_styles.css', array(), 1, 'all' );

wp_enqueue_script( 'hb-script', plugin_dir_url( __FILE__ ) . 'js/plugin_scripts.js', array( 'jquery', 'jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable' ), 1, false );

wp_enqueue_script('jquery_masonry', plugin_dir_url( __FILE__ ) . 'js/jquery.masonry.min.js', array('jquery'), 1, false );

}
add_action( 'admin_init','your_css_and_js');

// UPLOAD ENGINE
function load_wp_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_init', 'load_wp_media_files' );

