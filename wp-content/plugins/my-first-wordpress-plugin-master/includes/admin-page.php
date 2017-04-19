<?php



function mfwp_add_options_link() {
	add_options_page('My First WordPress Plugin Options', 'My First Plugin', 'manage_options', 'mfwp-options', 'mfwp_settings_page');
}
add_action('admin_menu', 'mfwp_add_options_link');

function mfwp_settings_page()
{
    ?>
	    <div class="wrap">
	    <h1>Homepage Builder</h1>
	    
	    <form method="post" action="options.php">
	    
	    <div class="left_container">
	    <div class="scrollable">
	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options"); 
		?>
		</div>
		</div><!-- /left_container -->
		<div class="right_container">
		<h2>Homepage Post Order</h2>

			<div class="droppable-helper"></div>
			Featured Article
			
		</div> <!-- /right_container -->
		<div class="clearfix"></div>
		<?php  submit_button(); ?>
		</form>
		</div>
	<?php
}


function display_theme_panel_fields()
{
	add_settings_section("section", "All Posts", null, "theme-options");

			add_settings_field("search_box", "", "display_search_element", "theme-options", "section");
			register_setting("section", "search_box");

			global $post;
			$tmp_post = $post;

			//Only posts
			$args_post = array( 
				'numberposts' => 10000, 
				'category' => $e->cat_ID, 
				'orderby' => 'title', 
				'order' => 'ASC' );
			$myposts = get_posts( $args_post );

			
			foreach( $myposts as $post ) : setup_postdata($post);

			$postID = $post->ID;
			$postTitle = get_the_title();
			
			        $handle   = $postID;
			        $args     = array (
			            'label_for' => $handle,
			            'post_id'      => $postID,
			            'post_title' => $postTitle
			        );

			        add_settings_field(
			            $handle,
			            " ",
			            'display_posts_element',
			            'theme-options',
			            'section',
			            $args
			        );

			        register_setting("section", $handle);
			    
			endforeach;
			
			
			add_settings_field("position_array", "", "display_array_element", "theme-options", "section");
			register_setting("section", "position_array");

			add_settings_field("featured_post", "", "display_featured_element", "theme-options", "section");
			register_setting("section", "featured_post");


		/*add_settings_field("about_text", "About description ", "display_about_element", "theme-options", "section2");
			register_setting("section2", "about_text");*/


}
add_action("admin_init", "display_theme_panel_fields");

function display_search_element(){

	?>
    	<input type="text" name="search_box" id="search_box" size="35" value="" placeholder="Search for posts..."></input>
    <?php
}


function display_about_element(){

	?>
    	<textarea type="textarea" name="about_text" id="about_text" rows="6" cols="50" value="<?php echo get_option('about_text'); ?>"></textarea>
    <?php

}


function display_array_element(){

	?>
    	<input type="text" name="position_array" id="position_array" value="<?php echo get_option('position_array'); ?>" />
    <?php

}

function display_featured_element(){

	?>
    	<input type="text" name="featured_post" id="featured_post" value="<?php echo get_option('featured_post'); ?>" />
    <?php

}


function display_posts_element(array $args)
{

$id = $args['post_id'];
$title = $args['post_title'];
$post_output .= '<input id="'. $id .'" name="'. $id .'" class="'. $id .'" name="post" data-type="addThis" data-sort-position="0" data-name="'. $title .'" data-ID="' . $id .'" data-post-type="post" type="checkbox" value="1" '. checked(1, get_option($id), false) .'>';
    		$post_output .= '<label class="description">'. $title .'</label><br>';
    		print $post_output;

}	


function mfwp_register_settings() {
	// creates our settings in the options table
	register_setting('mfwp_settings_group', 'mfwp_settings');
}
add_action('admin_init', 'mfwp_register_settings');