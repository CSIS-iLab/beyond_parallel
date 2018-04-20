<?php
/**
 * 	Template Name: AVINK
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
						$featured_2016 = get_post_meta($post->ID, 'meta-select_2016', true);
						$findings_2016 = get_post_meta($post->ID, '_wp_editor_2016_1', true);
						$related_2016 = get_post_meta($post->ID, '_wp_editor_2016_2', true);

						$featured_2017 = get_post_meta($post->ID, 'meta-select_2017', true);
						$findings_2017 = get_post_meta($post->ID, '_wp_editor_2017_1', true);
						$related_2017 = get_post_meta($post->ID, '_wp_editor_2017_2', true);



?>
<div class="cat-list row">
	<?php if(!empty($featured_2016)) { ?>
	<div class="col-md-4">
	<h3><a href="#2016-survey">2016 Survey</a></h3>
		<?php
		echo '<ul class="avink-links">';
			if(!empty($featured_2016)) {
				echo '<li><a href="#2016-survey">Featured Article</a></li>';
			}
			if(!empty($findings_2016)) {
				echo '<li><a href="#2016-findings">Findings</a></li>';
			}
			if(!empty($related_2016)) {
				echo '<li><a href="#2016-related">Related Expert Commentaries</a></li>';
			}
		echo '</ul>';
		?>
	</div>
	<?php } 
	?>

	<?php if(!empty($featured_2017)) { ?>
	<div class="col-md-4">
	<h3><a href="#2017-survey">2017 Survey</a></h3>
		<?php
		echo '<ul class="avink-links">';
			if(!empty($featured_2017)) {
				echo '<li><a href="#2017-survey">Featured Article</a></li>';
			}
			if(!empty($findings_2017)) {
				echo '<li><a href="#2017-findings">Findings</a></li>';
			}
			if(!empty($related_2017)) {
				echo '<li><a href="#2017-related">Related Expert Commentaries</a></li>';
			}
		echo '</ul>';
		?>
	</div>
	<?php } ?>

</div>

<?php
echo '<section>';
echo '<h2 style="text-align: center;" id="2017-survey">2017 Micro-Survey</h2>';
				if(!empty($featured_2017)) {
				    	?>
<article id="post-<?php $featured_2017; ?>" class=<?php post_class(); ?>>
					<div class="living-header-img">
					<?php echo get_the_post_thumbnail( $featured_2017 ); ?>
					</div>
					
					<div class="living-first">
						<h3>FEATURED</h3>
					
						<?php
						echo '<h2 class="entry-title"><a href="' . get_the_permalink($featured_2017) . '">' . get_the_title($featured_2017) . '</a></h2>';

						echo '<p>' . get_the_excerpt($featured_2017). '</p>';
						?>

						<div class="followButton"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><span class="arrow">KEEP READING</span></a></h2>
						</div>
					</div>
					</article>
				    	<?php
				}
						if(!empty($findings_2017)) {
				    echo '<h2 id="2017-findings">Findings</h2>';
				    echo wpautop($findings_2017);
				}
						
						if(!empty($related_2017)) {
				    echo '<h2 id="2017-related">Related Expert Commentaries</h2>';
				    echo wpautop($related_2017);
				}

echo '</section>';
echo '<section>';
echo '<h2 style="text-align: center;" id="2016-survey">2016 Micro-Survey</h2>';
										if(!empty($featured_2016)) {
				    	?>

					<article id="post-<?php $featured_2016; ?>" class=<?php post_class(); ?>>
					<div class="living-header-img">
					<?php echo get_the_post_thumbnail( $featured_2016 ); ?>
					</div>
					
					<div class="living-first">
						<h3>FEATURED</h3>
					
						<?php
						echo '<h2 class="entry-title"><a href="' . get_the_permalink($featured_2016) . '">' . get_the_title($featured_2016) . '</a></h2>';

						echo '<p>' . get_the_excerpt($featured_2016). '</p>';
						?>

						<div class="followButton"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><span class="arrow">KEEP READING</span></a></h2>
						</div>
					</div>
					</article>


				    	<?php
						}
						if(!empty($findings_2016)) {
				    echo '<h2 id="2016-findings">Findings</h2>';
				    echo wpautop($findings_2016);
				}
						
						if(!empty($related_2016)) {
				    echo '<h2 id="2016-related">Related Expert Commentaries</h2>';
				    echo wpautop($related_2016);
				}
echo '</section>';

					?>


					</div><!--/entry-content-->
				</div><!--/container-->
			</article><!-- #post-## -->
		</main>
	</div><!--/primary-->

<?php
get_footer();