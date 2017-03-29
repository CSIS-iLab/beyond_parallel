<?php if(!defined('ABSPATH')) die('Direct access denied.'); ?>

<div class="wa-chpcs-field">
<label for="shortcode_text_input"><?php _e('Your Shortcode:', 'chpcs'); ?> </label>
<input readonly="true" id="shortcode_text_input" type="text" class="widefat" name="" value="<?php echo esc_attr($shortcode); ?>" />
<span class="note"><?php _e('Copy and paste this shortcode into your Post, Page or Custom Post editor.', 'chpcs'); ?></span>
<div class="clear"></div>
<hr/>
<label for="php_shortcode_text_input"><?php _e('Your PHP Code:', 'chpcs'); ?> </label>
<input readonly="true" id="php_shortcode_text_input" type="text" class="widefat" name="" value="<?php echo esc_attr($template_code); ?>" />
<span class="note"><?php _e('Copy and paste this code when you need to display the slider in template files (header.php, front-page.php, etc.).', 'wps'); ?></span>
<div class="clear"></div><br/>
<span class="note"><?php _e('Note: You could also use the shortcode icon on the post text editer to generate short code. Sliders can also be added to available widget area using widget option', 'wps'); ?></span>

</div>
