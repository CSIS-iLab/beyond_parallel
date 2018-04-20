<?php
/**
 * Beyond Parallel functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Beyond_Parallel
 */

if ( ! function_exists( 'beyond_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function beyond_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on components, use a find and replace
	 * to change 'beyond' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'beyond', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'beyond-featured-image', 640, 9999 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Top', 'beyond' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' )
		) );

	/**
	 * Add support for core custom logo.
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 200,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'beyond_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'beyond_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function beyond_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'beyond_content_width', 640 );
}
add_action( 'after_setup_theme', 'beyond_content_width', 0 );

/**
 * Return early if Custom Logos are not available.
 *
 * @todo Remove after WP 4.7
 */
function beyond_the_custom_logo() {
	if ( ! function_exists( 'the_custom_logo' ) ) {
		return;
	} else {
		the_custom_logo();
	}
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function beyond_register_sidebars() {
	register_sidebar(array(				
		'id' => 'sidebar', 					
		'name' => 'Sidebar',				
		'description' => 'Take it on the side...', 
		'before_widget' => '<div>',	
		'after_widget' => '</div>',	
		'before_title' => '<h3 class="side-title">',
		'after_title' => '</h3>',		
		'empty_title'=> '',					
	));
} 

/**
 * Enqueue scripts and styles.
 */
function beyond_scripts() {

	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/inc/bootstrap.min.css');

	wp_enqueue_style( 'beyond-style', get_stylesheet_uri() );

       // typekit
    wp_enqueue_script( 'theme_typekit', 'https://use.typekit.net/ith5zhm.js');


	wp_enqueue_script( 'beyond-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'beyond-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'beyond-homepage', get_template_directory_uri() . '/js/homepage.js', array( 'jquery' ), '20171', true );

	// add fitvid
	wp_enqueue_script( 'beyond-fitvid', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '20151215', true );

	// add fitvid
	wp_enqueue_script( 'beyond-fittext', get_template_directory_uri() . '/js/jquery.fittext.js', array( 'jquery' ), '20151215', true );

	// Font Awesome
	wp_enqueue_script('transparency-font-awesome', 'https://use.fontawesome.com/08b1a76eab.js');

	// jQuery
	wp_enqueue_script('jquery');

		// Bootstrap
	wp_enqueue_script('beyond-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '20151215', true );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'beyond_scripts' );

add_action( 'after_setup_theme', 'beyond_images' );
function beyond_images() {
    add_image_size( 'homepage-thumb', 400, 400, true ); // (cropped)
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Masonry for homepage
 */
function beyond_masonry() {
	//if (!is_admin()) {
		wp_register_script('jquery_masonry', get_template_directory_uri(). '/js/jquery.masonry.min.js', array('jquery'), '2.0.110526' );
		wp_enqueue_script('jquery_masonry');
		add_action('wp_footer', 'beyond_add_masonry');
		
		function beyond_add_masonry() { ?>
			<script>
				jQuery(document).ready(function($){
					if ($('#masonry-index').length){
						$('#masonry-index').masonry({
						itemSelector: '.index-post-container',
						isAnimated: true
					});
					}
			  	});
			</script>
		<?php 
		}
	//}
}

add_action('init', 'beyond_masonry');


/**
 * Add Walker class for menu drop-down descriptions
 */
function prefix_nav_description( $item_output, $item, $depth, $args ) {
    if ( !empty( $item->description ) ) {
        $item_output = str_replace( $args->link_after . '</a>', '</a><span class="menu-item-description">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
    }
 
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'prefix_nav_description', 10, 4 );


/**
 * wp_list_categories() 
 */
  function set_js_var() {
       $translation_array = array( 'template_directory_uri' => get_template_directory_uri());
       wp_localize_script( 'jquery', 'my_data', $translation_array );
  } 
  add_action('wp_enqueue_scripts','set_js_var');  


/**
 * Article footer shortcode
 */
function articleFooter( $atts, $content = null ) {

   return  '<div class="articleFooter">' . do_shortcode($content) . '</div>';
 
}
 
add_shortcode('footer', 'articleFooter');





/**
 * Metaboxes for AVINK page template
 */
function SearchFilter($query) {
if ($query->is_search) {
$query->set('post_type', 'post');
}
return $query;
}

add_filter('pre_get_posts','SearchFilter');

add_action('admin_init','my_meta_init');
function my_meta_init()
{
$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
// checks for post/page ID

$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
// check for a template type
if ($template_file == 'template_avink.php')
{


function hhs_get_sample_options() {
$options = array ();

		global $post;
				$args = array();
				$posts = get_posts($args);
		foreach( $posts as $post ) : setup_postdata($post); 
			$id = $post->ID;
			$name = get_the_title($id );
			$options[$name] = $id;
		endforeach; 
	
	return $options;
}
add_action('add_meta_boxes', 'hhs_add_meta_boxes', 1);
function hhs_add_meta_boxes() {
	add_meta_box( 'repeatable-fields', 'Repeatable Fields', 'hhs_repeatable_meta_box_display', 'page', 'normal', 'default');
}
function hhs_repeatable_meta_box_display() {
	global $post;
	$repeatable_fields = get_post_meta($post->ID, 'repeatable_fields', true);
	$options = hhs_get_sample_options();
	wp_nonce_field( 'hhs_repeatable_meta_box_nonce', 'hhs_repeatable_meta_box_nonce' );
	?>
	<script type="text/javascript">
	jQuery(document).ready(function( $ ){
		$( '#add-row' ).on('click', function() {
			var row = $( '.empty-row.screen-reader-text' ).clone(true);
			row.removeClass( 'empty-row screen-reader-text' );
			row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
			return false;
		});
  	
		$( '.remove-row' ).on('click', function() {
			$(this).parents('tr').remove();
			return false;
		});
	});
	</script>
  
	<table id="repeatable-fieldset-one" width="100%">
	<tbody>
	<?php
	
	if ( $repeatable_fields ) :
	
	foreach ( $repeatable_fields as $key => $field ) {

	?>
	<tr>
		<td style="padding-bottom:40px; ">
		<div style="padding: 20px 20px 40px 20px; border: 1px solid #ddd; margin-bottom:5px;">
			<label for="name[]" style="display:inline-block; font-size: 1rem; font-weight:bold; width: 15%">Year: </label>
			<input style="display: inline; margin-bottom: 10px; width: 50%;" type="text" class="widefat" name="name[]" value="<?php if($field['name'] != '') echo esc_attr( $field['name'] ); ?>" />
			<br>
			<label for="select[]" style="display:inline-block; font-size: 1rem; font-weight:bold; width: 15%">Featured Article: </label>

			<select  style="display: inline; margin-bottom: 10px; width: 50%;" name="select[]">
			<?php foreach ( $options as $label => $value ) : ?>
			<option value="<?php echo $value; ?>"<?php selected( $field['select'], $value ); ?>><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
	
			<br>
			<label for="findings[]" style="display:inline-block; font-size: 1rem; font-weight:bold;">Findings: </label>
			
			<?php 
			$settings = array(
			    'tinymce' => true,
			    'textarea_rows' => 10,
			    'wpautop' => true, // use wpautop?
    			'media_buttons' => true, // show insert/upload button(s)
			);
			wp_editor( $field['findings'], 'findings[]', $settings ); ?>

			<br>

			<label for="related[]" style="display:inline-block; font-size: 1rem; font-weight:bold;">Related: </label>
			
			<?php 
			$settings = array(
			    'tinymce' => true,
			    'textarea_rows' => 10,
			    'wpautop' => true, // use wpautop?
    			'media_buttons' => true, // show insert/upload button(s)
			);
			wp_editor( $field['related'], 'related[]', $settings ); ?>

			</div>
			<a class="button remove-row" href="#">Remove</a>
		</td>
	</tr>
	<?php
	}
	else :
	// show a blank one
	?>
	<tr>
		<td style="padding-bottom:40px; ">
			<div style="padding: 20px 20px 40px 20px; border: 1px solid #ddd; margin-bottom:5px;">
			<label for="name[]" style="display:inline-block; font-size: 1rem; font-weight:bold; width: 15%">Year: </label>
			<input  style="display: inline; margin-bottom: 10px; width: 50%;" type="text" class="widefat" name="name[]" />
			<br>
			<label for="select[]" style="display:inline-block; font-size: 1rem; font-weight:bold; width: 15%">Featured Article: </label>
			<select  style="display: inline; margin-bottom: 10px; width: 50%;" name="select[]">
			<?php foreach ( $options as $label => $value ) : ?>
			<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>

			<br>
			<label for="findings[]" style="display:inline-block; font-size: 1rem; font-weight:bold;">Findings: </label>
			<?php 
			$settings = array(
			    'tinymce' => true,
			    'textarea_rows' => 10,
			    'wpautop' => true, // use wpautop?
    			'media_buttons' => true, // show insert/upload button(s)
			);
			wp_editor( '', 'findings[]', $settings ); ?>

			<br>
			<label for="related[]" style="display:inline-block; font-size: 1rem; font-weight:bold;">Related: </label>
			<?php 
			$settings = array(
			    'tinymce' => true,
			    'textarea_rows' => 10,
			    'wpautop' => true, // use wpautop?
    			'media_buttons' => true, // show insert/upload button(s)
			);
			wp_editor( '', 'related[]', $settings ); ?>

			</div>
			<a class="button remove-row" href="#">Remove</a>
		</td>
	</tr>
	<?php endif; ?>
	
	<!-- empty hidden one for jQuery -->
	<tr class="empty-row screen-reader-text">
		<td  style="padding-bottom:40px">
			<div style="padding: 20px 20px 40px 20px; border: 1px solid #ddd; margin-bottom:5px;">

			<label for="name[]" style="display:inline-block; font-size: 1rem; font-weight:bold; width: 15%">Year: </label>
			<input  style="ddisplay: inline; margin-bottom: 10px; width: 50%;" type="text" class="widefat" name="name[]" />
			<br>
			<label for="select[]" style="display:inline-block; font-size: 1rem; font-weight:bold; width: 15%">Featured Article: </label>
			<select  style="display: inline; margin-bottom: 10px; width: 50%;" name="select[]">
			<?php foreach ( $options as $label => $value ) : ?>
			<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
			</select>
			<br>
			<label for="findings[]" style="display:inline-block; font-size: 1rem; font-weight:bold;">Findings: </label>
			<?php 
			$settings = array(
			    'tinymce' => true,
			    'textarea_rows' => 10,
			    'wpautop' => true, // use wpautop?
    			'media_buttons' => true, // show insert/upload button(s)
			);
			wp_editor( '', 'findings[]', $settings ); ?>

		  	
			<br>
			<label for="related[]" style="display:inline-block; font-size: 1rem; font-weight:bold;">Related: </label>
			<?php 
			$settings = array(
			    'tinymce' => true,
			    'textarea_rows' => 10,
			    'wpautop' => true, // use wpautop?
    			'media_buttons' => true, // show insert/upload button(s)
			);
			wp_editor( '', 'related[]', $settings ); ?>

		  	</div>
			<a class="button remove-row" href="#">Remove</a>
		</td>
	</tr>
	</tbody>
	</table>
	
	<p><a id="add-row" class="button" href="#">Add another</a></p>
	<?php
}
add_action('save_post', 'hhs_repeatable_meta_box_save');
function hhs_repeatable_meta_box_save($post_id) {
	if ( ! isset( $_POST['hhs_repeatable_meta_box_nonce'] ) ||
	! wp_verify_nonce( $_POST['hhs_repeatable_meta_box_nonce'], 'hhs_repeatable_meta_box_nonce' ) )
		return;
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;
	
	if (!current_user_can('edit_post', $post_id))
		return;
	
	$old = get_post_meta($post_id, 'repeatable_fields', true);
	$new = array();
	$options = hhs_get_sample_options();
	
	$names = $_POST['name'];
	$selects = $_POST['select'];
	$findings = $_POST['findings'];
	$related = $_POST['related'];

	$count = count( $names );
	
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $names[$i] != '' ) :
			$new[$i]['name'] = stripslashes( strip_tags( $names[$i] ) );
			
			if ( in_array( $selects[$i], $options ) )
				$new[$i]['select'] = $selects[$i];
			else
				$new[$i]['select'] = '';
		
			if ( $findings[$i] == '' )
				$new[$i]['findings'] = '';
			else
				$new[$i]['findings'] = stripslashes( $findings[$i] ); // and however you want to sanitize
			if ( $related[$i] == '' )
				$new[$i]['related'] = '';
			else
				$new[$i]['related'] = stripslashes( $related[$i] ); // and however you want to sanitize
		endif;
	}
	if ( !empty( $new ) && $new != $old )
		update_post_meta( $post_id, 'repeatable_fields', $new );
	elseif ( empty($new) && $old )
		delete_post_meta( $post_id, 'repeatable_fields', $old );
}



}

add_action('save_post','my_meta_save');
}