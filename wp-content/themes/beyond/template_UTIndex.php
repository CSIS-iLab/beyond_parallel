<?php
/**
 * 	Template Name: Unification Transparency Index
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
				'tag' => 'transparency-index'
			));
		while (have_posts()) : the_post();

			if( $wp_query->current_post == 0 && !is_paged() ) : ?>
				<article id="post-<?php the_ID(); ?>" class=<?php post_class(); ?>>
					<div class="living-header-img">
					<?php echo get_the_post_thumbnail( $page->ID ); ?>
					</div>
					
					<div class="living-first">
						<h3>FEATURED</h3>
						<?php the_title( sprintf( '<h2 class="entry-title imagery-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>


						<?php
						if ( has_excerpt( $post->ID ) ){
						$excerpt = get_the_excerpt(); 
	        			echo $excerpt . "<br>"; 
	        		} else {
	        		
						$first_para = '';
						ob_start();
						ob_end_clean();
						$post_content = $post->post_content;
						$post_content = apply_filters('the_content', $post_content);
						$output = preg_match_all('%(<p[^>]*>.*?</p>)%i', $post_content, $matches);
						$first_para = $matches [1] [0];
						echo $first_para;
					}
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
						$title_array = explode(':', $title);
						$first_word = $title_array[1];

						if(strpos($title, ':') !== false) {
						  $first_word = $title_array[1];
						} else {
						  $first_word = $title;
						}

						?>

						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
						
						<?php
						echo $first_word;
						?>

						</a></h3>

					</header>
					<div class="entry-summary">
	
						
				
								<?php
							if ( has_excerpt( get_the_id() ) ){
								echo get_the_excerpt();
							}
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