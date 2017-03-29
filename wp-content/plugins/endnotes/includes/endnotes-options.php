<?php
/*-----------------------------------------------------------------------------------*/
/* Endnotes Sub Menu Page
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_menu', 'heavyheavy_endnotes_submenu_page', 10 );

/**
 * Endnotes Sub Menu Page
 *
 * Add a sub menu page, to the Settings menu, for customizing Endnotes options.
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_submenu_page() {

	add_submenu_page(
		'options-general.php',                 // parent page to add the menu link to
		__( 'Endnotes Settings', 'endnotes' ), // page title
		__( 'Endnotes', 'endnotes' ),          // menu link title
		'manage_options',                      // restrict this page to only those who can manage options
		'endnotes-options',                    // unique ID for this menu page
		'heavyheavy_endnotes_options_cb'       // callback function to render the page HTML
	);

}

/*-----------------------------------------------------------------------------------*/
/* Endnotes Options Callback
/*-----------------------------------------------------------------------------------*/

/**
 * Endnotes Options Callback
 *
 * Render the HTML for the Endnotes options page.
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_options_cb() {

	global $submenu;

	$page_data = array();

	foreach ( $submenu['options-general.php'] as $i => $menu_item ) {
		if ( $submenu['options-general.php'][$i][2] == 'endnotes-options' )
			$page_data = $submenu['options-general.php'][$i];
	} ?>

<div class="wrap">
	<?php screen_icon();?>

	<h2><?php echo esc_html( $page_data[3] ); ?></h2>

	<form id="heavyheavy_endnotes_options" action="options.php" method="post">
		<?php
			settings_fields( '_heavyheavy_endnotes_settings_group' );
			do_settings_sections( 'endnotes-options' );
			submit_button( __( 'Save Settings', 'endnotes' ) );
		?>
	</form>
</div>	
<?php

}

/*-----------------------------------------------------------------------------------*/
/* Endnotes Admin Init
/*-----------------------------------------------------------------------------------*/

add_action( 'admin_init', 'heavyheavy_endnotes_admin_init', 10 );

/**
 * Endnotes Admin Init
 *
 * Register the Endnotes settings and add the option sections and fields.
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_admin_init() {

	// register setting
	register_setting(
		'_heavyheavy_endnotes_settings_group', // unique option group
		'_heavyheavy_endnotes_settings',       // unique option name
		'heavyheavy_endnotes_sanitization_cb'  // callback function to sanitize form inputs
	);

	// add display settings section
	add_settings_section(
		'endnotes_display_settings_section',               // unique ID for this section
		__( 'Display Settings', 'endnotes' ),              // section title
		'heavyheavy_endnotes_display_settings_section_cb', // callback function to render a description for this section
		'endnotes-options'                                 // page ID to render this section on
	);

	// add settings field for endnotes header
	add_settings_field(
		'endnotes_header',                     // unique ID for this field
		__( 'Header Text', 'endnotes' ),       // field title
		'heavyheavy_endnotes_header_field_cb', // callback function to render this form input
		'endnotes-options',                    // page ID to render this form input
		'endnotes_display_settings_section'    // section ID where this form input should appear
	);

	// add settings field for template display
	add_settings_field(
		'endnotes_templates',                    // unique ID for this field
		__( 'Template Selection', 'endnotes' ),  // field title
		'heavyheavy_endnotes_template_field_cb', // callback function to render this form input
		'endnotes-options',                      // page ID to render this form input
		'endnotes_display_settings_section'      // section ID where this form input should appear
	);

	// add settings field for collapsing endnotes
	add_settings_field(
		'endnotes_collapse',                        // unique ID for this field
		__( 'Endnotes Functionality', 'endnotes' ), // field title
		'heavyheavy_endnotes_collapse_field_cb',    // callback function to render this form input
		'endnotes-options',                         // page ID to render this form input
		'endnotes_display_settings_section'         // section ID where this form input should appear
	);

}

/*-----------------------------------------------------------------------------------*/
/* Endnotes Display Settings Section Callback
/*-----------------------------------------------------------------------------------*/

/**
 * Endnotes Display Settings Section Callback
 *
 * Insert a simple description for the settings page.
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_display_settings_section_cb() {

?>
<p><?php _e( 'Configure how Endnotes will function and be displayed.', 'endnotes' ); ?></p>
<?php

}

/*-----------------------------------------------------------------------------------*/
/* Endnotes Header Text Field Callback
/*-----------------------------------------------------------------------------------*/

/**
 * Endnotes Header Text Field Callback
 *
 * The callback function to render the Header Text input field.
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_header_field_cb() {

	$options = wp_parse_args(
		get_option(
			'_heavyheavy_endnotes_settings' ),
			array(
				'endnotes_header' => '',
			)
		);

	echo "<input type='text' id='endnotes_header' name='_heavyheavy_endnotes_settings[endnotes_header]' class='regular-text' value='{$options['endnotes_header']}' />";
	echo "<p class='description'>" . __( 'If left blank, no header text will be displayed. No HTML allowed.', 'endnotes' ) . "</p>";

}

/*-----------------------------------------------------------------------------------*/
/* Endnotes Template Field Callback
/*-----------------------------------------------------------------------------------*/

/**
 * Endnotes Template Field Callback
 *
 * The callback function to render the Template Selection checkbox.
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_template_field_cb() {

	$options = wp_parse_args(
		get_option(
			'_heavyheavy_endnotes_settings' ),
			array(
				'endnotes_templates' => '',
			)
		);

	$checked = $options['endnotes_templates'];

	echo "<label for='endnotes_templates'><input name='_heavyheavy_endnotes_settings[endnotes_templates]' id='endnotes_template' value='1' '" . checked( $checked, 1, false ) . "' type='checkbox' />" . __( 'Only display footnotes on single post or page', 'endnotes' ) . "</label>";

}

/*-----------------------------------------------------------------------------------*/
/* Endnotes Collapse Field Callback
/*-----------------------------------------------------------------------------------*/

/**
 * Endnotes Collapse Field Callback
 *
 * The callback function to render the Endnotes Functionality checkbox.
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_collapse_field_cb() {

	$options = wp_parse_args(
		get_option(
			'_heavyheavy_endnotes_settings' ),
			array(
				'endnotes_collapse' => '',
			)
		);

	$checked = $options['endnotes_collapse'];

	echo "<label for='endnotes_collapse'><input name='_heavyheavy_endnotes_settings[endnotes_collapse]' id='endnotes_collapse' value='1' '" . checked( $checked, 1, false ) . "' type='checkbox' />" . __( 'Collapse endnotes until clicked', 'endnotes' ) . "</label>";

}

/*-----------------------------------------------------------------------------------*/
/* Endnotes Sanitization Callback
/*-----------------------------------------------------------------------------------*/

/**
 * Endnotes Sanitization Callback
 *
 * Sanitize field inputs before saving to the database.
 *
 * @param $input
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_sanitization_cb( $input ) {

	$input['endnotes_header'] = sanitize_text_field( $input['endnotes_header'] );

	// ensure checkboxes always exists after the first save.
	$input['endnotes_templates'] = ( empty( $input['endnotes_templates'] ) ) ? '' : $input['endnotes_templates'];
	$input['endnotes_collapse'] = ( empty( $input['endnotes_collapse'] ) ) ? '' : $input['endnotes_collapse'];

	return $input;

}