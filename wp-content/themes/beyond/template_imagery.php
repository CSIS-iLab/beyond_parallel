<?php
/**
 * 	Template Name: Imagery
 *
 *
*/
get_header(); ?>

<div id="primary" class="content-area container">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();
			the_title( '<h1 class="entry-title">', '</h1>' ); 


		endwhile; // End of the loop.
		?>

		<?php
		query_posts( 
			array(
				'post_type' => array('post', 'videos'),
				'tag' => 'satellite-imagery'
			));
		while (have_posts()) : the_post();

			if( $wp_query->current_post == 0 && !is_paged() ) : ?>
				<article id="post-<?php the_ID(); ?>" class=<?php post_class(); ?>>
					<div class="living-header-img">
					<?php echo get_the_post_thumbnail( $page->ID ); ?>
					</div>
					
					<div class="living-first">
						<h3>FEATURED</h3>
						<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>


						<?php
						$head = wpautop( get_the_content() );
						$head = substr( $head, 0, strpos( $head, '</h2>' ) + 4 );
						$head = strip_tags($head, '<a><strong><em>');
						echo '<p class="living-subhead">' . $head . '</p>';

						$first_para = '';
						ob_start();
						ob_end_clean();
						$post_content = $post->post_content;
						$post_content = apply_filters('the_content', $post_content);
						$output = preg_match_all('%(<p[^>]*>.*?</p>)%i', $post_content, $matches);
						$first_para = $matches [1] [0];
						echo $first_para;
						?>

						<div class="followButton"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><span class="arrow">KEEP READING</span></a></h2>
						</div>
					</div>
				</article>
				
			<?php else : ?>
				<article id="post-<?php the_ID(); ?>" class=<?php post_class(); ?>>
					<header class="entry-header living-header">

						<?php 
						$title = get_the_title();
						$title_array = explode('with', $title);
						$first_word = $title_array[1];
						$total_length_limit = 100;
						?>

						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
						
						<?php
						echo mb_substr( $first_word, 0, $total_length_limit ) . '';
						?>

						</a></h3>

					</header>
					<div class="entry-summary">

						<?php
						$head = wpautop( get_the_content() );
						$head = substr( $head, 0, strpos( $head, '</h2>' ) + 4 );
						$head = strip_tags($head, '<a><strong><em>');
						echo '<p class="living-subhead">' . $head . '</p>';

						$first_para = '';
						ob_start();
						ob_end_clean();
						$post_content = $post->post_content;
						$post_content = apply_filters('the_content', $post_content);
						$output = preg_match_all('%(<p[^>]*>.*?</p>)%i', $post_content, $matches);
						$first_para = $matches [1] [0];
						echo $first_para;
						?>

						

					</div>
					<div class="clearfix"></div>
				</article>
			<?php endif; ?>


		<?php
		endwhile;
		wp_reset_query();
		?>

		<?php
		while ( have_posts() ) : the_post();

		get_template_part( 'components/page/content', 'page' );

		endwhile; // End of the loop.
		?>

	</main><!-- .site-main -->
</div><!-- .content-area -->


<?php get_footer(); ?>