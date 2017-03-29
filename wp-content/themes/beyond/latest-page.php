<?php
/**
 * 	Template Name: Latest Page
 *
 *	This page template has a sidebar built into it,
 * 	and can be used as a home page, in which case the title will not show up.
 *
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php if ( have_posts() ) : ?>

			<?php
while ( have_posts() ) : the_post(); 
get_template_part( 'components/post/content-search', get_post_format() );

 endwhile; 

else: ?>
<p>Sorry, no posts matched your criteria.</p>


<?php endif; 

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'beyond' ),
				'next_text'          => __( 'Next page', 'beyond' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
