<?php
/**
 * Custom buttons for TinyMCE
 *
 * @package Beyond_Parallel
 */
add_action( 'after_setup_theme', 'beyond_theme_setup' );
if ( ! function_exists( 'beyond_theme_setup' ) ) {
	/**
	 * Initialize custom buttons for TinyMCE.
	 */
	function beyond_theme_setup() {
		add_action( 'init', 'beyond_buttons' );
	}
}

/********* TinyMCE Buttons ***********/
if ( ! function_exists( 'beyond_buttons' ) ) {
	/**
	 * Render buttons.
	 */
	function beyond_buttons() {
		add_filter( 'mce_external_plugins', 'beyond_add_buttons' );
		add_filter( 'mce_buttons', 'beyond_register_buttons' );
	}
}
if ( ! function_exists( 'beyond_add_buttons' ) ) {
	/**
	 * Include the JS file with the button information.
	 *
	 * @param Array $plugin_array Plugin array to update.
	 */
	function beyond_add_buttons( $plugin_array ) {
		$plugin_array['beyond'] = get_template_directory_uri() . '/js/tinymce.js';
		return $plugin_array;
	}
}
if ( ! function_exists( 'beyond_register_buttons' ) ) {
	/**
	 * Add custom buttons to buttons array
	 *
	 * @param  Array $buttons Array of buttons to appear in editor.
	 * @return Array          Updated buttons array.
	 */
	function beyond_register_buttons( $buttons ) {
        array_push( $buttons, 'button',  'aside', 'note');
        return $buttons;
	}
}

if ( !function_exists( 'beyond_tinymce_extra_vars' ) ) {
	function beyond_tinymce_extra_vars() {

		// Get list of Posts
		$args = array(
			'posts_per_page' => -1,
			'post_type' => array('post'),
			'orderby' => 'title',
			'order' => 'asc'
		);
		$posts = get_posts( $args );
		$postList = "";
		foreach($posts as $post) {
			$format = "{text: '" .  esc_html($post->post_title) . "', value: '" . $post->ID . "'},";
			if ( $post->post_type == 'post' ) {
				$postList .= $format;
			}
		}
		$postList = "[".$postList."]";
		?>

		<script type="text/javascript">
			var tinyMCE_posts = <?php echo $postList; ?>;
		</script><?php
	}
}

add_action ( 'enqueue_block_assets', 'beyond_tinymce_extra_vars' );
