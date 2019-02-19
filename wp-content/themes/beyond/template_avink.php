<?php
/**
 * 	Template Name: AVINK3
 *
*/

get_header(); ?>

	<div id="primary" class="content-area container">
		<main id="main" class="site-main" role="main">

			<div id="avink" class="container">

			<?php
					 		while ( have_posts() ) : the_post();
			the_title( '<h1 class="entry-title">', '</h1>' );

			get_template_part( 'components/page/content', 'page' );


		endwhile; // End of the loop.
							// This call the main content of the post, the stuff in the main text box while composing.
							// This will wrap everything in p tags
		?> <div class="cat-list row">
			<div style="font-style: italic; margin-left: 1rem; font-size: 1.1rem">Click on a link to jump to the related content.</div> <?php
		$repeatable_fields = get_post_meta($post->ID, 'repeatable_fields', true);
		if ( $repeatable_fields ) :
		foreach ( $repeatable_fields as $field ) {
			$year = esc_attr( $field['name']);
			$featured = esc_attr( $field['select']);
			$findings = esc_attr( $field['findings']);
			$related = esc_attr( $field['related']);

			if(!empty($year)) { ?>
				<div class="col-md-4">

						<?php
						echo '<h3><a href="#survey_'.$year.'">'. $year .' Survey</a></h3>';
						echo '<ul class="avink-links">';
							if($featured != '') {
								echo '<li><a href="#survey_'.$year.'">Featured Article</a></li>';
							}
							if($findings != '') {
								echo '<li><a href="#findings_'.$year.'">Findings</a></li>';
							}
							if($related != '') {
								echo '<li><a href="#related_'.$year.'">Related Expert Commentaries</a></li>';
							}
						echo '</ul>';
						?>
				</div>
	     	<?php  } } ?>
	     	</div>
	     	<?php

	     	foreach ( array_reverse($repeatable_fields) as $field ) {
			$year = esc_attr( $field['name']);
			$yearname = $year . ' Survey';
			$featured = esc_attr( $field['select']);
			$url = esc_url( $field['urlimg']);
			$findings = esc_attr( $field['findings']);
			$related = esc_attr( $field['related']);

			if(!empty($year)) {

				echo '<section>';
				echo '<h2 style="text-align: center;" id="survey_'.$year.'">'.$year.' Micro-Survey</h2>';
				if(!empty($featured)) {
				    	?>
					<article id="post-<?php $featured; ?>" class=<?php post_class(); ?>>
						<div class="living-header-img">
						<?php
						echo  '<img src="'.$url.'" alt="'.$year.' Featured Article">';
						?></div>

						<div class="living-first">
						<h3>FEATURED</h3>
						<?php echo '<h2 class="entry-title"><a href="' . get_the_permalink($featured) . '" title="' . get_the_title($featured) . '">' . get_the_title($featured) . '</a></h2>'; ?>

						<?php echo get_the_excerpt($featured); ?>


									<div class="followButton">
										<a href="<?php the_permalink($featured); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute($featured); ?>">
											<span class="arrow">KEEP READING</span>
										</a>
									</div>
								</div>
							</article>
				    	<?php
				}
						if(!empty($findings)) {
				    echo '<h2 id="findings_'.$year.'">Findings</h2>';
				    echo html_entity_decode($findings);
				}

						if(!empty($related)) {
				    echo '<h2 id="related_'.$year.'">Related Expert Commentaries</h2>';
				    echo html_entity_decode($related);
				}

				echo '</section>';

			 } }

		     	endif;
		     	?>

				<?php
						?>

					</div><!--/entry-content-->
				</div><!--/container-->
			</article><!-- #post-## -->
		</main>
	</div><!--/primary-->

<?php
get_footer();
