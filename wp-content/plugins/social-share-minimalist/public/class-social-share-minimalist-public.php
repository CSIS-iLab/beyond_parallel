<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       etuckerharris.com
 * @since      1.0.0
 *
 * @package    Social_Share_Minimalist
 * @subpackage Social_Share_Minimalist/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Social_Share_Minimalist
 * @subpackage Social_Share_Minimalist/public
 * @author     Tucker Harris <#>
 */
class Social_Share_Minimalist_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->social_share_minimalist_options = get_option($this->plugin_name);

	}



	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/social-share-minimalist-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		 */

	          wp_enqueue_script( $this->plugin_name , plugins_url('js/social-share-minimalist-public.js', __FILE__ ), array( 'jquery' ), false, true );	
	}




	public function includeSocial($content){
		
if ( is_single( ) ) {

			if(!empty($this->social_share_minimalist_options['background_color'])){
				$background_color_css  = $this->social_share_minimalist_options['background_color'];
			}

			
			global $post;

			$html = "<div class='share-print-wrapper' ><div class='social-share-wrapper' ><div id='sharessm' class='share-on'>Share this page</div><div class='sharemedia'>";


			$url = get_permalink($post->ID);
			$url = esc_url($url);

			$title = get_the_title();
			$excerpt = get_the_excerpt();

			//$image = get_the_post_thumbnail_url();

			$html = $html . "<style>.ssmicon{background-color: ". $background_color_css ."; } .ssmicon:hover{  opacity:.7; } .sharemedia:before {	border-right: 7px solid ". $background_color_css .";}</style>";

    //Show Facebook
			if(!empty($this->social_share_minimalist_options['includeFacebook'])){
				$html = $html . "<div class='ssmicon'><a data-facebook='mobile' target='_blank' href='http://www.facebook.com/sharer.php?u=" . $url . "' rel='nofollow' alt='Share on Facebook'><div class='ssmfacebook'></div></a></div>";
			}
    //Show Twitter
			if(!empty($this->social_share_minimalist_options['includeTwitter'])){
				$html = $html . "<div class='ssmicon'><a href='http://twitter.com/share?url=" . $url . "&amp;text=" . $excerpt .  "' target='_blank' rel='nofollow' alt='Share on Twitter'><div class='ssmtwitter'></div></a></div>";
			}

    //Show Google+
			if(!empty($this->social_share_minimalist_options['includeGoogle'])){
				$html = $html . "<div class='ssmicon'><a href='https://plus.google.com/share?url=" . $url . "' target='_blank' rel='nofollow' alt='Share on Google+'><div class='ssmgoogle'></div></a></div>";
			}
    //ShowPinterest
			if(!empty($this->social_share_minimalist_options['includePinterest'])){
				$html = $html . "<div class='ssmicon'><a data-site='linkedin' href='http://pinterest.com/pin/create/bookmarklet/?is_video=false&url=" . $url . "&media=" . $image . "&description=" . $title . "' target='_blank' rel='nofollow' alt='Share on Pinterest'><div class='ssmpinterest'></div></a></div>";
			}
    //Show LinkedIn
			if(!empty($this->social_share_minimalist_options['includeLinkedin'])){
				$html = $html . "<div class='ssmicon'><a data-site='linkedin' href='http://www.linkedin.com/shareArticle?mini=true&amp;url=" . $url . "' target='_blank' rel='nofollow' alt='Share on LinkedIn'><div class='ssmlinkedin'></div></a></div>";
			}

    //Show Email

			$html = $html . "<div class='ssmicon'><a target='_blank' href='mailto:?Subject=Simple Share Buttons" . $url . "'><div class='ssmemail'></div></a></div></div></div>";


    //Print
			$html = $html . "<a href='javascript:window.print()' alt='Print this page'><div class='print-wrapper' ><div class='printer'>Print</div></a>";

			$content = $content . $html;
return $content;
		}
		}

}