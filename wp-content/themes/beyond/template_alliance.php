<?php
/**
 * 	Template Name: Alliance
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
		query_posts(
			array(
				'post_type' => array('post', 'videos'),
				'tag' => 'Future of the U.S.-Korea Alliance',
				'posts_per_page' =>  -1
			));
		while (have_posts()) : the_post();

			if( $wp_query->current_post == 0 && !is_paged() ) : ?>
				<article id="post-<?php the_ID(); ?>" class=<?php post_class(); ?>>
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
