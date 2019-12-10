<?php
/**
 * 	Template Name: AVINK
 *
 *
*/
get_header(); ?>



<div id="primary" class="content-area container">
	<main id="main" class="site-main " role="main">


		<!--Database page content -->
		<?php
		while ( have_posts() ) : the_post();
			the_title( '<h1 class="entry-title">', '</h1>' ); 
			get_template_part( 'components/page/content', 'page' );
		endwhile; 
		?>


		


	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
