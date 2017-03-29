<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       etuckerharris.com
 * @since      1.0.0
 *
 * @package    Social_Share_Minimalist
 * @subpackage Social_Share_Minimalist/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Social_Share_Minimalist
 * @subpackage Social_Share_Minimalist/includes
 * @author     Tucker Harris <#>
 */
class Social_Share_Minimalist_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'social-share-minimalist',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
