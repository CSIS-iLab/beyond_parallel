<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       etuckerharris.com
 * @since      1.0.0
 *
 * @package    Social_Share_Minimalist
 * @subpackage Social_Share_Minimalist/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Social_Share_Minimalist
 * @subpackage Social_Share_Minimalist/admin
 * @author     Tucker Harris <#>
 */
class Social_Share_Minimalist_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->social_share_minimalist_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Social_Share_Minimalist_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Social_Share_Minimalist_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 if ( 'settings_page_ssm' == get_current_screen() -> id ) {
		 	// CSS stylesheet for Color Picker
             wp_enqueue_style( 'wp-color-picker' );     
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/social-share-minimalist-admin.css', array('wp-color-picker'), $this->version, 'all' );
	}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Social_Share_Minimalist_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Social_Share_Minimalist_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 *
		 */
		
		wp_enqueue_style( 'wp-color-picker' );   
		
            wp_enqueue_script( $this->plugin_name , plugins_url('js/social-share-minimalist-admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );	
	}

		/**
	*
	* admin/class-wp-cbf-admin.php - Don't add this
	*
	**/

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     */
	    add_options_page( 'Social Share Minimalist Setup', 'Social Share Minimalist Settings', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
	);
	}

	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	 
	 public function add_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	    $settings_link = array(
	    	'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	    );
	    return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
		include_once( 'partials/social-share-minimalist-admin-display.php' );
	}


	/**
	 * Save plugin options.
	 *
	 */
  	public function options_update() {
	    register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	 	}

	 /**
	 * Validate all options fields.
	 *
	 */
	public function validate($input) {

    // All checkboxes inputs   

	    $valid = array();

	    
	    //Cleanup
	    $valid['includeFacebook'] = (isset($input['includeFacebook']) && !empty($input['includeFacebook'])) ? 1 : 0;
	   $valid['includeTwitter'] = (isset($input['includeTwitter']) && !empty($input['includeTwitter'])) ? 1 : 0;
	    $valid['includeGoogle'] = (isset($input['includeGoogle']) && !empty($input['includeGoogle'])) ? 1 : 0;
	   $valid['includePinterest'] = (isset($input['includePinterest']) && !empty($input['includePinterest'])) ? 1 : 0;
	    $valid['includeLinkedin'] = (isset($input['includeLinkedin']) && !empty($input['includeLinkedin'])) ? 1 : 0;

	          

	          
		//$valid['comments_css_cleanup'] = (isset($input['comments_css_cleanup']) && !empty($input['comments_css_cleanup'])) ? 1: 0;


	   // Login Customization
                //First Color Picker
                //
              
                $valid['background_color'] = (isset($input['background_color']) && !empty($input['background_color'])) ? sanitize_text_field($input['background_color']) : '';


                if ( !empty($valid['background_color']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['background_color']  ) ) { // if user insert a HEX color with #
                    add_settings_error(
                            'background_color',                     // Setting title
                            'background_color_texterror',            // Error ID
                            'Please enter a valid hex value color',     // Error message
                            'error'                         // Type of message
                    );
                }

    return $valid;

 	}

 	




}
