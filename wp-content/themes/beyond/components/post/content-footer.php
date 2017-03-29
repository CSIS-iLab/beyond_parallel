
	
	
 
	<?php





	$tags = get_the_tags();

	if ($tags) { ?>
	<div class="relatedposts">
		<h3 class="relatedHeading">Related posts</h3>
		<?php
		$tag_ids = array();
		foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
		
		$args=array(
			'tag__in' => $tag_ids,
			'post__not_in' => array($post->ID),
	        'posts_per_page'=>4, // Number of related posts to display.
	        'caller_get_posts'=>1
        );

		$my_query = new wp_query( $args );

		while( $my_query->have_posts() ) {
			$my_query->the_post();
			?>

			<div class="related-links">
				<a class="related-link" rel="external" href="<? the_permalink()?>">
					<?php the_title(); ?>
				</a>
				<span class="related-date"> <?php beyond_posted_on(); ?></span>
			</div>

		<?php } //end while

		
	} //end if


		?>

	</div> <!--/relatedposts-->

	

	<?php
	$posttags = get_the_tags();
	if ($tags) { ?>
		<div class="relatedtags">
			<h3 class="relatedHeading">Keywords</h3>
				<?php
				foreach($tags as $tag) {
				echo '<a href="' . get_tag_link($tag->term_id) . '"> <div class="postTag">' . $tag->name . '</div></a>'; 
				}
				?>
		</div> <!--/relatedtags-->
	<?php
	} //end if

	?>

<!--<?php beyond_entry_footer(); ?>-->
