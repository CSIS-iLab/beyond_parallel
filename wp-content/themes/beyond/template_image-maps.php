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

		// gets pdf files
		$image_maps_pdfs = get_posts(array(
			'post_type' => 'attachment',
			'tag' => 'image-maps',
			// 'post_mime_type' => 'image/png',
			'post_mime_type' => 'application/pdf',
			'posts_per_page' =>  -1
		));
		// var_dump($image_maps_pdfs);
		
		// Gets the scales from the scale field
		function get_scales_values( $attachments ) {
			$scales = [];
			foreach ( $attachments as $item ) {
				$scale = get_field( 'scale', $item );
				if ($scale != '') {
					array_push( $scales, $scale );
				}
			}
			return $scales;
		}

		// Gets the ACF 
		$credits = get_field( "credits" );
		$featured = get_field("featured")[0];
		$featured_img = wp_get_attachment_thumb_url($featured->ID, 'medium');
		
		// Gets the image thumbnail from the PDF file with ACF
		// $feat_img = get_field('thumbnail', $featured->ID);
		// $feat_img_url = str_replace('i1.wp.com/', '', $feat_img['url']);
		// var_dump($feat_img_url);

		// Gets all the posts where the attachment PDF is used
		$related_analysis = beyondparallel_get_posts_using_attachment($featured->ID);
		// echo get_the_title($related_maps);
		// echo $related_maps;
		// var_dump($related_maps);
		// $related_analysis = get_field("related_analysis");
		
		?>
		<article class="image-maps">
			<div class="image-maps-header">
				<p class="description">Add a description of the satellite image collection. Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>

				<?php if( $credits !== '' ): ?>
					<p class="credits">Specials thanks to <?php echo( $credits );?></p>
				<?php endif; ?>
			</div>

			<?php // var_dump($featured); ?>
			<div class="image-maps-featured">
				<?php if ( $featured ) :
					// $img_test = beyondparallel_get_posts_using_attachment($featured->ID);
					// var_dump($img_test);
					
					// foreach ($featured as $post) {
						$post = $featured;
						setup_postdata($post);								
						// var_dump(the_title());
						// wp_reset_postdata();
						// var_dump(the_title());
						?>
						<img src="<?php echo $featured_img;?>" class="featured-img">
						<!-- <img src="<?php // echo $feat_img_url;?>" class="featured-img"> -->
						<div class='featured-content'>
							<h3>FEATURED</h3>
							<?php the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
							<div class="followButton">
								<a href="<?php the_permalink(); ?>" rel="bookmark" title="Download file <?php the_title_attribute(); ?>" target="_blank" download>
									<span>
										Download
										<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M1.66659 10.3334L1.66659 12.3334H12.3333V10.3334H13.6666V13.6667H0.333252L0.333252 10.3334H1.66659Z" fill="#10355F"/>
											<path d="M6.99991 11.6095L6.39044 11L6.33324 11V10.9429L1.39044 6.00004L2.33325 5.05723L6.33325 9.05724L6.33329 0.333374L7.66663 0.33338L7.66659 9.05723L11.6666 5.05724L12.6094 6.00004L7.66658 10.9429V11H7.60939L6.99991 11.6095Z" fill="#10355F"/>
										</svg>
									</span>
								</a>
							</div>
							<div class="related-analysis">
								<h3 class="related-heading">Related Analysis:</h3>

								<?php wp_reset_postdata(); ?>

								<?php foreach ($related_analysis as $post):
									setup_postdata($post); ?>

									<header class="entry-header living-header">
										<?php //var_dump($post); ?>
										<?php the_title( sprintf( '<h3 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink($analysis) ) ), '</a></h3>' ); ?>

									</header>
									<div class="entry-summary">
										<span class="excerpt-date"><?php echo(get_the_date()); ?> </span>
									</div>
									
								<?php endforeach;
									wp_reset_postdata();
								?>
							</div> <!-- .related-analysis -->
						</div> <!-- .featured-content -->
				<?php // }else {} ?>
				<?php endif; ?>
			</div>
			<div class="select-filter">
				<label for="scale_select">Filter by scale: </label>
				<select id="scale_select" name="scale_select">
				<option value="all" selected> All </option>
				<?php
				$scales = get_scales_values($image_maps_pdfs);
				foreach ( $scales as $value) { ?>
					<option value="<?php echo $value ?>"> <?php echo $value ?> </option>
				<?php } ?>
				</select>
			</div>
			<div class="table-container">
				<?php ( empty( $scales ) ? get_template_part('template-table-wptable') : get_template_part( 'template-table', 'table', array( 'pdfs' => $image_maps_pdfs, 'scales'=> $scales ) ) ) ; ?>
			</div>
			<div class="wptable-container">
				<?php // get_template_part('template-table-wptable'); ?>
			</div>
		</article>
		<?php wp_reset_query(); ?>

		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'components/page/content', 'page' );
		endwhile; // End of the loop.
		?>
	</main><!-- .site-main -->
</div><!-- .content-area -->


<?php get_footer(); ?>
