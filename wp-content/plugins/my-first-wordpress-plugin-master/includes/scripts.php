<?php

/******************************
* script control
******************************/

/*function mfwp_load_styles() {


	
		wp_enqueue_style('mfwp-styles', plugin_dir_url( __FILE__ ) . 'css/plugin_styles.css');

}
add_action('wp_enqueue_scripts', 'mfwp_load_styles');



function mfwp_load_scripts() {

	wp_enqueue_script( 'mfwp-script', plugin_dir_url( __FILE__ ) . 'js/plugin_scripts.js', array( 'jquery', 'jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable' ), 1, false );
}
add_action('wp_enqueue_scripts', 'mfwp_load_scripts');*/


function your_css_and_js() {
wp_enqueue_style('mfwp-styles', plugin_dir_url( __FILE__ ) . 'css/plugin_styles.css', array(), 1, 'all' );
wp_enqueue_style('mfwp-display-styles', plugin_dir_url( __FILE__ ) . 'css/display_styles.css', array(), 1, 'all' );

wp_enqueue_script( 'mfwp-script', plugin_dir_url( __FILE__ ) . 'js/plugin_scripts.js', array( 'jquery', 'jquery-ui-droppable','jquery-ui-draggable', 'jquery-ui-sortable' ), 1, false );

wp_enqueue_script('jquery_masonry', plugin_dir_url( __FILE__ ) . 'js/jquery.masonry.min.js', array('jquery'), 1, false );

}
add_action( 'admin_init','your_css_and_js');

