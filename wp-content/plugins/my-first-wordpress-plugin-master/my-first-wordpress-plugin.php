<?php
/*
Plugin Name: My First plugin
Plugin URI: http://pippinsplugins.com/how-to-begin-writing-your-first-wordpress-plugin
Description: This is my first WordPress Plugin
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
Version: 1.0
*/


/******************************
* global variables
******************************/

$mfwp_prefix = 'mfwp_';
$mfwp_plugin_name = 'My First WordPress Plugin';

// retrieve our plugin settings from the options table
$mfwp_options = get_option('mfwp_settings');

/******************************
* includes
******************************/

include('includes/scripts.php'); // this controls all JS / CSS
include('includes/data-processing.php'); // this controls all saving of data
include('includes/display-functions.php'); // display content functions
include('includes/admin-page.php'); // the plugin options page HTML and save functions
