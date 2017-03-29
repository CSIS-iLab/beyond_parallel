
		<h2><?php esc_attr_e( 'Social Media Inclusions', 'wp_admin_style' ); ?></h2>

		<fieldset>
			<legend class="screen-reader-text"><span>Include Facebook Icon</span></legend>
			<label for="<?php echo $this->plugin_name; ?>includeFacebook">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>includeFacebook" name="<?php echo $this->plugin_name; ?>[includeFacebook]" value="1" <?php checked($includeFacebook, 1); ?> />
				<span><?php esc_attr_e('Include Facebook Icon', $this->plugin_name); ?></span>
			</label>
		</fieldset>

		<fieldset>
			<legend class="screen-reader-text"><span>Include Twitter Icon</span></legend>
			<label for="<?php echo $this->plugin_name; ?>includeTwitter">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>includeTwitter" name="<?php echo $this->plugin_name; ?>[includeTwitter]" value="1" <?php checked($includeTwitter, 1); ?> />
				<span><?php esc_attr_e('Include Twitter Icon', $this->plugin_name); ?></span>
			</label>
		</fieldset>

				<fieldset>
			<legend class="screen-reader-text"><span>Include Google Icon</span></legend>
			<label for="<?php echo $this->plugin_name; ?>includeGoogle">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>includeGoogle" name="<?php echo $this->plugin_name; ?>[includeGoogle]" value="1" <?php checked($includeGoogle, 1); ?> />
				<span><?php esc_attr_e('Include Google Icon', $this->plugin_name); ?></span>
			</label>
		</fieldset>

				<fieldset>
			<legend class="screen-reader-text"><span>Include Pinterest Icon</span></legend>
			<label for="<?php echo $this->plugin_name; ?>includePinterest">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>includePinterest" name="<?php echo $this->plugin_name; ?>[includePinterest]" value="1" <?php checked($includePinterest, 1); ?> />
				<span><?php esc_attr_e('Include Pinterest Icon', $this->plugin_name); ?></span>
			</label>
		</fieldset>

				<fieldset>
			<legend class="screen-reader-text"><span>Include LinkedIn Icon</span></legend>
			<label for="<?php echo $this->plugin_name; ?>includeLinkedin">
				<input type="checkbox" id="<?php echo $this->plugin_name; ?>includeLinkedin" name="<?php echo $this->plugin_name; ?>[includeLinkedin]" value="1" <?php checked($includeLinkedin, 1); ?> />
				<span><?php esc_attr_e('Include LinkedIn Icon', $this->plugin_name); ?></span>
			</label>
		</fieldset>

		
		<h2><?php esc_attr_e( 'Background Color', 'wp_admin_style' ); ?></h2>

		 <fieldset class="ssm-admin-colors">
                <legend class="screen-reader-text"><span><?php _e('Background Color', $this->plugin_name);?></span></legend>
                <label for="<?php echo $this->plugin_name;?>background_color">
                    <input type="text" id="<?php echo $this->plugin_name; ?>background_color" name="<?php echo $this->plugin_name; ?>[background_color]" value="<?php echo $background_color;?>" class="cpa-color-picker" />
                    <span><?php esc_attr_e('', $this->plugin_name);?></span>
                </label>

            </fieldset>
            