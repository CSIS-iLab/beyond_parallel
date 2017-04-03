<?php
/**
* A Simple Category Template
*/

get_header(); ?> 

<section id="primary" class="site-content container">
	<div id="content" role="main">

		<?php 
// Check if there are any posts to display
		if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="archive-header"><?php single_cat_title('<span>Category: </span>'); ?></h1>

			<?php
// Display optional category description
			if ( category_description() ) : ?>
			<div class="archive-meta"><?php echo category_description(); ?></div>
		<?php endif; ?>
	</header>

	<?php

// The Loop
	while ( have_posts() ) : the_post(); 
		get_template_part( 'components/post/content-searchAlt', get_post_format() );

	endwhile; 

	else: ?>
	<p>Sorry, no posts matched your criteria.</p>


<?php endif; ?>
<div class="pagination">
	<?php
	global $wp_query;

				$big = 999999999; // need an unlikely integer

				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages
					) );
					?>
				</div> <!--/pagination-->
			</div>
		</section>


		<?php get_sidebar(); ?>
		<?php get_footer(); ?>