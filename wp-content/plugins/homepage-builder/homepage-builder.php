<?php
/*
Plugin Name: Homepage Builder
Plugin URI: 
Description: Choose and reorder posts on the homepage
Author: Tucker Harris
Author URI: 
Version: 1.0
*/


/******************************
* global variables
******************************/

$hb_prefix = 'hb_';
$hb_plugin_name = 'Homepage Builder';

// retrieve our plugin settings from the options table
$hb_options = get_option('hb_settings');

/******************************
* includes
******************************/

include('includes/scripts.php'); // this controls all JS / CSS
include('includes/data-processing.php'); // this controls all saving of data
include('includes/display-functions.php'); // display content functions
include('includes/admin-page.php'); // the plugin options page HTML and save functions
