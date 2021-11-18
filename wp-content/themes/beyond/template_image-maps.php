<?php
/**
 * 	Template Name: Image Maps
 *
 *
*/
get_header();
?>
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
            'post_mime_type' => 'application/pdf',
            'posts_per_page' =>  -1
        ));
        
        // Gets the scales from the scale field
        function get_scales_values( $attachments )
        {
            $scales = [ 'all' ];
            foreach ($attachments as $pdf) {
                $scale = get_field( 'scale', $pdf );
                if ($scale != '') {
                    array_push( $scales, $scale );
                }
            }
            return $scales;
        }
		
        // Gets the ACF
    		$introduction = get_field( "introduction" );
        $credits = get_field( "credits" );
        $featured = get_field( "featured" )[0];
<<<<<<< HEAD

=======
>>>>>>> 914787c (Fix repeated values on dropdown)
        // Gets all the posts where the attachment PDF is used
        $related_analysis = beyondparallel_get_posts_using_attachment( $featured->ID );        
        ?>
		<article class="image-maps">
			<div class="image-maps-header">
				<?php if ( $introduction ) { ?>
					<p class="description"><?php echo( $introduction );?></p>
				<?php } ?>

				<?php if ($credits !== ''): ?>
					<p class="credits">Specials thanks to <?php echo( $credits );?></p>
				<?php endif; ?>
			</div>

			<div class="image-maps-featured">
				<?php if ( $featured ) :
					$post = $featured;
					setup_postdata( $post );
					?>					
					<?php echo wp_get_attachment_image( $featured->ID, 'medium' ); ?>

					<div class='featured-content'>
						<h3>FEATURED</h3>
						<?php the_title( sprintf('<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
						<div class="followButton">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="Download file <?php the_title_attribute(); ?>" target="_blank" download>
								<span class="icon-download">
									Download <img src="<?php echo bloginfo('template_url'); ?>/assets/images/download-icon.svg" />
								</span>
							</a>
						</div>
						<?php wp_reset_postdata(); ?>
						<?php if ($related_analysis) { ?>
							<div class="related-analysis">
								<h3 class="related-heading">Related Analysis:</h3>

									<?php foreach ( $related_analysis as $post ):
										setup_postdata( $post ); ?>

										<header class="entry-header living-header">
											<?php the_title(sprintf('<h3 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url(get_permalink($analysis))), '</a></h3>'); ?>
										</header>
										<div class="entry-summary">
											<span class="excerpt-date"><?php echo( get_the_date() ); ?> </span>
										</div>
										
									<?php endforeach;
									wp_reset_postdata();
									?>
							</div> <!-- .related-analysis -->
						<?php } //end if	?>
					</div> <!-- .featured-content -->
				<?php endif; ?>
			</div>
			<div class="select-filter alignright">
				<label for="scale_select">Filter by scale: </label>
				<select id="scale_select" name="scale_select" >
					<?php
					$scales = get_scales_values($image_maps_pdfs);
					foreach (array_unique($scales) as $value) { ?>          
						<option value="<?php echo $value; ?>" <?php echo $value == rawurldecode($_GET['scale']) ? "selected" : "" ?>>
							<?php echo ucfirst($value) ?> 
						</option>
					<?php } ?>
				</select>
			</div>
			<div class="table-container">
				<?php ( empty( $scales ) ? get_template_part( 'template-table-wptable' ) : get_template_part( 'template-table', 'table', array( 'pdfs' => $image_maps_pdfs ) ) ) ; ?>
			</div>
			<div class="clearfix"></div>
		</article>
		<div class="container social">
				<footer class="entry-footer">				
					<?php
					get_template_part( 'components/post/content', 'social' );
					wp_reset_query(); 				
					?>
				</footer>
			</div>
	</main><!-- .site-main -->
</div><!-- .content-area -->


<?php get_footer();
