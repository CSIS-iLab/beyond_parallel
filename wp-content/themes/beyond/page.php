<?php
/**
 * The template for displaying all pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Beyond_Parallel
 */

get_header(); ?>
<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php the_title( '<h1>', '</h1>' ); ?>
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'components/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
			<?php get_template_part( 'components/post/content', 'social' );  ?>
		</main>
	</div><!--/primary-->
</div> <!--/container-->
<?php
get_sidebar();
get_footer();
