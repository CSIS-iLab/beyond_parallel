<?php
/*
Plugin Name: Endnotes
Plugin URI: http://heavyheavy.com
Description: A simple solution for adding footnotes to your WordPress posts or pages.
Author: Heavy Heavy
Version: 1.0.1
Author URI: http://heavyheavy.com
Contributors: We Are Pixel8
Text Domain: endnotes
Domain Path: /languages

License:
	Copyright 2015 Heavy Heavy <@okayerik>
	
	This program is free software; you can redistribute it and/or modify it under
	the terms of the GNU General Public License, version 2, as published by the Free
	Software Foundation.
	
	This program is distributed in the hope that it will be useful, but WITHOUT ANY
	WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
	PARTICULAR PURPOSE. See the GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software Foundation, Inc.,
	51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

/*-----------------------------------------------------------------------------------*/
/* Constants
/*-----------------------------------------------------------------------------------*/

define( 'ENDNOTES_DIR', plugin_dir_path( __FILE__ ) );
define( 'ENDNOTES_VERSION', '1.0.0' );

/*-----------------------------------------------------------------------------------*/
/* Includes
/*-----------------------------------------------------------------------------------*/

include( ENDNOTES_DIR . 'includes/endnotes-options.php' ); // load plugin settings
include( ENDNOTES_DIR . 'includes/endnotes-output.php' );  // load plugin output

/*-----------------------------------------------------------------------------------*/
/* Endnotes Scripts
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_enqueue_scripts', 'heavyheavy_endnotes_scripts' );

/**
 * Endnotes Scripts
 *
 * Load the scripts for collapsible endnotes.
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_scripts() {

	$options  = get_option( '_heavyheavy_endnotes_settings' );
	$collapse = ( isset( $options['endnotes_collapse'] ) ) ? $options['endnotes_collapse'] : '';

	if ( !is_admin() && $collapse ) {

		// register scripts
		wp_register_script( 'endnotes', plugins_url( 'js/endnotes.js', __FILE__ ), array( 'jquery' ), ENDNOTES_VERSION, true );

		// enqueue scripts
		wp_enqueue_script( 'endnotes' );

	}

}

/*-----------------------------------------------------------------------------------*/
/* Endnotes Settings Link
/*-----------------------------------------------------------------------------------*/

add_filter( 'plugin_action_links', 'heavyheavy_endnotes_settings_link', 10, 2 );

/**
 * Endnotes Settings Link
 *
 * Add a shortcut link to the Endnotes Settings page from the plugin management
 * screen.
 *
 * @param $links
 * @param $file
 *
 * @package Heavy Heavy
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_settings_link( $links, $file ) {

	if ( $file == plugin_basename( __FILE__ ) && current_user_can( 'manage_options' ) ) {
		$links[] = '<a href="' . admin_url( 'options-general.php?page=endnotes-options' ) . '">' . __( 'Settings', 'endnotes' ) . '</a>';
	}

	return $links;

}

/*-----------------------------------------------------------------------------------*/
/* Plugin Text Domain - to do
/*-----------------------------------------------------------------------------------*/

add_action( 'plugins_loaded', 'heavyheavy_load_endnotes_text_domain', 10 );

/**
 * Load Text Domain
 *
 * Load the text domain for internationalization.
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_load_endnotes_text_domain() {

	load_plugin_textdomain( 'endnotes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

}