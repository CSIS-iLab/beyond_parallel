<article id="post-<?php the_ID(); ?>" class="group index-post-container">
	
/*<?php 
		$the_format = get_post_format();
		// If the post format is Video, show video
		if ( $the_format == 'video' ) { 
			
			
			$custom_field_keys = get_post_custom_keys();
	foreach ( $custom_field_keys as $key => $value ) {
		$valuet = trim(substr($value, 1, 4));
		if ( 'oemb' == $valuet ) { 
			$oembkey = $value; 
			$oembvalue = get_post_custom_values($oembkey); 
			if (isset($oembvalue[0])) {
				$embedhtml = ($oembvalue[0]);
			}
		}
	} 
	$the_dump = get_post_custom_keys();
	echo '$the_dump: ';
	print_r($the_dump);
*/
	echo $embedhtml;
			
			//anaximander_output_oembed();	
		}
		// If the post format is not Video, show thumbnail if available
		elseif ( has_post_thumbnail() ) { ?>
			<figure class="the-thumbnail">
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'thales' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
					<?php the_post_thumbnail('index-thumb'); ?>
				</a>
			</figure>
			<?php
		} 
		
		
	?>
	<header class="index-header">
		<h1 class="index-title">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'thales' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">	
				<?php the_title(); ?>
			</a>
		</h1>

		<div class="index-name-date">
			By <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="View all posts by <?php echo get_the_author(); ?>"><?php echo get_the_author(); ?></a> on <time class="entry-date" datetime="<?php echo get_the_date( 'c' ); ?>" pubdate><?php echo get_the_date('F j, Y'); ?></time>
		</div>	
		<?php get_template_part('index-meta'); ?>
	</header><!-- .entry-header -->

	<div class="index-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->
	<div class="more-link">
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'thales' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			Read More
		</a>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->