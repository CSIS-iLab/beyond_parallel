<?php
/**
 * 	Template Name: AVINK
 *
 *
*/
get_header(); ?>



<div id="primary" class="content-area container">
	<main id="main" class="site-main " role="main">
		<?php
        while (have_posts()) : the_post();
            the_title('<h1 class="entry-title">', '</h1>');


        endwhile; // End of the loop.
        ?>

		<?php
        query_posts(
            array(
                'post_type' => array('post'),
                'tag' => 'database',
                'posts_per_page' =>  -1
            )
        );
        while (have_posts()) : the_post();    ?>

				<article id="post-<?php the_ID(); ?>" class=<?php post_class(); ?>>
					<header class="entry-header living-header">

						<?php the_title(sprintf('<h3 class="entry-title imagery-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>

					</header>
					<div class="entry-summary">

						<div class="entry-thumb">

							<?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>

						</div>

								<?php
                            if (has_excerpt(get_the_id())) {
                                echo get_the_excerpt();
                            }
                            ?>
						</div>

				<div class="clearfix"></div>
				</article>


			<?php
            endwhile;
            wp_reset_query();
            ?>





	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
