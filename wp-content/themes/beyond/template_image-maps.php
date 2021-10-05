<?php
/**
 * 	Template Name: Image Maps
 *
 *
*/
get_header(); ?>

<div id="primary" class="content-area container">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();
			the_title( '<h1 class="entry-title">', '</h1>' );
		endwhile; // End of the loop.
		?>

		<?php
		$image_maps_posts = get_posts(array(
			'post_type' => 'attachment',
			'tag' => 'image-maps',
			// 'post_mime_type' => 'image/png',
			'post_mime_type' => 'application/pdf',
			'posts_per_page' =>  -1
		));
		$credits = get_field( "credits" );
		$featured = get_field("featured");
		$featured_img_id = get_post_thumbnail_id($featured);
		$related_analysis = get_field("related_analysis");

		// var_dump($image_maps_posts[0]->ID);
		// var_dump(get_site_url());
		$image = get_field('thumbnail', $image_maps_posts[0]->ID);
		$bad_url = $image['url'];
		$remove_from_url = 'i1.wp.com/';
		$good_url = str_replace($remove_from_url, "", $bad_url);
		var_dump($good_url);
		var_dump($image);
		// var_dump($custom_image_url);
		
		?>
		<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" data-attr="<?php echo $custom_image_url;?>" />
		<?php 
		// var_dump( $featured[0]);
		// echo print_r( $file );
		// foreach ($image_maps_posts as $post) {
		// 	setup_postdata($post);
			// var_dump(the_post());
			// if( $image_maps_posts->current_post == 0 && !is_paged() ) : ?>

				<article class="image-maps" >
					<div class="image-maps-header">
						<p class="description">Add a description of the satellite image collection. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>

						<?php if( $credits !== '' ): ?>
							<p class="credits">Specials thanks to <?php echo( $credits );?></p>
						<?php endif; ?>
					</div>
					<div class="image-maps-featured">
						<?php if ( $featured ) :
							foreach ($featured as $post) {
								setup_postdata($post);
								?>
								<img src="<?php echo $good_url;?>" class="featured-img">
								<div class='featured-content'>
									<h3>FEATURED</h3>
									<h2 class="entry-title featured-title"><a href="%s" rel="bookmark"></a></h2>
									<?php the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
									<div class="followButton">
										<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
											<span class="download">Download</span>
										</a>
									</div>
									<div class="related-analysis">
										<h3 class="related-heading">Related Analysis:</h3>
										<?php
											// foreach ($image_maps_posts as $post): 
											foreach ($related_analysis as $post): 
										?>
											<header class="entry-header living-header">
												<?php //var_dump($post); ?>
												<?php the_title( sprintf( '<h3 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink($analysis) ) ), '</a></h3>' ); ?>

											</header>
											<div class="entry-summary">
												<span class="excerpt-date"><?php echo(get_the_date()); ?> </span>
											</div>
										<?php endforeach; ?>
									</div>
								</div> <!-- end featured-content -->
							<?php } ?>
						<?php endif; ?>
					</div>
					<div class="table-container">
						<?php get_template_part( 'template-table' );?>
					</div>
				</article>
			<?php // endif; ?>

		<?php
		// }
		// endwhile;
		// wp_reset_query();
		?>

		<?php
		while ( have_posts() ) : the_post();

		get_template_part( 'components/page/content', 'page' );

		endwhile; // End of the loop.
		?>

	</main><!-- .site-main -->
</div><!-- .content-area -->


<?php get_footer(); ?>
