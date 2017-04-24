<?php
/**
* Template Name: All Posts
*/

get_header(); ?>

<section id="primary" class="content-area container">
	<main id="main" class="site-main" role="main">

		<?php
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		$custom_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page' => '10', 'paged' => $paged));  ?>
  		
  			<?php 
  			if ( $custom_query->have_posts() ) : ?>
		
				<header class="page-header">
					<h1 class="archive-header">
						<?php the_title(); ?>
					</h1>
						<?php
						global $custom_query;
						$total_results = $custom_query->found_posts;
						echo $total_results . " total posts";
						?>
				</header>

				<?php
				/* Start the Loop */
				while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
						get_template_part( 'components/post/content', 'search' );
				endwhile;

			endif; ?>

		<div class="pagination">
			<?php
			global $custom_query;

			$big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $custom_query->max_num_pages
				) );
				?>
		</div> <!--/pagination-->

	</main>
</section>

<?php get_footer(); ?>