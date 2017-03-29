<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Beyond_Parallel
 */

get_header(); ?>

	<section id="primary" class="content-area container">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">

				<h1 class="page-title search-title"><?php printf( esc_html__( 'Search Results for: %s', 'beyond' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				<?php
global $wp_query;
$total_results = $wp_query->found_posts;
echo $total_results . " results found";
?>
			</header>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'components/post/content', 'search' );

			endwhile;


		else :

			get_template_part( 'components/post/content', 'none' );

		endif; ?>

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
		</main>
	</section>
<?php
get_sidebar();
get_footer();
