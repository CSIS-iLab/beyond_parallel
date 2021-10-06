<?php
/**
 * 	Template Name: Image Maps
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
		
		// $test = beyondparallel_get_posts_using_attachment();
		// gets pdf files
		$image_maps_posts = get_posts(array(
			'post_type' => 'attachment',
			'tag' => 'image-maps',
			// 'post_mime_type' => 'image/png',
			'post_mime_type' => 'application/pdf',
			'posts_per_page' =>  -1
		));
		$credits = get_field( "credits" );
		$featured = get_field("featured");
		$featured_img_id = get_post_thumbnail_id($featured);
		$related_analysis = get_field("related_analysis");
		$array_test = [];
		$post_use = [];
		foreach ($image_maps_posts as $pdf) {
			// echo $pdf->ID;
			array_push($array_test, beyondparallel_get_posts_using_attachment($pdf->ID));
			// echo print_r(get_post($pdf->ID));
		}
		foreach ($array_test as $key => $value) {
			// echo print_r($value);
			// echo print_r(get_post($value));
		}
		// echo print_r($array_test);
		// $attachment_use_in = 
		
		// $img_URL = wp_get_attachment_url($image_maps_posts[0]->ID);

		// echo print_r ($attachment_use_in);
		// echo print_r ($img_URL);
		// var_dump($image_maps_posts[0]->ID);
		// var_dump(get_site_url());
		// Get image field from Media attachment
		$image = get_field('thumbnail', $image_maps_posts[1]->ID);
		var_dump($image);
		$bad_url = $image['url'];
		$remove_from_url = 'i1.wp.com/';
		$good_url = str_replace($remove_from_url, "", $bad_url);
		// var_dump($good_url);
		// var_dump($image);
		// var_dump($custom_image_url);
		
		?>
		<?php
		// query_posts(
			// array(
				// 'post_type' => array('post', 'videos'),	
				// 'tag' => 'satellite-imagery',
				// 'posts_per_page' =>  -1
				// 'post_type' => 'attachment',
				// 'tag' => 'image-maps',
				// 'post_mime_type' => 'image/png',
				// 'post_mime_type' => 'application/pdf',
				// 'posts_per_page' =>  -1
			// )); 
		// var_dump( $featured[0]);
		// echo print_r( $file );
		// foreach ($image_maps_posts as $post) {
		// 	setup_postdata($post);
			// var_dump(the_post());
			// if( $image_maps_posts->current_post == 0 && !is_paged() ) : 
		while (have_posts()) : the_post();
		// var_dump(the_post());
			?>

				<article class="image-maps" >
					<div class="image-maps-header">
						<p class="description">Add a description of the satellite image collection. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>

						<?php if( $credits !== '' ): ?>
							<p class="credits">Specials thanks to <?php echo( $credits );?></p>
						<?php endif; ?>
					</div>
					<?php 
						var_dump($image_maps_posts[0]);
						var_dump($image_maps_posts[0]->ID);
						var_dump(beyondparallel_get_posts_using_attachment($image_maps_posts[0]->ID));
						var_dump($featured[0]->ID);
						var_dump($featured[0]);
						$img_test = beyondparallel_get_posts_using_attachment(5418);
						var_dump($img_test);
						foreach ($img_test as $i) {
							var_dump($i);
							if ($i == $image_maps_posts[0]->ID) {
								echo 'son iguales', $i;
							} else {
								echo 'no hay';
							}
						}
					?>
					<div class="image-maps-featured">
						<?php if ( $featured ) :
							// $img_test = beyondparallel_get_posts_using_attachment($featured->ID);
							// var_dump($img_test);
							foreach ($featured as $post) {
								
								setup_postdata($post);
								$img = get_field('thumbnail', $post->id);
								// var_dump($img);
								?>
								<img src="<?php echo $good_url;?>" class="featured-img">
								<div class='featured-content'>
									<h3>FEATURED</h3>
									<?php the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
									<div class="followButton">
										<a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
											<span>Download
												<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M1.66659 10.3334L1.66659 12.3334H12.3333V10.3334H13.6666V13.6667H0.333252L0.333252 10.3334H1.66659Z" fill="#10355F"/>
													<path d="M6.99991 11.6095L6.39044 11L6.33324 11V10.9429L1.39044 6.00004L2.33325 5.05723L6.33325 9.05724L6.33329 0.333374L7.66663 0.33338L7.66659 9.05723L11.6666 5.05724L12.6094 6.00004L7.66658 10.9429V11H7.60939L6.99991 11.6095Z" fill="#10355F"/>
												</svg>
											</span>
										</a>
									</div>
									<div class="related-analysis">
										<h3 class="related-heading">Related Analysis:</h3>
										<?php
											// foreach ($image_maps_posts as $post): 
											foreach ($related_analysis as $post): 
										?>
											<header class="entry-header living-header">
												<?php //var_dump($post); ?>
												<?php the_title( sprintf( '<h3 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink($analysis) ) ), '</a></h3>' ); ?>

											</header>
											<div class="entry-summary">
												<span class="excerpt-date"><?php echo(get_the_date()); ?> </span>
											</div>
										<?php endforeach; ?>
									</div>
								</div> <!-- end featured-content -->
							<?php } ?>
						<?php endif; ?>
					</div>
					<div class="wptable-container">
						<?php get_template_part('template-table-wptable'); ?>
					</div>

												
					<div class="table-container">
						<?php get_template_part( 'template-table', 'table', $image_maps_posts );?>
					</div>
				</article>
			<?php // endif; ?>

		<?php
			// }
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
