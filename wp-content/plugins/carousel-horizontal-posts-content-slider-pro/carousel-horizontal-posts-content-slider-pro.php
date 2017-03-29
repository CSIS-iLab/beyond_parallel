<?php 
/* 
*	Plugin Name: Carousel horizontal posts content slider pro
*	Description: A posts content slider for WordPress.
*	Version: 1.9.9
*	Author: subhansanjaya
*	Author URI: http://www.weaveapps.com
*/
if(! defined( 'ABSPATH' )) exit; // Exit if accessed directly

class Carousel_Horizontal_Posts_Content_Slider_Pro {

	//default settings
	private $defaults = array(
		'settings' => array(
			'jquery' => false,
			'transit' => true,
			'magnific_popup' => true,
			'lazyload' => true,
			'caroufredsel' => true,
			'touchswipe' => true,
			'loading_place' => 'footer',
			'deactivation_delete' => false
		),
		'version' => '1.9.9'
	);

	private $options = array();
	private $tabs = array();

	public function __construct() {

		//activation and deactivation hooks
		register_activation_hook(__FILE__, array(&$this, 'wa_chpcs_multisite_activation') );
		register_deactivation_hook(__FILE__, array(&$this, 'wa_chpcs_multisite_deactivation'));

		//define plugin path
		define( 'WA_CHPCS_SLIDER_PLUGIN_PATH', plugin_dir_path(__FILE__) );

		//define theme directory
		define( 'WA_CHPCS_SLIDER_PLUGIN_TEMPLATE_DIRECTORY_NAME', 'themes' );
		define( 'WA_CHPCS_PLUGIN_TEMPLATE_DIRECTORY', WA_CHPCS_SLIDER_PLUGIN_PATH .WA_CHPCS_SLIDER_PLUGIN_TEMPLATE_DIRECTORY_NAME. DIRECTORY_SEPARATOR );

		//define view directory
		define( 'WA_CHPCS_SLIDER_PLUGIN_TEMPLATE_DIRECTORY_NAME_VIEW', 'views' );
		define( 'WA_CHPCS_PLUGIN_VIEW_DIRECTORY', WA_CHPCS_SLIDER_PLUGIN_PATH .WA_CHPCS_SLIDER_PLUGIN_TEMPLATE_DIRECTORY_NAME_VIEW. DIRECTORY_SEPARATOR );
	
		add_action('admin_init', array(&$this, 'register_settings'));

		//register post type
		add_action('init', array(&$this, 'wa_chpcs_init'));

		// metaboxes 
		add_action( 'add_meta_boxes', array( $this, 'wa_chpcs_add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'wa_chpcs_save_metabox_data' ) );

		//update messages and help text
		add_action('post_updated_messages', array(&$this, 'wa_chpcs_updated_messages'));
	
		//load defaults
		add_action('plugins_loaded', array(&$this, 'load_defaults'));

		//register shortcode button to the TinyMCE toolbar
		add_action('init',  array(&$this, 'wa_chpcs_shortcode_button_init'));

		//update plugin version
		update_option('wa_chpcs_version', $this->defaults['version'], '', 'no');

		//set settings
		$this->options['settings'] = array_merge($this->defaults['settings'], (($array = get_option('wa_chpcs_settings')) === FALSE ? array() : $array));
		
		add_action('wp_enqueue_scripts', array(&$this, 'wa_chpcs_load_scripts'));
		add_shortcode( 'carousel-horizontal-posts-content-slider-pro', array(&$this, 'wa_chpcs_pro_shortcode') );

		if (is_admin()){
		add_action( 'admin_menu',array(&$this, 'wa_chpcs_pre_add_to_menu' ) );
		}

		add_action('admin_enqueue_scripts', array(&$this, 'admin_include_scripts'));

		//add text domain for localization
		add_action('plugins_loaded', array(&$this, 'wa_chpcs_load_textdomain'));

		// create widget
		include_once('includes/class-wa-chpcs-widget.php');
		$wachpcs_widget = new WA_CHPCS_Widget();

		//add settings link
		add_filter('plugin_action_links', array(&$this, 'wa_chpcs_settings_link'), 2, 2);

		//add ajax on admin to display related select post types
		add_action( 'admin_footer', array(&$this, 'wa_chpcs_related_select'));

		add_action('wp_ajax_nopriv_wa_chpcs_action', array(&$this, 'wa_chpcs_action_callback'));
		add_action('wp_ajax_wa_chpcs_action',  array(&$this, 'wa_chpcs_action_callback'));

		//remove publish box
		add_action( 'admin_menu', array(&$this, 'wa_chpcs_remove_publish_box'));

		add_action('admin_print_scripts', array(&$this, 'wa_chpcs_disable_autosave'));
	}

	//multisite activation
	public function wa_chpcs_multisite_activation($networkwide) {
		if(is_multisite() && $networkwide)
		{
			global $wpdb;

			$activated_blogs = array();
			$current_blog_id = $wpdb->blogid;
			$blogs_ids = $wpdb->get_col($wpdb->prepare('SELECT blog_id FROM '.$wpdb->blogs, ''));

			foreach($blogs_ids as $blog_id)
			{
				switch_to_blog($blog_id);
				$this->activate_single();
				$activated_blogs[] = (int)$blog_id;
			}

			switch_to_blog($current_blog_id);
			update_site_option('wa_chpcs_activated_blogs', $activated_blogs, array());
		}
		else
			$this->activate_single();
	}

	public function activate_single() {
		add_option('wa_chpcs_settings', $this->defaults['settings'], '', 'no');
		add_option('wa_chpcs_version', $this->defaults['version'], '', 'no');
	}

	//deactivation hook
	public function wa_chpcs_multisite_deactivation($networkwide) {
		if(is_multisite() && $networkwide) {
			global $wpdb;

			$current_blog_id = $wpdb->blogid;
			$blogs_ids = $wpdb->get_col($wpdb->prepare('SELECT blog_id FROM '.$wpdb->blogs, ''));

			if(($activated_blogs = get_site_option('wa_chpcs_activated_blogs', FALSE, FALSE)) === FALSE)
				$activated_blogs = array();

			foreach($blogs_ids as $blog_id)
			{
				switch_to_blog($blog_id);
				$this->deactivate_single(TRUE);

				if(in_array((int)$blog_id, $activated_blogs, TRUE))
					unset($activated_blogs[array_search($blog_id, $activated_blogs)]);
			}

			switch_to_blog($current_blog_id);
			update_site_option('wa_chpcs_activated_blogs', $activated_blogs);
		}
		else
			$this->deactivate_single();
	}


	public function deactivate_single($multi = FALSE) {
		if($multi === TRUE)
		{
			$options = get_option('wa_chpcs_settings');
			$check = $options['deactivation_delete'];
		}
		else
			$check = $this->options['settings']['deactivation_delete'];

		if($check === TRUE)
		{
			delete_option('wa_chpcs_settings');
			delete_option('wa_chpcs_version');
		}
	}

	//settings link in plugin management screen
	public function wa_chpcs_settings_link($actions, $file) {

		if(false !== strpos($file, 'carousel-horizontal-posts-content-slider-pro'))
		 $actions['settings'] = '<a href="edit.php?post_type=wa_chpcs&page=wa_chpcs">Settings</a>';
		return $actions; 

	}

	public function wa_chpcs_related_select() {	?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {

		var posts_taxonomy = $("#wa_chpcs_query_posts_taxonomy option:selected").attr('value');
		var posts_terms = $("#wa_chpcs_query_posts_terms option:selected").attr('value'); 
		var posts_tags = $("#wa_chpcs_query_posts_tags option:selected").attr('value'); 
		var post_type = $("#wa_chpcs_query_posts_post_type option:selected").attr('value'); 
		var content_type = $("#wa_chpcs_query_content_type option:selected").attr('value'); 

		if(post_type!='post') { 

			$("#wa_chpcs_query_content_type").closest('tr').hide(); //hide product type

		} else {

			jQuery("#wa_chpcs_query_posts_taxonomy").closest('tr').hide(); 

		}

		if(content_type&&content_type!='category') { 

			$("#wa_chpcs_query_posts_taxonomy").closest('tr').hide(); 
			$("#wa_chpcs_query_posts_terms").closest('tr').hide(); 
			$("#wa_chpcs_query_posts_terms").removeAttr('required'); 

		}

		if(post_type=='post'&&content_type=='category') {

				$("select#wa_chpcs_query_posts_terms").removeAttr("disabled");
				$("#wa_chpcs_query_posts_terms").closest('tr').show(); 
				$("#wa_chpcs_query_posts_terms").attr("required","required");

		}

		if(content_type&&content_type!='tag') { 
 
			$("#wa_chpcs_query_posts_tags").closest('tr').hide(); 
			$("#wa_chpcs_query_posts_tags").removeAttr('required'); 

		}

		if(post_type=='post'&&content_type=='tag') {

			$("select#wa_chpcs_query_posts_tags").removeAttr("disabled");
			$("#wa_chpcs_query_posts_tags").closest('tr').show(); 
			$("#wa_chpcs_query_posts_tags").attr("required","required");

		}

		//disabled taxonomy field
		if(!posts_taxonomy) {

			$("select#wa_chpcs_query_posts_taxonomy").attr("disabled","disabled");
			$("#wa_chpcs_query_posts_taxonomy").closest('tr').hide(); 
		}

		//disabled terms field
		if(!posts_terms) {
			
			$("select#wa_chpcs_query_posts_terms").attr("disabled","disabled");
			$("#wa_chpcs_query_posts_terms").closest('tr').hide(); 

		}

		//disabled tags field
		if(!posts_tags) {

			$("select#wa_chpcs_query_posts_tags").attr("disabled","disabled");
			$("#wa_chpcs_query_posts_tags").closest('tr').hide(); 

		}


		//select terms based on product type
		$("select#wa_chpcs_query_content_type").change(function() {

			var post_type = jQuery("select#wa_chpcs_query_posts_post_type option:selected").attr('value');
			var content_type = $("#wa_chpcs_query_content_type option:selected").attr('value');
			var tax = "category";

			var data = {
				'action': 'wa_chpcs_action',
				'post_type': post_type,
				'tax': tax,
				'content_type': content_type
			};

			$.post(ajaxurl, data, function(response) {
				 $("select#wa_chpcs_query_posts_terms").removeAttr("disabled");
				 $("select#wa_chpcs_query_posts_terms").html(response);
			});

			$.post(ajaxurl, data, function(response) {
				 $("select#wa_chpcs_query_posts_tags").removeAttr("disabled");
				 $("select#wa_chpcs_query_posts_tags").html(response);
			});
		
		});


		$("select#wa_chpcs_query_content_type").change(function()	{

		var content_type = $("#wa_chpcs_query_content_type option:selected").attr('value');
		var post_type = $("#wa_chpcs_query_posts_post_type option:selected").attr('value');

		if(post_type=='post'&&content_type!='category') {

			$("#wa_chpcs_query_posts_terms").removeAttr('required'); 
			$("#wa_chpcs_query_posts_taxonomy").closest('tr').hide(); 
			$("#wa_chpcs_query_posts_terms").closest('tr').hide(); 
			$("#wa_chpcs_query_posts_tags").removeAttr('required'); 
			$("#wa_chpcs_query_posts_tags").closest('tr').hide(); 
			
		} else {

			$("#wa_chpcs_query_posts_taxonomy").closest('tr').hide(); 
			$("#wa_chpcs_query_posts_terms").closest('tr').show(); 
			$("#wa_chpcs_query_posts_terms").attr("required","required");
			$("#wa_chpcs_query_posts_tags").removeAttr('required'); 
			$("#wa_chpcs_query_posts_tags").closest('tr').hide(); 

		}

		if(post_type=='post'&&content_type=='tag') {
			$("#wa_chpcs_query_posts_tags").closest('tr').show(); 
			$("#wa_chpcs_query_posts_tags").attr("required","required");
		} else {

			$("#wa_chpcs_query_posts_tags").closest('tr').hide(); 
			$("#wa_chpcs_query_posts_tags").removeAttr('required'); 
		}


	});

		//select taxonomies based on post type
		$("select#wa_chpcs_query_posts_post_type").change(function() {

		$("#wa_chpcs_query_posts_terms").attr("required","required");

		$("select#wa_chpcs_query_posts_terms").attr("disabled","disabled");

		$("select#wa_chpcs_query_posts_taxonomy").attr("disabled","disabled");

		$("#wa_chpcs_query_posts_terms").closest('tr').hide(); 

		$("#wa_chpcs_query_posts_tags").closest('tr').hide(); 

		$("#wa_chpcs_query_posts_taxonomy").closest('tr').hide();

		var post_type = jQuery("select#wa_chpcs_query_posts_post_type option:selected").attr('value');
			var data = {
				'action': 'wa_chpcs_action',
				'post_type': post_type
			};

			$.post(ajaxurl, data, function(response) {

				if(response=="null"){

					$("#wa_chpcs_query_posts_taxonomy").closest('tr').hide(); 
					$("#wa_chpcs_query_posts_terms").closest('tr').hide(); 
					$("#wa_chpcs_query_posts_terms").removeAttr('required'); 
					$("#wa_chpcs_query_posts_taxonomy").removeAttr('required'); 

				} else {

						if(post_type!='post') { 

						$("#wa_chpcs_query_posts_taxonomy").closest('tr').show(); 
						$("select#wa_chpcs_query_posts_taxonomy").removeAttr("disabled");
						$("select#wa_chpcs_query_posts_taxonomy").html(response);
						$("select#wa_chpcs_query_posts_terms").attr("disabled","disabled");
						$("#wa_chpcs_query_posts_terms").closest('tr').hide(); 
						$("#wa_chpcs_query_posts_tags").closest('tr').hide(); 

					}

				}

			});
		});

		//select terms based on post types and taxonomy
		$("select#wa_chpcs_query_posts_taxonomy").change(function(){

			var post_type = jQuery("select#wa_chpcs_query_posts_post_type option:selected").attr('value');
			var tax = jQuery("select#wa_chpcs_query_posts_taxonomy option:selected").attr('value');

			var data = {
				'action': 'wa_chpcs_action',
				'post_type': post_type,
				'tax': tax
			};

			$.post(ajaxurl, data, function(response) {
				
				 $("#wa_chpcs_query_posts_terms").attr("required","required");
				 $("select#wa_chpcs_query_posts_terms").removeAttr("disabled");
				 $("#wa_chpcs_query_posts_terms").closest('tr').show(); 
				 $("select#wa_chpcs_query_posts_terms").html(response);

			});
		});




	$("select#wa_chpcs_query_posts_post_type").change(function(){

		var post_type = $("#wa_chpcs_query_posts_post_type option:selected").attr('value'); 


		var content_type = $("#wa_chpcs_query_content_type option:selected").attr('value'); 

		if(post_type=='post') { 

			$("#wa_chpcs_query_posts_taxonomy").closest('tr').hide(); 

			$("#wa_chpcs_query_content_type").attr("required","required");
			$("#wa_chpcs_query_content_type").closest('tr').show(); //hide product type

				if(content_type!='category') {

					$("#wa_chpcs_query_posts_taxonomy").closest('tr').hide(); 
					$("#wa_chpcs_query_posts_terms").closest('tr').hide(); 
					$("#wa_chpcs_query_posts_terms").removeAttr('required'); 

				}

			} else {

				$("#wa_chpcs_query_content_type").closest('tr').hide(); //hide product type

			}

		});

	});
	</script> 

	<?php
	
	}

	//ajax action call back
	public function wa_chpcs_action_callback() {

		if(isset($_POST['post_type'])&&isset($_POST['content_type'])&&$_POST['content_type']=="tag") { 
		
			echo $this->showTags($_POST['post_type'],$_POST['content_type']);

		} else if(isset($_POST['post_type'])&&isset($_POST['tax'])) { 
		
			echo $this->showTerms($_POST['post_type'],$_POST['tax']);

		} else if(isset($_POST['post_type'])) { 

			echo $this->showTax($_POST['post_type']);

		} else {

			echo $type;
		}

		die(); // this is required to terminate immediately and return a proper response

	}

	//show all taxonomies for given post type
	public function showTax($post_type) {
	 
	$type = '<option value="">choose...</option>';
	          $taxonomy_names = get_object_taxonomies( $post_type );

	          if(empty($taxonomy_names)) {
	          	 $type = "null"; return  $type; die(); }

	            foreach ($taxonomy_names as $key => $value) {
	                $type .= '<option value="' .$value . '" >' . $value . '</option>';
	           }
	
		return  $type;

	}

	//show terms to post type and tax
	public function showTerms($post_type,$tax) {

		$type = '<option value="">choose...</option>';
	    $categories = get_terms($tax, array('post_type' => array($post_type),'fields' => 'all'));

	    foreach ($categories as $key => $value) {
	        $type .= '<option value="' .$value->slug . '">' . $value->name . '</option>';
	    }

		return  $type;

	}

	//show tags to post type and tax
	public function showTags($post_type,$tax) {

		if($post_type=='post') {

			$tax = 'post_tag';
		} 

		$type = '<option value="">choose...</option>';
	    $tags = get_terms($tax, array('post_type' => array($post_type),'fields' => 'all'));

	    foreach ($tags as $key => $value) {
	        $type .= '<option value="' .$value->slug . '">' . $value->name . '</option>';
	    }

		return  $type;

	}

	//template function
	public function wa_chpcs($atts) {

		$arr = array();
		$arr["id"]=$atts;
		echo wa_chpcs_pro_shortcode($arr);
	}

	// load text domain for localization
	public function wa_chpcs_load_textdomain() {

		load_plugin_textdomain('chpcs', FALSE, dirname(plugin_basename(__FILE__)).'/lang/');

	}

	//load front e8nd scripts
	public function wa_chpcs_load_scripts($jquery_true) {

		wp_register_style('wa_chpcs_css_file', plugins_url('/assets/css/custom-style.css',__FILE__));
		wp_enqueue_style('wa_chpcs_css_file');

		if($this->options['settings']['jquery'] === TRUE) {

			wp_register_script('wa_chpcs_jquery',plugins_url('/assets/js/caroufredsel/jquery-1.8.2.min.js', __FILE__),array('jquery'),'',($this->options['settings']['loading_place'] === 'header' ? false : true));
		    wp_enqueue_script('wa_chpcs_jquery'); 

		}

		if($this->options['settings']['transit'] === TRUE) {

			wp_register_script('wa_chpcs_transit',plugins_url('/assets/js/caroufredsel/jquery.transit.min.js',__FILE__),array('jquery'),'',($this->options['settings']['loading_place'] === 'header' ? false : true));
			wp_enqueue_script('wa_chpcs_transit');

		 }

		if($this->options['settings']['lazyload'] === TRUE) {

			wp_register_script('wa_chpcs_lazyload',plugins_url('/assets/js/caroufredsel/jquery.lazyload.min.js', __FILE__),array('jquery'),'',($this->options['settings']['loading_place'] === 'header' ? false : true));
		    wp_enqueue_script('wa_chpcs_lazyload'); 

		}

		if($this->options['settings']['magnific_popup'] === TRUE) {

			wp_register_style('wa_chpcs_magnific_style', plugins_url('/assets/css/magnific-popup/magnific-popup.css',__FILE__ ));
			wp_enqueue_style('wa_chpcs_magnific_style'); 

			wp_register_script('wa_chpcs_magnific_script',plugins_url('/assets/js/magnific-popup/jquery.magnific-popup.min.js', __FILE__),array('jquery'),'',($this->options['settings']['loading_place'] === 'header' ? false : true));
		    wp_enqueue_script('wa_chpcs_magnific_script');

		}

		if($this->options['settings']['caroufredsel'] === TRUE) {

		    wp_register_script('wa_chpcs_caroufredsel_script',plugins_url('/assets/js/caroufredsel/jquery.carouFredSel-6.2.1-packed.js', __FILE__),array('jquery'),'',($this->options['settings']['loading_place'] === 'header' ? false : true));
		    wp_enqueue_script('wa_chpcs_caroufredsel_script');

		}

		if($this->options['settings']['touchswipe'] === TRUE) {

		    wp_register_script('wa_chpcs_touch_script',plugins_url('/assets/js/caroufredsel/jquery.touchSwipe.min.js', __FILE__),array('jquery'),'',($this->options['settings']['loading_place'] === 'header' ? false : true));
		    wp_enqueue_script('wa_chpcs_touch_script'); 

		}

	}

	//include admin scripts
	public function admin_include_scripts() {

		wp_register_style('wa_chpcs_admin_css',plugins_url('assets/css/admin.css', __FILE__));
		wp_enqueue_style('wa_chpcs_admin_css');

		//add spectrum colour picker
		wp_register_style('wa-chpcs-admin-spectrum',plugins_url('assets/css/spectrum/spectrum.css', __FILE__));
		wp_enqueue_style('wa-chpcs-admin-spectrum');

		wp_register_script('wa-chpcs-admin-spectrum-js',plugins_url('assets/js/spectrum/spectrum.js', __FILE__));
		wp_enqueue_script('wa-chpcs-admin-spectrum-js');

		wp_register_style('wa-chpcs-date-picker',plugins_url('assets/css/jquery-ui.min.css', __FILE__));
		wp_enqueue_style('wa-chpcs-date-picker');

		//add date picker
		wp_enqueue_script(	'jquery-ui-datepicker');

		wp_register_script('wa-chpcs-admin-script',plugins_url('assets/js/admin-script.js', __FILE__));
		wp_enqueue_script('wa-chpcs-admin-script');

	}

	//get excerpt
	public function wa_chpcs_clean($excerpt, $substr) {

		$string = $excerpt;
		$string = strip_shortcodes(wp_trim_words( $string, (int)$substr ));
		return $string;

	}

	//get post thumbnail
	public	function wa_chpcs_get_post_image($post_content, $post_image_id, $img_type, $img_size, $slider_id) {

	  if($img_type=='featured_image'){
	  			if (has_post_thumbnail( $post_image_id ) ): 
				 $img_arr = wp_get_attachment_image_src( get_post_thumbnail_id( $post_image_id ), $img_size ); $first_img = $img_arr[0];
				endif; 
		}else  if($img_type=='first_image'){
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
	 	 $first_img = isset($matches[1][0])?$matches[1][0]:'';
		}else  if($img_type=='last_image'){
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
	  		$first_img = isset($matches[1][count($matches[0])-1])?$matches[1][count($matches[0])-1]:''; 
		}
		  if(empty($first_img)) {
		  	$options = get_post_meta( $slider_id, 'options', true ); //options settings

		  	if(!empty($options['default_image'])) {

		  		 $first_img = $options['default_image'];

		  	} else {
		   		 $first_img = plugins_url()."/carousel-horizontal-posts-content-slider-pro/assets/images/default-image.jpg";

		   	}

		  }
		  return $first_img;
	}

	//add admin menu
	public function wa_chpcs_pre_add_to_menu() {
		
		add_submenu_page( 'edit.php?post_type=wa_chpcs', 'Settings', 'Settings', 'manage_options', 'wa_chpcs', array(&$this, 'options_page') );

	}

	//set lazy load image
	public function get_lazy_load_image($image) {

		  	if(!empty($image)) {

		  		 $lazy_load_image_url = $image;

		  	} else {
		   		 $lazy_load_image_url = plugins_url()."/carousel-horizontal-posts-content-slider-pro/assets/images/loader.gif";

		   	}

		   	return $lazy_load_image_url;
	}

	//schedule sliders
	public function get_status_of_schedule($start_date, $end_date) {

		$status = '';

		$startDate = strtotime($start_date);
		$endDate = strtotime($end_date);
		$currentDate = strtotime(date('m/d/Y'));
		
		if(empty($start_date)&&empty($end_date)) {

			$status = 1;

		}

		if (($currentDate >= $startDate) && ($currentDate <= $endDate)) {

			$status = 2;

		} else  if (($currentDate <= $startDate) && ($currentDate >= $endDate)) {

			$status = 3;

		}

 		 if($status==1||$status==2){

			return true;

		}

	}

	//display slider
	public function wa_chpcs_pro_shortcode($atts) {

		global $chpcs, $wpdb, $post;

		if ( ! is_array( $atts ) )	{
			return '';
		}
		$id = $atts['id'];
		$options = get_post_meta( apply_filters( 'translate_object_id', $id, get_post_type( $id ), true ), 'options', true ); //options settings


		if(empty($options)) { return false; }

		$wa_chpcs_auto = isset($options['auto_scroll']) ? 'true' : 'false';
		$wa_chpcs_timeout = isset($options['timeout']) ? $options['timeout'] :'3000';//time out
		$wa_chpcs_show_controls = isset($options['show_controls']) ? $options['show_controls'] :'';
		$wa_chpcs_show_paging = isset($options['show_paging']) ? $options['show_paging'] : ''; //display paging
		$wa_chpcs_query_posts_image_type = isset($options['image_type']) ? $options['image_type'] :''; //display image type
		$wa_chpcs_query_posts_item_width = isset($options['item_width']) ? $options['item_width'] : ''; //item width
		$wa_chpcs_query_posts_item_height = isset($options['item_height']) ? $options['item_height'] : ''; //item height
		$wa_chpcs_query_posts_fx = isset($options['fx']) ? $options['fx'] : ''; // transition effects type
		$c_min_items = isset($options['show_posts_per_page']) ? $options['show_posts_per_page'] :'4'; // min items 
		$c_items = isset($options['items_to_be_slide']) ? $options['items_to_be_slide'] :'0'; //no of items per page
		$c_easing = $options['easing_effect']; //easing effect
		$c_duration = isset($options['duration']) ? $options['duration'] :'500';//duration
		$qp_showposts = isset($options['show_posts']) ? $options['show_posts'] :'20'; //no of posts to display
		$qp_orderby= isset($options['posts_order_by']) ? $options['posts_order_by'] :'id'; //order by
		$qp_order= isset($options['post_order']) ? $options['post_order'] :'asc';; //order
		$qp_category= isset($options['post_ids']) ? $options['post_ids'] : ''; // post type
		$qp_post_type= isset($options['post_type']) ? $options['post_type'] :'';	//post type
		$content_type= isset($options['content_type']) ? $options['content_type'] :'';	//post type
		$wa_chpcs_pre_direction = isset($options['direction']) ? $options['direction'] :'';	//posts direction
		$slider_template = isset($options['template']) ? $options['template'] : '';	//slider template
		$chpcs_pre_align = isset($options['align_items']) ? $options['align_items'] : '';	//align
		$wa_chpcs_circular = isset($options['circular']) ? 'true' : 'false';	//circular
		$wa_chpcs_infinite = isset($options['infinite']) ? 'true' : 'false';	//infinite
		$taxonomy= isset($options['post_taxonomy']) ? $options['post_taxonomy'] : '';	//taxonomy
		$terms= isset($options['post_terms']) ? $options['post_terms'] : '';	//terems
		$tags= isset($options['post_tags']) ? $options['post_tags'] : '';	//tags
		$wa_chpcs_query_font_colour =  isset($options['font_colour']) ? $options['font_colour'] : '';	//font colour
		$control_colour = isset($options['control_colour']) ? $options['control_colour'] : ''; //direction arrows colour
		$control_bg_colour = isset($options['control_bg_colour']) ? $options['control_bg_colour'] : '' ; //direction arrows background colour
		$arrows_hover_colour = isset($options['arrows_hover_colour']) ? $options['arrows_hover_colour'] : '' ; //direction arrows hover colour
		$size_arrows = isset($options['size_arrows']) ? $options['size_arrows'] : '' ;
		$title_font_size = isset($options['title_font_size']) ? $options['title_font_size'] : ''; //title font size
		$font_size = isset($options['font_size']) ? $options['font_size'] : ''; //general font size
		$custom_css = isset($options['custom_css']) ? $options['custom_css'] : ''; //custom styles
		$wa_chpcs_query_lazy_loading = isset($options['lazy_loading']) ? $options['lazy_loading'] : '' ;	//lazy loading enable
		$wa_chpcs_query_posts_lightbox = isset($options['lightbox']) ? $options['lightbox'] : '' ;	//lightbox
		$wa_chpcs_query_animate_controls = isset($options['animate_controls']) ? $options['animate_controls'] : '' ;//animate
		$wa_chpcs_query_css_transitions = isset($options['css_transitions']) ? $options['css_transitions'] : '' ;//css3 transitions
		$wa_chpcs_query_pause_on_hover = isset($options['pause_on_hover']) ? $options['pause_on_hover'] : '' ; //pause on hover
		$wa_chpcs_image_hover_effect = isset($options['image_hover_effect']) ? $options['image_hover_effect'] : '' ;	//image hover
		$lazy_img = $this->get_lazy_load_image($options['lazy_load_image']); //lazy load image
		$wa_chpcs_query_start_date = isset($options['start_date']) ? $options['start_date'] : '' ;//start date
		$wa_chpcs_query_end_date = isset($options['end_date']) ? $options['end_date'] : '' ;	//end date

		//data required for the template files.
		$wa_chpcs_query_posts_display_excerpt = isset($options['show_excerpt']) ? $options['show_excerpt'] : '' ; //display excerpt type boolean
		$wa_chpcs_query_posts_display_read_more = isset($options['show_read_more_text']) ? $options['show_read_more_text'] : '' ;//display read more type boolean
		$wa_chpcs_query_posts_title =  isset($options['show_title']) ? $options['show_title'] : '' ;//display title type boolean
		$wa_chpcs_query_posts_image_height = isset($options['post_image_height']) ? $options['post_image_height'] : '' ; //thumbnail height string
		$wa_chpcs_query_posts_image_width =  isset($options['post_image_width']) ? $options['post_image_width'] : '' ; //thumbnail width string
		$wa_chpcs_read_more = isset($options['read_more_text']) ? $options['read_more_text'] : '' ; //read more text string
		$displayimage =   isset($options['show_image']) ? $options['show_image'] : '' ;//display image type boolean
		$word_imit = isset($options['word_limit']) ? $options['word_limit'] : '10' ;//word limit integer
		$wa_chpcs_query_display_from_excerpt =   isset($options['excerpt_type']) ? $options['excerpt_type'] : '' ;//display text in excerpt field
		$wa_chpcs_query_show_categories =  isset($options['show_cats']) ? $options['show_cats'] : '' ;//show categories


		$wa_chpcs_query_image_size = isset($options['image_size']) ? $options['image_size'] : 'thumbnail' ; //image size

		if($wa_chpcs_query_image_size == 'other') {

			$wa_chpcs_query_image_size = array($wa_chpcs_query_posts_image_width,$wa_chpcs_query_posts_image_height);

		}

		$wa_chpcs_text_align = isset($options['text_align']) ? $options['text_align'] : 'left';	//text align
		$wa_chpcs_image_size = isset($options['image_size']) ? $options['image_size'] : 'left';	//image align


		//schedule sliders
		$status = $this->get_status_of_schedule($wa_chpcs_query_start_date,$wa_chpcs_query_end_date);

		if($status==false) { return false;}

		?>
		<!-- custom styles -->
		<style>
		<?php if($wa_chpcs_image_hover_effect=='hover_image'){ ?>

		.wa_chpcs_post_link {

			position: relative;

			display: block;
			
		}

		 .wa_featured_img .wa_chpcs_post_link .wa_chpcs_overlay {

			position: absolute;

			top: 0;

			left: 0;

			width: 100%;

			height: 100%;

			background: url(<?php echo $options['hover_image_url'];?>) 50% 50% no-repeat;

			background-color: <?php echo $options['hover_image_bg']?>;

			opacity: 0;
		}

		.wa_featured_img .wa_chpcs_post_link:hover .wa_chpcs_overlay  {

			opacity: 1;

			-moz-opacity: 1;

			filter: alpha(opacity=1);

		}

		<?php } ?>

		<?php if(!empty($custom_css)) { echo $custom_css;  } ?>

		#wa_chpcs_slider_title<?php echo $id;?> { 

			color: <?php echo $options['font_colour']?>;

			font-size: <?php echo $options['title_font_size']?>px;
		}

		#wa_chpcs_image_carousel<?php echo $id;?> {

			color: <?php echo $options['font_colour']?>;

			font-size: <?php echo $options['font_size']?>px;

			<?php if($wa_chpcs_pre_direction=="up"||$wa_chpcs_pre_direction=="down") { ?>

			width: <?php echo $wa_chpcs_query_posts_item_width; ?>px; 

			<?php } ?>

		}

		#wa_chpcs_image_carousel<?php echo $id;?> .wa_chpcs_text_overlay_caption:hover::before {

   			 background-color: <?php echo $options['hover_image_bg']?>!important;
		}

		#wa_chpcs_image_carousel<?php echo $id;?> .wa_chpcs_prev, #wa_chpcs_image_carousel<?php echo $id;?> .wa_chpcs_next,#wa_chpcs_image_carousel<?php echo $id;?> .wa_chpcs_prev_v, #wa_chpcs_image_carousel<?php echo $id;?> .wa_chpcs_next_v  {

			background: <?php echo $options['control_bg_colour']; ?>;

			color: <?php echo $options['control_colour']?>;

			font-size: <?php echo $options['size_arrows']?>px;

			line-height: <?php echo $options['size_arrows']+7;?>px;

			width: <?php echo $options['size_arrows']+10;?>px;

			height: <?php echo $options['size_arrows']+10;?>px;

			margin-top: -<?php echo $options['size_arrows']?>px;

			<?php if($wa_chpcs_query_animate_controls==1) {  if($wa_chpcs_pre_direction=="left"||$wa_chpcs_pre_direction=="right") { ?>

			opacity: 0;

			<?php } }?>

		}

		#wa_chpcs_image_carousel<?php echo $id;?> .wa_chpcs_prev:hover, #wa_chpcs_image_carousel<?php echo $id;?> .wa_chpcs_next:hover {

			color: <?php echo $options['arrows_hover_colour'];?>;

		}

		#wa_chpcs_pager_<?php echo $id;?> a {

			background: <?php echo $options['arrows_hover_colour']; ?>;

		}

		#wa_chpcs_image_carousel<?php echo $id;?> li img {

			<?php 

			if($wa_chpcs_image_hover_effect=='grayscale'||$wa_chpcs_image_hover_effect=='saturate'||$wa_chpcs_image_hover_effect=='sepia') { ?>

			filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale"); /* Firefox 3.5+ */
			
			filter: gray; /* IE6-9 */

			-webkit-filter: <?php echo $wa_chpcs_image_hover_effect; ?>(100%); /* Chrome 19+ & Safari 6+ */

			<?php } ?>

		}

		#wa_chpcs_image_carousel<?php echo $id;?> li .wa_featured_img {

			text-align: <?php echo $options['image_align']; ?>;

		}

		#wa_chpcs_image_carousel<?php echo $id;?> li  {

			text-align: <?php echo $options['text_align']; ?>;

		}

		#wa_chpcs_image_carousel<?php echo $id;?> li img:hover {

			<?php if(!empty($wa_chpcs_image_hover_effect)) { 

			if($wa_chpcs_image_hover_effect=='border') { ?>

			border : solid 1px <?php echo $options['control_bg_colour']; ?>;

			<?php	} else if($wa_chpcs_image_hover_effect=='grayscale'||$wa_chpcs_image_hover_effect=='saturate'||$wa_chpcs_image_hover_effect=='sepia')  { ?>

			filter: none;
			-webkit-filter: <?php echo $wa_chpcs_image_hover_effect; ?>(0%);

			<?php } } ?>
		
		</style>



		<?php

		
		
		if($wa_chpcs_pre_direction=="up"||$wa_chpcs_pre_direction=="down") {

			$chpcs_pre_responsive = "0";

		}	else {

			$chpcs_pre_responsive = isset($options['responsive']) ? $options['responsive'] : '';

		}
		?>

		<script>
		jQuery(document).ready(function() {      	
			jQuery('#wa_chpcs_foo<?php echo $id; ?>').carouFredSel({<?php if($chpcs_pre_responsive==1){ echo "responsive:true,"; } ?>
				direction: "<?php echo $wa_chpcs_pre_direction;?>",
				align: "<?php echo $chpcs_pre_align;?>",
				<?php if($chpcs_pre_responsive!=1){ echo "width:'100%',"; } ?>
				auto 	: {
				play:<?php echo $wa_chpcs_auto;?>,
				timeoutDuration:<?php echo $wa_chpcs_timeout;?>
				},
				scroll : {
				<?php if(isset($c_items)&&$c_items!=0){ echo 'items:'.$c_items.','; } ?>
				fx: "<?php echo $wa_chpcs_query_posts_fx;?>",
				easing : "<?php echo $c_easing;?>",
				duration: <?php echo $c_duration;?>,
				<?php if($wa_chpcs_query_pause_on_hover==1){ ?>					
				pauseOnHover	: true
				<?php } ?>
				},
				infinite: <?php echo $wa_chpcs_infinite;?>,
				circular: <?php echo $wa_chpcs_circular;?>,
				<?php if($wa_chpcs_query_lazy_loading){ ?>
					onCreate: function( data ) {
					loadImage();
				},
				<?php } ?>
				prev: {
				<?php if($wa_chpcs_query_lazy_loading){ ?>
					onAfter: function( data ) {
					loadImage();
				},
				<?php } ?>
				button  : "#foo<?php echo $id; ?>_prev"
				},
				next: {
				<?php if($wa_chpcs_query_lazy_loading){ ?>
					onAfter: function( data ) {
					loadImage();
				},<?php } ?>
				button  : "#foo<?php echo $id; ?>_next"
				},
				items: {
					<?php if($chpcs_pre_responsive==1){ ?> width: <?php echo $wa_chpcs_query_posts_item_width;?>, <?php } ?>
					<?php if($chpcs_pre_responsive==0&&$wa_chpcs_pre_direction=="up"||$wa_chpcs_pre_direction=="down"){ echo "visible:".$c_min_items.","; }?>   
					<?php if($chpcs_pre_responsive==1){ ?>                                                 
					visible: {
					min: 1,
					max:<?php echo $c_min_items; ?>,
					} <?php } ?>
				},
				pagination: {
				container: '#wa_chpcs_pager_<?php echo $id; ?>'
				}
			}
			<?php if($wa_chpcs_query_css_transitions==1){ ?>
			,{transition:true }

			<?php } ?>
			);   

			
			//touch swipe
			jQuery("#wa_chpcs_foo<?php echo $id; ?>").swipe({ 
			excludedElements: "button, input, select, textarea, .noSwipe", 
			<?php 	if($wa_chpcs_pre_direction=="up"||$wa_chpcs_pre_direction=="down") { ?>swipeUp<?php } else { ?>swipeLeft<?php } ?>: function() { 
			jQuery('#wa_chpcs_foo<?php echo $id; ?>').trigger('next', 'auto'); 
			}, 
			<?php 	if($wa_chpcs_pre_direction=="up"||$wa_chpcs_pre_direction=="down") { ?>swipeDown<?php } else { ?>swipeRight<?php } ?>: function() { 
			jQuery('#wa_chpcs_foo<?php echo $id; ?>').trigger('prev', 'auto'); 
			console.log("swipeRight"); 
			}, 
			tap: function(event, target) { 
			jQuery(target).closest('.wa_chpcs_slider_title').find('a').click(); 
			}
			});

			//lazy loading
			<?php if($wa_chpcs_query_lazy_loading){ ?>
			function loadImage() {
			jQuery("img.wa_lazy").lazyload({
			container: jQuery("#wa_chpcs_image_carousel<?php echo $id; ?>")
			});
			}
			<?php } ?>
			//magnific popup
			<?php if($wa_chpcs_query_posts_lightbox) { ?>
			jQuery('#wa_chpcs_foo<?php echo $id; ?>').magnificPopup({
			delegate: 'li .wa_featured_img > a', // child items selector, by clicking on it popup will open
			type: 'image'
			// other options
			});
			<?php } ?>

			//animation for next and prev
			<?php if($wa_chpcs_query_animate_controls==1) { if($wa_chpcs_pre_direction=="left"||$wa_chpcs_pre_direction=="right") { ?>
			jQuery('#wa_chpcs_image_carousel<?php echo $id; ?>')
		    .hover(function() {
		        jQuery('#wa_chpcs_image_carousel<?php echo $id; ?> .wa_chpcs_prev').animate({ 'left' : '1.2%', 'opacity' : 1 }), 300;
		        jQuery('#wa_chpcs_image_carousel<?php echo $id; ?> .wa_chpcs_next').animate({ 'right' : '1.2%', 'opacity' : 1 }), 300;
		    }, function() {
		        jQuery('#wa_chpcs_image_carousel<?php echo $id; ?> .wa_chpcs_prev').animate({ 'left' : 0, 'opacity' : 0 }), 'fast';
		        jQuery('#wa_chpcs_image_carousel<?php echo $id; ?> .wa_chpcs_next').animate({ 'right' : 0, 'opacity' : 0 }), 'fast';
		    });
	    <?php } } ?>

		});
		</script>
		<?php

		if($qp_order=="rand") {  

			$qp_orderby="rand"; 
		}

		$post_ids=explode(',', $qp_category);

		$args = array( 'numberposts' => $qp_showposts, 'suppress_filters' => false,  'post__in' => $post_ids,'post_status' => 'publish', 'order'=> $qp_order,  'orderby' => $qp_orderby,  'post_type' => $qp_post_type);
		
		$args_custom_post_type_only =  array( 'posts_per_page' => $qp_showposts, 'suppress_filters' => false, 'post_status' => 'publish', 'product_cat' => '', 'order'=> $qp_order, 'orderby' => $qp_orderby, 'post_type' => $qp_post_type);	
		
		$args_custom = array(
		 	'posts_per_page' => $qp_showposts,
		    'post_type' => $qp_post_type,
		    'order'=> $qp_order, 
		    'orderby' => $qp_orderby,
		    'suppress_filters' => false,
		    'post_status'  => 'publish',
		    'tax_query' => array(
		                array(
		                    'taxonomy' => $taxonomy,
		                    'field' => 'slug',
		                    'terms' => $terms
		                )
		            )
		    );

		//get specific posts
		if($qp_category&&$qp_post_type) {

			$myposts_posts = get_posts($args);
		
		}

			if($qp_post_type=='post') {

			 if($content_type=='newest') {

				$args = array(  
				'post_type' => $qp_post_type,  
				'orderby' =>'date','order' => 'DESC',
				'suppress_filters' => false,
				'posts_per_page' => $qp_showposts,
				'post_status'  => 'publish',
				'stock' => 1
				);  
	  
				$myposts_custom = get_posts( $args );

			} else if($content_type=='related') {


				$myposts_custom = get_posts($this->wa_get_related_posts(get_the_ID(),$qp_showposts ));

							
			} else if($content_type=='most_viewed') {

						$args_custom = array(
					'posts_per_page' => $qp_showposts,
					'post_type' => $qp_post_type,
					'order'=> 'DESC', 
					'suppress_filters' => false,
					'meta_key' =>'post_views_count',
					'orderby' => 'meta_value_num',
					'post_status'  => 'publish'
					);
				$myposts_custom = get_posts( $args_custom );



			} else if($content_type=='category') {
			
					$arr = array();
					
					//foreach ($terms as $key => $value) {

					$args_custom = array(
					'posts_per_page' => $qp_showposts,
					'post_type' => $qp_post_type,
					'order'=> $qp_order, 
					'suppress_filters' => false,
					'orderby' => $qp_orderby,
					'post_status'  => 'publish',
					'tax_query' => array(
					array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $terms)));

					$temp_arr	=	get_posts( $args_custom );
					$arr = array_merge($arr,$temp_arr);

					//}
				
				$myposts_custom = $arr;

			} else if($content_type=='tag') {

				$args_custom = array(
					'posts_per_page' => $qp_showposts,
					'post_type' => $qp_post_type,
					'order'=> $qp_order, 
					'suppress_filters' => false,
					'orderby' => $qp_orderby,
					'post_status'  => 'publish',
								    'tax_query' => array(
	   					'relation' => 'OR',
                        array(
                                'taxonomy' => 'post_tag',
                                'field' => 'slug',
                                'terms' => $tags
                        )
			            )
					);
				
				$myposts_custom = get_posts( $args_custom );

			}

		}else if($qp_post_type&&$taxonomy&&$terms) {

			$myposts_custom = get_posts( $args_custom );

		} else if($qp_post_type&&!$taxonomy&&!$qp_category) {

			$myposts_custom = get_posts($args_custom_post_type_only);

		}

	
		if(isset($myposts_posts)&&isset($myposts_custom)) {

			$myposts = array_merge($myposts_posts,$myposts_custom );

		}else if(isset($myposts_posts)) {

			$myposts = $myposts_posts;

		}else if(isset($myposts_custom)) {

			$myposts = $myposts_custom;

		}
			
		if(!isset($myposts)||empty($myposts)){ 

			return false;
		}
		$slider_gallery = '';

		//include theme
		include $this->wa_chpcs_file_path($slider_template);

		wp_reset_postdata(); 
		
		return $slider_gallery;
			
	}

	// view path for the theme files
	public function wa_chpcs_file_path( $view_name, $is_php = true ) {

		$temp_path = get_stylesheet_directory().'/carousel-horizontal-posts-content-slider-pro/themes/';

		if(file_exists($temp_path)) {

			if ( strpos( $view_name, '.php' ) === FALSE && $is_php )
		return $temp_path.'/'.$view_name.'/'.$view_name.'.php';
		return $temp_path . $view_name;

		} else {

			if ( strpos( $view_name, '.php' ) === FALSE && $is_php )
		return WA_CHPCS_PLUGIN_TEMPLATE_DIRECTORY.'/'.$view_name.'/'.$view_name.'.php';
		return WA_CHPCS_PLUGIN_TEMPLATE_DIRECTORY . $view_name;
		}

	}

	//get related posts
	public function wa_get_related_posts( $post_id, $related_count, $args = array() ) {
	    $args = wp_parse_args( (array) $args, array(
	        'orderby' => 'rand',
	        'return'  => 'query', // Valid values are: 'query' (WP_Query object), 'array' (the arguments array)
	    ) );
	 
	    $related_args = array(
	        'post_type'      => get_post_type( $post_id ),
	        'posts_per_page' => $related_count,
	        'post_status'    => 'publish',
	        'post__not_in'   => array( $post_id ),
	        'orderby'        => $args['orderby'],
	        'suppress_filters' => false,
	        'tax_query'      => array()
	    );
	 
	    $post       = get_post( $post_id );
	    $taxonomies = get_object_taxonomies( $post, 'names' );
	 
	    foreach( $taxonomies as $taxonomy ) {
	        $terms = get_the_terms( $post_id, $taxonomy );
	        if ( empty( $terms ) ) continue;
	        $term_list = wp_list_pluck( $terms, 'slug' );
	        $related_args['tax_query'][] = array(
	            'taxonomy' => $taxonomy,
	            'field'    => 'slug',
	            'terms'    => $term_list
	        );
	    }
	 
	    if( count( $related_args['tax_query'] ) > 1 ) {
	        $related_args['tax_query']['relation'] = 'OR';
	    }
	 
	    if( $args['return'] == 'query' ) {
	        return $related_args ;
	    } else {
	        return $related_args;
	    }
	}

	//remove default auto save
	function wa_chpcs_disable_autosave() {

	    global $post;
	    if(isset($post->ID)&&get_post_type($post->ID) == 'wa_chpcs'){
	        wp_dequeue_script('autosave');
	    }
	}

	//remove default publish box of the custom post type 
	function wa_chpcs_remove_publish_box() {

    	remove_meta_box( 'submitdiv', 'wa_chpcs', 'side' );
	
	}

	//add metaboxes to the page
	function wa_chpcs_add_meta_boxes() {

	add_meta_box('wa_chpcs_custom_publish_meta_box',__( 'Save', 'chpcs' ),array( $this, 'wa_chpcs_custom_publish_meta_box' ),'wa_chpcs','side');
	add_meta_box('wa_chpcs_shortcode_meta_box',__( 'Shortcode', 'chpcs' ),array( $this, 'wa_chpcs_shortcode_meta_box' ),'wa_chpcs','side');
	add_meta_box('wa_chpcs_options_metabox',__( 'Options', 'chpcs' ),array( $this, 'wa_chpcs_options_meta_box' ),'wa_chpcs');

	}

	//custom publish meta box
	function wa_chpcs_custom_publish_meta_box( $post ) {

		$slider_id = $post->ID;
		$post_status = get_post_status( $slider_id );
		$delete_link = get_delete_post_link( $slider_id );
		$nonce = wp_create_nonce( 'ssp_slider_nonce' );
		include $this->wa_chpcs_view_path( __FUNCTION__ );
	}


	//publish meta box
	function wa_rs_custom_publish_meta_box( $post ) {

		$slider_id = $post->ID;
		$post_status = get_post_status( $slider_id );
		$delete_link = get_delete_post_link( $slider_id );
		$nonce = wp_create_nonce( 'ssp_slider_nonce' );
		include $this->wa_chpcs_view_path( __FUNCTION__ );
	}

	//short code meta box
	function wa_chpcs_shortcode_meta_box( $post ) {
		$slider_id = $post->ID;
		if ( get_post_status( $slider_id ) !== 'publish' ) {

			echo __( '<p>Please, fill the required fields. Then click on the Create Slider button to get the slider shortcode.</p>', 'chpcs' );
			return;
		}
		$slider_title = get_the_title( $slider_id );
		$shortcode = sprintf( "[%s id='%s']", 'carousel-horizontal-posts-content-slider-pro', $slider_id, $slider_title );
		$template_code = sprintf( "<?php echo do_shortcode('[%s id=%s]');?>", 'carousel-horizontal-posts-content-slider-pro', $slider_id, $slider_title );
		include $this->wa_chpcs_view_path( __FUNCTION__ );
	}

	//set options meta box
	function wa_chpcs_options_meta_box( $post ) {
		$slider_id = $post->ID;

		$slider_options = get_post_meta( $slider_id, 'options', true );

		if ( ! $slider_options )
			$slider_options = self::default_options();

		include $this->wa_chpcs_view_path( __FUNCTION__ );
	}


	//view path for the template files
	function wa_chpcs_view_path( $view_name, $is_php = true ) {

	if ( strpos( $view_name, '.php' ) === FALSE && $is_php )
		return WA_CHPCS_PLUGIN_VIEW_DIRECTORY.$view_name.'.php';
		
		return WA_CHPCS_PLUGIN_VIEW_DIRECTORY . $view_name;
	}

	//register setting for admin page 
	public function register_settings() {

		register_setting('wa_chpcs_settings', 'wa_chpcs_settings', array(&$this, 'validate_options'));
		//general settings
		add_settings_section('wa_chpcs_settings', __('', 'chpcs'), '', 'wa_chpcs_settings');
		add_settings_field('wa_chpcs_loading_place', __('Loading place:', 'chpcs'), array(&$this, 'wa_chpcs_loading_place'), 'wa_chpcs_settings', 'wa_chpcs_settings');
		add_settings_field('wa_chpcs_jquery', __('Load jQuery:', 'chpcs'), array(&$this, 'wa_chpcs_jquery'), 'wa_chpcs_settings', 'wa_chpcs_settings');
		add_settings_field('wa_chpcs_transit', __('Load transit:', 'chpcs'), array(&$this, 'wa_chpcs_transit'), 'wa_chpcs_settings', 'wa_chpcs_settings');
		add_settings_field('wa_chpcs_magnific_popup', __('Magnific popup:', 'chpcs'), array(&$this, 'wa_chpcs_magnific_popup'), 'wa_chpcs_settings', 'wa_chpcs_settings');
		add_settings_field('wa_chpcs_caroufredsel', __('CarouFredsel:', 'chpcs'), array(&$this, 'wa_chpcs_caroufredsel'), 'wa_chpcs_settings', 'wa_chpcs_settings');
		add_settings_field('wa_chpcs_lazyload', __('Lazyload:', 'chpcs'), array(&$this, 'wa_chpcs_lazyload'), 'wa_chpcs_settings', 'wa_chpcs_settings');
		add_settings_field('wa_chpcs_touch_swipe', __('TouchSwipe:', 'chpcs'), array(&$this, 'wa_chpcs_touch_swipe'), 'wa_chpcs_settings', 'wa_chpcs_settings');
		add_settings_field('wa_chpcs_deactivation_delete', __('Deactivation:', 'chpcs'), array(&$this, 'wa_chpcs_deactivation_delete'), 'wa_chpcs_settings', 'wa_chpcs_settings');

	}

	//loading place
	public function wa_chpcs_loading_place() {
		echo '
		<div id="wa_chpcs_loading_place" class="wplikebtns">';

		foreach($this->loading_places as $val => $trans)
		{
			$val = esc_attr($val);

			echo '
			<input id="rll-loading-place-'.$val.'" type="radio" name="wa_chpcs_settings[loading_place]" value="'.$val.'" '.checked($val, $this->options['settings']['loading_place'], false).' />
			<label for="rll-loading-place-'.$val.'">'.esc_html($trans).'</label>';
		}

		echo '
			<p class="description">'.__('Select where all the scripts should be placed.', 'chpcs').'</p>
		</div>';
	}

	//delete on deactivation
	public function wa_chpcs_deactivation_delete() {
		echo '
		<div id="rll_deactivation_delete" class="wplikebtns">';

		foreach($this->choices as $val => $trans) {
			echo '
			<input id="rll-deactivation-delete-'.$val.'" type="radio" name="wa_chpcs_settings[deactivation_delete]" value="'.esc_attr($val).'" '.checked(($val === 'yes' ? TRUE : FALSE), $this->options['settings']['deactivation_delete'], FALSE).' />
			<label for="rll-deactivation-delete-'.$val.'">'.$trans.'</label>';
		}

		echo '
			<p class="description">'.__('Delete settings on plugin deactivation.', 'chpcs').'</p>
		</div>';
	}

	//enable jquery
	public function wa_chpcs_jquery() {
		echo '
		<div id="wa_chpcs_jquery" class="wplikebtns">';

	foreach($this->choices as $val => $trans)
		{
			$val = esc_attr($val);

			echo '
			<input id="jquery-'.$val.'" type="radio" name="wa_chpcs_settings[jquery]" value="'.esc_attr($val).'" '.checked(($val === 'yes' ? TRUE : FALSE), $this->options['settings']['jquery'], false).' />
			<label for="jquery-'.$val.'">'.esc_html($trans).'</label>';
		}

		echo '
			<p class="description">'.__('Enable this option, if you dont have jQuery on your website.', 'chpcs').'</p>
		</div>';
	}

	//load transit
	public function wa_chpcs_transit() {
		echo '
		<div id="wa_chpcs_transit" class="wplikebtns">';

	foreach($this->choices as $val => $trans)
		{
			$val = esc_attr($val);

			echo '
			<input id="transit-'.$val.'" type="radio" name="wa_chpcs_settings[transit]" value="'.esc_attr($val).'" '.checked(($val === 'yes' ? TRUE : FALSE), $this->options['settings']['transit'], false).' />
			<label for="transit-'.$val.'">'.esc_html($trans).'</label>';
		}

		echo '
			<p class="description">'.__('Disable this option, if this script has already loaded on your web site.', 'chpcs').'</p>
		</div>';
	}

	//load magnific popup
	public function wa_chpcs_magnific_popup() {
		echo '
		<div id="wa_chpcs_magnific_popup" class="wplikebtns">';

		foreach($this->choices as $val => $trans)
		{
			$val = esc_attr($val);

			echo '
			<input id="magnific-popup-'.$val.'" type="radio" name="wa_chpcs_settings[magnific_popup]" value="'.esc_attr($val).'" '.checked(($val === 'yes' ? TRUE : FALSE), $this->options['settings']['magnific_popup'], false).' />
			<label for="magnific-popup-'.$val.'">'.esc_html($trans).'</label>';
		}

		echo '
			<p class="description">'.__('Disable this option, if this script has already loaded on your web site.', 'chpcs').'</p>
		</div>';
	}

	//load caroufredsel
	public function wa_chpcs_caroufredsel() {
		echo '
		<div id="wa_chpcs_caroufredsel" class="wplikebtns">';

		foreach($this->choices as $val => $trans)
		{
			$val = esc_attr($val);

			echo '
			<input id="caroufredsel-'.$val.'" type="radio" name="wa_chpcs_settings[caroufredsel]" value="'.esc_attr($val).'" '.checked(($val === 'yes' ? TRUE : FALSE), $this->options['settings']['caroufredsel'], false).' />
			<label for="caroufredsel'.$val.'">'.esc_html($trans).'</label>';
		}

		echo '
			<p class="description">'.__('Disable this option, if this script has already loaded on your web site.', 'chpcs').'</p>
		</div>';
	}

	//load lazy load
	public function wa_chpcs_lazyload() {

		echo '
		<div id="wa_chpcs_lazyload" class="wplikebtns">';

		foreach($this->choices as $val => $trans)
		{
			$val = esc_attr($val);

			echo '
			<input id="lazyload-'.$val.'" type="radio" name="wa_chpcs_settings[lazyload]" value="'.esc_attr($val).'" '.checked(($val === 'yes' ? TRUE : FALSE), $this->options['settings']['lazyload'], false).' />
			<label for="lazyload-'.$val.'">'.esc_html($trans).'</label>';
		}

		echo '
			<p class="description">'.__('Disable this option, if this script has already loaded on your web site.', 'chpcs').'</p>
		</div>';
	}


	//touch swipe
	public function wa_chpcs_touch_swipe() {

		echo '
		<div id="wa_chpcs_touch_swipe" class="wplikebtns">';

		foreach($this->choices as $val => $trans)
		{
			$val = esc_attr($val);

			echo '
			<input id="touchswipe-'.$val.'" type="radio" name="wa_chpcs_settings[touchswipe]" value="'.esc_attr($val).'" '.checked(($val === 'yes' ? TRUE : FALSE), $this->options['settings']['touchswipe'], false).' />
			<label for="touchswipe-'.$val.'">'.esc_html($trans).'</label>';
		}

		echo '
			<p class="description">'.__('Disable this option, if this script has already loaded on your web site.', 'chpcs').'</p>
		</div>';

	}

	//get all post types
	public function get_post_types() {

		$post_types = get_post_types( '', 'names' ); 

		return $post_types;

	}

	//list of directories
	public function list_themes() {

		$temp_path = get_stylesheet_directory().'/carousel-horizontal-posts-content-slider-pro/themes/';

		if(file_exists($temp_path)) {

			$dir = new DirectoryIterator($temp_path);

		} else {

			$dir = new DirectoryIterator(WA_CHPCS_PLUGIN_TEMPLATE_DIRECTORY);
		}

		foreach ($dir as $fileinfo) {
		if ($fileinfo->isDir() && !$fileinfo->isDot()) {
		$list_of_themes[] = $fileinfo->getFilename();
			}
		}
		return $list_of_themes;

	}

	//get post categories
	//get product categories
	public function get_post_category_first_name($qp_post_type, $post_id) {

		$first_cat_name = ' ';
				//get product category name
		if($qp_post_type=='product') {

			$args = array( 'taxonomy' => 'product_cat',);
			$terms = wp_get_post_terms($post_id,'product_cat', $args);

			$first_cat_name = $terms[0]->name;

		} else {

			$category = get_the_category($post_id);
			$first_cat_name = !empty($category) ? $category[0]->cat_name : '';

		}

		return $first_cat_name;
	}

	//get post category id
	public function get_post_category_id($qp_post_type, $post_id) {

		$first_cat_name = ' ';
				//get product category name
		if($qp_post_type=='product') {

			$args = array( 'taxonomy' => 'product_cat',);
			$terms = wp_get_post_terms($post_id,'product_cat', $args);

			$first_cat_name = $terms[0]->term_id;

		} else {

			$category = get_the_category($post_id);
			$first_cat_name = !empty($category) ? $category[0]->term_id : '';

		}

		return $first_cat_name;
	}

	//get text type to display
	public function get_text_type($wa_post, $wa_chpcs_query_display_from_excerpt) {

		$text_type = '';

		if($wa_chpcs_query_display_from_excerpt==1) {

			$text_type = $wa_post->post_excerpt;
		} else {

			$text_type = $wa_post->post_content;

		}

		return $text_type;

	}

	//options page
	public function options_page() {

		$tab_key = (isset($_GET['tab']) ? $_GET['tab'] : 'general-settings');

		echo '<div class="wrap">'.screen_icon().'
			<h2>'.__('Carousel horizontal posts content slider pro', 'chpcs').'</h2>
			<h2 class="nav-tab-wrapper">';

		foreach($this->tabs as $key => $name) {
			echo '
			<a class="nav-tab '.($tab_key == $key ? 'nav-tab-active' : '').'" href="'.esc_url(admin_url('admin.php?page=carousel-horizontal-posts-content-slider-pro&tab='.$key)).'">'.$name['name'].'</a>';
		}

		echo '
			</h2>
			<div class="wa-chpcs-settings">
				<div class="wa-credits">
					<h3 class="hndle">'.__('Useful links', 'chpcs').'</h3>
					<div class="inside">

					<table>

						<tr>

						<td>'.__('Documentation:  ', 'chpcs') .'</td>
						<td><a href="http://doc.weaveapps.com/carousel-horizontal-posts-content-slider-pro/" target="_blank" title="'.__(' documentation', 'chpcs').'">'.__('  Documentation', 'chpcs').'</a></td>

						</tr>

						<tr>

						<td>'.__('Author URI:  ', 'chpcs').'</td>
						<td><a href="http://weaveapps.com/" target="_blank" title="'.__('author URI', 'chpcs').'">'.__(' Weave Apps', 'chpcs').'</a></td>

						</tr>

						<tr>

						<td>'.__('Support:  ', 'chpcs') .'</td>
						<td><a href="http://weaveapps.com/contact/" target="_blank" title="'.__(' support', 'chpcs').'">'.__('  Support', 'chpcs').'</a></td>	</tr>

						<tr>

					</table>
					
				</div>
				</div><form action="options.php" method="post">';

		wp_nonce_field('update-options');
		settings_fields($this->tabs[$tab_key]['key']);
		do_settings_sections($this->tabs[$tab_key]['key']);

		echo '<p class="submit">';
		submit_button('', 'primary', $this->tabs[$tab_key]['submit'], FALSE);
		echo ' ';
		echo submit_button(__('Reset to defaults', 'chpcs'), 'secondary', $this->tabs[$tab_key]['reset'], FALSE);
		echo '</p></form></div><div class="clear"></div></div>';
	}

	//load defaults
	public function load_defaults() {
		
		$this->choices = array(
			'yes' => __('Enable', 'chpcs'),
			'no' => __('Disable', 'chpcs')
		);

		$this->loading_places = array(
			'header' => __('Header', 'chpcs'),
			'footer' => __('Footer', 'chpcs')
		);

		$this->tabs = array(
			'general-settings' => array(
				'name' => __('General settings', 'chpcs'),
				'key' => 'wa_chpcs_settings',
				'submit' => 'save_chpcs_settings',
				'reset' => 'reset_chpcs_settings',
			)
		);
	}

	//default options
	public static function default_options() {

		$default_img = plugins_url().'/carousel-horizontal-posts-content-slider-pro/assets/images/default-image.jpg'; // default image
		$loading_img = plugins_url().'/carousel-horizontal-posts-content-slider-pro/assets/images/loader.gif'; // loading image
		$hover_img = plugins_url().'/carousel-horizontal-posts-content-slider-pro/assets/images/hover.png'; // loading image

		$default_options = array(
			'post_type' => '',
			'content_type' => '',
			'post_taxonomy' => '',
			'post_terms' => '',
			'post_ids' => '',
			'posts_order_by' => 'id',
			'post_order' => 'asc',
			'template' => 'basic',
			'image_hover_effect' => 'none',
			'read_more_text' => 'Read more',
			'word_limit' => '10',
			'show_posts' => '20',
			'show_posts_per_page' => '4',
			'items_to_be_slide' => '0',
			'duration' => '500',
			'item_width' => '200',
			'item_height' => '350',
			'post_image_width' => '200',
			'post_image_height' => '',
			'image_type' => 'featured',
			'easing_effect' => 'linear',
			'fx' => 'scroll',
			'align_items' => 'center',
			'font_colour' => '#000',
			'control_colour' => '#fff',
			'control_bg_colour' => '#000',
			'arrows_hover_colour' => '#ccc',
			'size_arrows' => '18',
			'title_font_size' => '14',
			'font_size' => '12',
			'default_image' => $default_img,
			'lazy_load_image' => $loading_img,
			'show_title' => true,
			'show_image' => true,
			'show_excerpt' => true,
			'title_top_of_image' => true,
			'show_read_more_text' => true,
			'excerpt_type' => false,
			'responsive' => false,
			'lightbox' => false,
			'lazy_loading' => false,
			'auto_scroll' => true,
			'draggable' => true,
			'circular' => false,
			'infinite' => true,
			'touch_swipe' => true,
			'direction' => 'right',
			'show_controls' => true,
			'animate_controls' => true,
			'show_paging' => true,
			'css_transitions' => true,
			'pause_on_hover' => true,
			'timeout' => '3000',
			'start_date' => '',
			'end_date' => '',
			'hover_image_bg' => 'rgba(40,168,211,.85)',
			'hover_image_url' => $hover_img,
			'text_align' => 'left',
			'image_size' => 'other',
			'image_align' => 'left',
		);

		return apply_filters( 'wa_chpcs_default_options', $default_options );

	}

	//validate options and register settings
	public function validate_options($input) {

		if(isset($_POST['save_chpcs_settings'])) {

			// loading place
			$input['loading_place'] = (isset($input['loading_place'], $this->loading_places[$input['loading_place']]) ? $input['loading_place'] : $this->defaults['settings']['loading_place']);

			// checkboxes
			$input['caroufredsel'] = (isset($input['caroufredsel'], $this->choices[$input['caroufredsel']]) ? ($input['caroufredsel'] === 'yes' ? true : false) : $this->defaults['settings']['caroufredsel']);
			$input['magnific_popup'] = (isset($input['magnific_popup'], $this->choices[$input['magnific_popup']]) ? ($input['magnific_popup'] === 'yes' ? true : false) : $this->defaults['settings']['magnific_popup']);
			$input['lazyload'] = (isset($input['lazyload'], $this->choices[$input['lazyload']]) ? ($input['lazyload'] === 'yes' ? true : false) : $this->defaults['settings']['lazyload']);
			$input['touchswipe'] = (isset($input['touchswipe'], $this->choices[$input['touchswipe']]) ? ($input['touchswipe'] === 'yes' ? true : false) : $this->defaults['settings']['touchswipe']);
			$input['jquery'] = (isset($input['jquery'], $this->choices[$input['jquery']]) ? ($input['jquery'] === 'yes' ? true : false) : $this->defaults['settings']['jquery']);
			$input['transit'] = (isset($input['transit'], $this->choices[$input['transit']]) ? ($input['transit'] === 'yes' ? true : false) : $this->defaults['settings']['transit']);
			$input['deactivation_delete'] = (isset($input['deactivation_delete'], $this->choices[$input['deactivation_delete']]) ? ($input['deactivation_delete'] === 'yes' ? true : false) : $this->defaults['settings']['deactivation_delete']);
		

		} else if (isset($_POST['reset_chpcs_settings'])) {
			$input = $this->defaults['settings'];

			add_settings_error('reset_general_settings', 'general_reset', __('Settings restored to defaults.', 'chpcs'), 'updated');
		}

		return $input;
	}

	//init process for registering button
	public function wa_chpcs_shortcode_button_init() {

	      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
	           return;
   
	      add_filter("mce_external_plugins", array(&$this, 'wa_chpcs_register_tinymce_plugin'));

	      add_filter('mce_buttons', array(&$this, 'wa_chpcs_add_tinymce_button'));
	}


	//registers plugin  to TinyMCE
	public function wa_chpcs_register_tinymce_plugin($plugin_array) {

	    $plugin_array['wa_chpcs_button'] = plugins_url('assets/js/shortcode/shortcode.js', __FILE__);

	    return $plugin_array;
	}

	//add button to the toolbar
	public function wa_chpcs_add_tinymce_button($buttons) {

	    $buttons[] = "wa_chpcs_button";

	    return $buttons;
	}

	//register post type for the slider
	function wa_chpcs_init() {

	  $labels = array(
	        'name' => _x('Carousel horizontal posts content slider pro', 'post type general name'),
	        'singular_name' => _x('slider', 'post type singular name'),
	        'add_new' => _x('Add New', 'wa_rs_slider'), 
	        'add_new_item' => __('Add new slider'),
	        'edit_item' => __('Edit slider'),
	        'new_item' => __('New slider'),
	        'view_item' => __('View slider'),
	        'search_items' => __('Search sliders'),
	        'not_found' => __('No records found'),
	        'not_found_in_trash' => __('No records found in Trash'),
	        'parent_item_colon' => '',
	        'menu_name' => 'CHPC slider'
	    );

	    $args = array(
	        'labels' => $labels,
	        'public' => false,
	        'menu_icon' => plugins_url('/assets/js/shortcode/b_img.png', __FILE__),
	        'publicly_queryable' => false,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'menu_position' => 5,
	        'query_var' => false,
	        'rewrite' => false,
	        'capability_type' => 'post',
	        'has_archive' => true,
	        'hierarchical' => false,
	        'supports' => array('title')
	    );

	    register_post_type('wa_chpcs', $args);
	}

	//update messages
	function wa_chpcs_updated_messages($messages) {

	    global $post, $post_ID;
	    $messages['wa_chpcs'] = array(
	        0 => '',
	        1 => sprintf(__('Slider updated.'), esc_url(get_permalink($post_ID))),
	        2 => __('Custom field updated.'),
	        3 => __('Custom field deleted.'),
	        4 => __('Slider updated.'),
	        5 => isset($_GET['revision']) ? sprintf(__('Slider restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
	        6 => sprintf(__('Slider published.'), esc_url(get_permalink($post_ID))),
	        7 => __('Slider saved.'),
	        8 => sprintf(__('Slider submitted.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
	        9 => sprintf(__('Slider scheduled for: <strong>%1$s</strong>. '), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
	        10 => sprintf(__('Slider draft updated.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
	    );
	    return $messages;

	}

	//save data
	function wa_chpcs_save_metabox_data ($post_id) {

		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		if ( wp_is_post_revision( $post_id ) )
			return;
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		
		if ( ! isset( $_POST['post_type_is_wa_chpcs'] ) )
			return;

			$slider_id = $post_id;

			$slider_options_default = self::default_options();
			$slider_options = wp_parse_args( $_POST['slider_options'],   $slider_options_default );
			$slider_options = $_POST['slider_options'];

			foreach ( $slider_options as $key => $option ):
				if ( $option === "true" )
					$slider_options[$key] = true;
				if ( $option === "false" )
					$slider_options[$key] = false;
			endforeach;

			update_post_meta( $slider_id, 'options', $slider_options );
	}

}

$carousel_horizontal_posts_content_slider_pro = new Carousel_Horizontal_Posts_Content_Slider_Pro();

require_once('includes/wp-updates-plugin.php');
new WPUpdatesPluginUpdater_781( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));