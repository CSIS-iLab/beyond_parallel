<?php
/**
* Template Name: All Posts
*/

get_header(); ?>


	<div id="primary" class="content-area container">
		<main id="main" class="site-main" role="main">

<?php
	
			the_title( '<h1 class="entry-title">', '</h1>' ); 
			
?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 

				
				get_template_part( 'components/post/content-search', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'components/post/content', 'none' );

		endif; ?>

		</main>
	</div>
<?php
get_sidebar();
get_footer();
