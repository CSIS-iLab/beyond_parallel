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
		$credits = get_field( "credits" );
		$featured = get_field("featured");
		$featured_img_id = get_post_thumbnail_id($featured->ID);
		$related_analysis = get_field("related_analysis");
		// var_dump( $credits );
		query_posts(
			array(
				'post_type' => array('post', 'videos'),
				'tag' => 'satellite-imagery',
				'posts_per_page' =>  -1
			));
		while (have_posts()) : the_post();

			if( $wp_query->current_post == 0 && !is_paged() ) : ?>
				<article id="post-<?php the_ID(); ?>" class="image-maps" >
					<div class="image-maps-header">
						<p class="description">Add a description of the satellite image collection. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>

						<?php if( $credits !== '' ): ?>
							<p class="credits">Specials thanks to <?php echo( $credits );?></p>
						<?php endif; ?>
					</div>
					<?php var_dump($featured);
						// var_dump(get_post_thumbnail_id($featured->ID) );
						var_dump($related_analysis);
						// var_dump( get_posts_by_attachment($featured_img_id));
					?>
					<div class="image-maps-featured">
						<?php if ( $featured ) : ?>
							<img src="<?php echo get_the_post_thumbnail_url( $featured->ID );?>" class="featured-img">
							<div class='featured-content'>
								<h3>FEATURED</h3>
								<?php the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
								<div class="followButton">
									<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
										<span class="download">Download</span>
									</a>
								</div>
								<div class="related-analysis">
									<h3 class="related-heading">Related Analysis:</h3>
									<?php foreach ($related_analysis as $post): ?>
										<header class="entry-header living-header">
											<?php //var_dump($post); ?>
											<?php the_title( sprintf( '<h3 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink($analysis) ) ), '</a></h3>' ); ?>

										</header>
										<div class="entry-summary">
											<span class="excerpt-date"><?php echo(get_the_date()); ?> </span>
											<?php //var_dump(get_the_date()); ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<div class="living-header-img">
					<?php echo get_the_post_thumbnail( $post->ID ); ?>
					</div>

					<div class="living-first">
						<h3>FEATURED</h3>
						<?php the_title( sprintf( '<h2 class="entry-title imagery-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

						<?php
							if ( has_excerpt( get_the_id() ) ){
								echo get_the_excerpt();
							}
							?>

						<div class="followButton">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
								<span class="arrow">KEEP READING</span>
							</a>
						</div>
					</div>
				</article>

			<?php else : ?>
				<article id="post-<?php the_ID(); ?>" class=<?php post_class(); ?>>
					<header class="entry-header living-header">

						<?php the_title( sprintf( '<h3 class="entry-title imagery-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

					</header>
					<div class="entry-summary">

						<div class="entry-thumb">

							<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>

						</div>

								<?php
							if ( has_excerpt( get_the_id() ) ){
								echo get_the_excerpt();
							}
							?>
						</div>

				<div class="clearfix"></div>
				</article>
			<?php endif; ?>

		<?php
		endwhile;
		wp_reset_query();
		?>

		<?php
		while ( have_posts() ) : the_post();

		get_template_part( 'components/page/content', 'page' );

		endwhile; // End of the loop.
		?>

	</main><!-- .site-main -->
</div><!-- .content-area -->


<?php get_footer(); ?>
