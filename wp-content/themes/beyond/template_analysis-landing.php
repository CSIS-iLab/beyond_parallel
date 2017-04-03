<?php
/**
 * 	Template Name: Analysis Landing Page
 *
 *
*/
get_header(); ?>


<div id="primary" class="content-area container">
	<main id="main" class="site-main analysis-landing" role="main">

		<?php
		//get Post title and content
		while ( have_posts() ) : the_post();
			the_title( '<h1 class="entry-title">', '</h1>' ); 

			get_template_part( 'components/page/content', 'page' );


		endwhile; // End of the loop.
		

		//get list of categories
		?>
		<div class="cat-list">
			
			<p class="pageMenuHeader">Select a category below to jump to related content</p>
			<?php 

			// $custom_args = array(
			//      'orderby'          => 'name',
			//      'order'            => 'ASC',   
			//      'depth'            => 1,
			//      'show_count' 		=> 	true,
			//      'title_li'         => '',
			//      'echo'             => '0',
			//      'hide_empty'       => '1',
			//      'exclude_tree'    => '',
			// );

			//  $catArray = explode("</li>",wp_list_categories($custom_args));

			//  $catCount = count($catArray) - 1;
			//  $catColumns = round($catCount / 2);
			
			//  for ($i=0;$i<$catCount;$i++) {
			// 	 if ($i<$catColumns){
			// 		 $catLeft = $catLeft.''.$catArray[$i].'</li>';
			// 		          }
			// 	 elseif ($i>=$catColumns){
			// 	 	$catRight = $catRight.''.$catArray[$i].'</li>';
			// 	 }  
			//  };


			$categories = get_categories( array(
				'orderby' 		=> 'name',
				'parent'  		=> 0,
				'hide_empty' 	=> 1,
				'pad_counts' 	=> 1
				) );
			$catList = array();
			
			foreach ( $categories as $category ) {
				$catName = $category->name;
				$catCount = sprintf( esc_html__( '%s', 'textdomain' ), $category->count );
				$catNum = sprintf( '<a href="#'.$catName.'">%2$s</a> <span class="catNums">('.$catCount .')</span><br />',
					esc_url( get_category_link( $category->term_id ) ),
					esc_html( $category->name )
				);

				


				array_push($catList, $catNum);
			}



			$catCount = count($catList) - 1;
			$catColumns = round($catCount / 2);
			
			for ($i=0;$i<$catCount;$i++) {
				if ($i<$catColumns){
					$catLeft = $catLeft.''.$catList[$i];
				}
				elseif ($i>=$catColumns){
					$catRight = $catRight.''.$catList[$i];
				}  
			};


			?>





			<ul class="col-sm-4">
				<?php echo $catLeft; ?>
			</ul>
			<ul class="col-sm-4 col-sm-4-offset">
				<?php echo $catRight; ?>
			</ul>
			<div class="clearfix"></div>
			<a href="/all-posts" class="catAll" alt="See all articles"><span class="arrow">SEE ALL ARTICLES</span></a>

		</div>



		<?php

		//get list of categories and top 5 posts
		$do_not_duplicate = array();
		$categories = get_categories(); 

		foreach ( $categories as $category ) {

			$args = array(
				'cat' => $category->term_id,
				'post_type' => 'post',
				'posts_per_page' => '5',
				
			);

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) { ?>

			<section id="<?php echo $category->name; ?>" class="<?php echo $category->name; ?> listing cat-listing">
				<h2><?php echo $category->name; ?>:</h2> 
				<?php while ( $query->have_posts() ) {
					$query->the_post();
					$do_not_duplicate[] = $post->ID;
					?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'category-listing' ); ?>>
						<a class="related-link" rel="external" href="<? the_permalink()?>">
							<?php the_title(); ?></a><span class="related-date"> &#8212;<?php beyond_posted_on(); ?></span>


						</article>

						<?php } // end while ?>
						<a class="catMore" href="<?php echo get_category_link( $category->term_id ) ?>"><span class="arrow">More <?php echo $category->name; ?> Articles</span></a> </p>

					</section>

			<?php } // end if

// Use reset to restore original query.
			wp_reset_postdata();

		}
		?>
		<a href="/all-posts" class="catAll" alt="See all articles"><span class="arrow">SEE ALL ARTICLES</span></a>
	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>