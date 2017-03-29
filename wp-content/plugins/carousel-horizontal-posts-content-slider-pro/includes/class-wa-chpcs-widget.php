<?php
class WA_CHPCS_Widget extends WP_Widget {


	// constructor
	function wa_chpcs_widget() {
			parent::__construct(false, $name = __('CHPC Slider Widget', 'wa_chpcs_widget') );
	}

	// widget form creation
	function form($instance) {

	// Check values
	if( $instance) {
	     $title = esc_attr($instance['title']);
	     $slider_id = esc_attr($instance['slider_id']);
	} else {
	     $title = '';
	     $slider_id = '';
	}
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('slider_id'); ?>"><?php _e('Slider ID:', 'wp_widget_plugin'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('slider_id'); ?>" name="<?php echo $this->get_field_name('slider_id'); ?>" type="text" value="<?php echo $slider_id; ?>" />
	</p>
	<?php
	}

// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['slider_id'] = strip_tags($new_instance['slider_id']);
     return $instance;
}

// display widget
function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $title = apply_filters('widget_title', $instance['title']);
   $slider_id = $instance['slider_id'];
   echo $before_widget;
   // Display the widget
   echo '<div class="widget-text wp_widget_plugin_box">';

   // Check if title is set
   if ( $title ) {
      echo $before_title . $title . $after_title;
   }

   // Check if text is set
   if( $slider_id ) {
      echo do_shortcode('[carousel-horizontal-posts-content-slider-pro id="'.$slider_id.'"]');
   }
   echo '</div>';
   echo $after_widget;
}


}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("wa_chpcs_widget");'));
?>