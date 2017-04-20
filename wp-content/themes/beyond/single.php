<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Beyond_Parallel
 */

get_header(); ?>
</div><!-- the-container -->
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post(); ?>

		<article class="post">
			<?php if ( has_post_thumbnail() ) { ?>
			<div class="postTop">


				<center><?php the_post_thumbnail(); ?>
				</center>

			</div>
			<?php } ?>
			<div class="container">

				<div id="post-<?php the_ID(); ?>" class="post-article">

					

					<div id="post-<?php the_ID(); ?>" class="the-content">

						<div class="post-cats">
							<?php echo get_the_category_list(", "); ?>
						</div>
						<div class="post-title">
							<?php the_title( '<h1>', '</h1>' ); ?>
						</div>


						<div class="post-meta">
							<?php beyond_posted_on(); ?></div>
						</div>
						<?php get_template_part( 'components/post/content', 'social' );  ?>
						<?php 

						the_content(); 
							// This call the main content of the post, the stuff in the main text box while composing.
							// This will wrap everything in p tags
						?>
						<?php wp_link_pages(); // This will display pagination links, if applicable to the post ?>
						<!-- the-content -->
					</div><!--container-->

				</article>
				<div class="container">
					

<footer class="entry-footer">

<?php
get_template_part( 'components/post/content', 'social' ); 
					get_template_part( 'components/post/content', 'footer' ); 

		endwhile; // End of the loop.
		?>
		</footer>
	</div><!--container-->
</main>
</div>

<?php
get_sidebar();
get_footer();
