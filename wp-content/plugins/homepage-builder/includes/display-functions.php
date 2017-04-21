<?php


function hb_add_content($content) {
	if(is_front_page()) {

		global $hb_options;

		$featuredPost = get_option('featured_post');
		$postArray = get_option('position_array');

		$pieces = explode(",", $postArray);

		$featured = get_featured($featuredPost);


		$content = $featured;
		$content .= get_recentPosts();

		foreach($pieces as $key => $value) {
			
    		//$post = $value;
    		$content .= get_thisPost($value);
		}
		// WP_Query argument
		$content .= '</div>';
		
	}
	
	return $content;
	
}
add_filter('the_content', 'hb_add_content');



function get_featured($featuredPost) {
	$args = array(
		'p' => $featuredPost,
	);

		// The Query
    $featured = new WP_Query($args);
 
	if ($featured->have_posts()): while($featured->have_posts()): $featured->the_post(); 
	
		 if (has_post_thumbnail()) { 
        	$thumb_id = get_post_thumbnail_id();
			$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
			$thumb_url = $thumb_url_array[0]; ?>
			 <a href="<?php the_permalink(); ?>" alt="<?php the_title();?>">
			 	<figure class="article-preview-image" style="background-image: url( <?php echo $thumb_url ?> )" >
            	</figure>
            </a>
        
        <?php }; ?>

        <div class="col-sm-6">
        	<h2>
        		<a href="<?php the_permalink(); ?>"><?php the_title();?>
        		</a>
        	</h2>
        	<?php beyond_posted_on(); ?>
        </div>
        
        <div class="featured-content col-sm-6">
			<?php echo wp_trim_words( get_the_content(), 50, '... <span class="read-more"><a href="'. get_permalink($post->ID) . '">READ MORE</span></a>' ) ?>
		</div>
		
		<div class="clearfix"></div>

		<div class="row" id="ms-container">
		
		<?php endwhile; endif; wp_reset_query(); 
}



function get_thisPost($value){
	$arg = array(
		'p' => $value
	);

	// The Query
	$current_post = new WP_Query($arg);
 
	if ($current_post->have_posts()): while($current_post->have_posts()): $current_post->the_post(); 
	?>

		<div class="ms-item col-lg-4 col-md-4 col-sm-6 col-xs-12">
		
	        	<div class="card-top"></div>
	        	<?php 
	        	if (has_post_thumbnail()){ 
	        	$thumb_id = get_post_thumbnail_id();
				$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'homepage-thumb', true);
				$thumb_url = $thumb_url_array[0];
				$random = rand ( 1 , 3 );
			};
			 ?>

	            <a href="<?php the_permalink(); ?>" alt="<?php the_title();?>">
		            <figure class="article-card-preview-image figure_<?php echo $random ?>" style="background-image: url( <?php echo $thumb_url ?> )">
		            </figure>
	            </a>
		    <div class="card-bottom">
		 
		   	<div class="post-cats">
					<?php $cat = new WPSEO_Primary_Term('category', get_the_ID());
					$cat = $cat->get_primary_term();
					$catName = get_cat_name($cat);
					$catLink = get_category_link($cat);
					echo "<a href='" . $catLink . "'>" . $catName . "</a>";
					?>
				<a href="<?php esc_html($catLink) ?>"><?php esc_html($catName) ?></a>
		        </div>
		        <div class="home-postTitle" class="post-title">
		        	<a href="<?php the_permalink() ?>" class="post-title-link"><?php the_title() ?>
		        	</a>
		        </div>
	        	<p>
			<?php echo wp_trim_words( get_the_content(), 20, '... <span class="read-more"><a href="'. get_permalink($post->ID) . '">READ MORE</span></a>' ) ?>
			</p>
	        	
		
		</div><!-- /card-bottom -->
		</div><!-- /ms-item featuredCard -->
		<?php
	
	 endwhile; endif; 
wp_reset_query(); 
}



function get_recentPosts(){
	$args = array(
			'numberposts' => '4',
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_type' => 'post',
			'post_status' => 'publish'
			
	);

	// The Query
	$recent_posts = wp_get_recent_posts( $args );
	

	//Output
	?>
	<div class="ms-item featuredCard col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="card-top"></div>
		<div class="recentPosts-title home-postTitle">Recent Articles</div>
		<div class="card-bottom">
			<?php
			foreach( $recent_posts as $recent ){
			?>
				<time class="entry-date" datetime="<?php echo get_the_date( 'c' ); ?>" pubdate>
				<?php echo get_the_date('F j, Y'); ?>
				</time><br>
			
				<?php echo '<a href="' . get_permalink($recent["ID"]) . '" class="home-postTitle" alt="' .   $recent["post_title"].'">' . $recent["post_title"].'</a> ';?>
				<hr class="hr-recent">
			<?php
			}
			?>
		</div><!-- /card-bottom -->
	</div><!-- /ms-item featuredCard -->

	<?php
	wp_reset_query();
}
