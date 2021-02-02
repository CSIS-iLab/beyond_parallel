<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Beyond_Parallel
 */

?>

	</div>
	<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<img class="csis-footer-logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/csis_logo_white.svg">
			<p>1616 Rhode Island Avenue, NW <br />
Washington, DC 20036<br />
Tel: 202.775.3242 </p>
		<?php //get_template_part( 'components/footer/site', 'info' ); ?>
			</div>
			<div class="col-sm-6">
				<div class="social">
					<a href="https://www.facebook.com/csiskoreachair/" alt="Beyond Parallel Facebook"><div class="facebook-icon"></div></a>
					<a href="https://twitter.com/CSISKoreaChair?lang=en" alt="CSIS Korea Chair Twitter"><div class="twitter-icon"></div></a>
					<a href="mailto:KoreaChair@csis.org?Subject=" target="_top"" alt="Beyond Parallel Email"><div class="email-icon"></div></a>
				</div>
				<div class="clearfix"></div>
				<p class="copywrite">©<?php echo esc_html( date( 'Y' ) ); ?> by the Center for Strategic <br />
				and  International Studies. All rights reserved.<br/><a class="privacy-policy" href="https://www.csis.org/privacy-policy" target="_blank" rel="nofollow">Privacy Policy</a> | <a class="privacy-policy" href="https://www.csis.org/reprint-permissions" target="_blank" rel="nofollow">Reprint Permissions</a></p>
			</div>
		</div>
	</div>
	</footer>
</div>
<?php wp_footer(); ?>

</body>
</html>
