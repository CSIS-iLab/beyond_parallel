<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       etuckerharris.com
 * @since      1.0.0
 *
 * @package    Social_Share_Minimalist
 * @subpackage Social_Share_Minimalist/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

	<h2><?php echo esc_html(get_admin_page_title()); ?></h2>

	<form method="post" name="social_options" action="options.php">
		<?php
        //Grab all options
		$options = get_option($this->plugin_name);

        // Social Options
		$includeFacebook = $options['includeFacebook'];
		$includeTwitter = $options['includeTwitter'];
		$includeGoogle = $options['includeGoogle'];
		$includePinterest = $options['includePinterest'];
		$includeLinkedin = $options['includeLinkedin'];

    	$background_color = $options['background_color'];
		?>

		<?php
		settings_fields($this->plugin_name);
		do_settings_sections($this->plugin_name);
		


		 // Include tabs partials
			require_once('social-share-minimalist-settings.php');
			?>

		<?php submit_button('Save all', 'primary','submit', TRUE); ?>

	</form>

</div>
