<?php
/**
 * 	Template Name: Database Archive
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

		<!--Database anchor menu -->
		<div class="cat-list">
		<p class="pageMenuHeader">Select a database below to jump to related content</p>
		<?php query_posts(
			array(
				'post_type' => array('post', 'videos'),
				'tag' => 'database'
			));
		while (have_posts()) : the_post();

			$postID = get_the_ID();

			echo '<a href="#post-' . $postID . '">';

				the_title( '<p class="list-title">', '</p>' );

				?>

				</a>
		<?php
		endwhile;
		wp_reset_query();
		?>
		</div>

		<!--Post loop -->
		<?php query_posts(
			array(
				'post_type' => array('post', 'videos'),
				'tag' => 'database'
			));
		while (have_posts()) : the_post(); ?>
			<div class="database-post">
			<article id="post-<?php the_ID(); ?>" class=<?php post_class(); ?>>
						<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

						<?php the_content(); ?>

			</article>
			<?php get_template_part( 'components/post/content', 'social' );  ?>
			<?php get_template_part( 'components/post/content', 'footer' ); ?>
			<hr class="databasehr">
			</div>
		<?php
		endwhile;
		wp_reset_query();
		?>




	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
