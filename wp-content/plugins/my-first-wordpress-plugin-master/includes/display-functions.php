<?php

/*our display functions for outputting information*/




function mfwp_add_content($content) {
		if(is_front_page()) {

	global $mfwp_options;


		//$extra_content = '<p class="twitter-message ' . $mfwp_options['theme'] . '">Follow me on <a href="' . $mfwp_options['twitter_url'] . '">Twitter</a></p>';
		//
		$featuredPost = get_option('featured_post');
		$postArray = get_option('position_array');

		$pieces = explode(",", $postArray);

		$featured = get_featured($featuredPost);


		$content = $featured;
		$content .= '<div class="row" id="ms-container">';

		foreach($pieces as $key => $value) {
    		$post = $value;
    		$content .= get_thisPost($post);
		}
		// WP_Query argument
		$content .= '</div>';
		
	}
	return $content;
	
}
add_filter('the_content', 'mfwp_add_content');



function get_featured($featuredPost)
 {
		$args = array(
			'p' => $featuredPost,
		);

		// The Query
    $featured = new WP_Query($args);
 
	if ($featured->have_posts()): while($featured->have_posts()): $featured->the_post(); 
	
		 if (has_post_thumbnail()) : ?>
        
            <figure class="article-preview-image">
                
                <?php the_post_thumbnail('large'); ?>
                
            </figure>
        
        <?php endif; ?>
        <div class="col-sm-6">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
        <?php $authors = get_the_author(); echo "By " . $authors; ?> 
        </div>
        <div class="col-sm-6">
		<?php the_excerpt(); ?>
		
		</div>
		<div class="clearfix"></div>
	<?php endwhile; endif; wp_reset_query(); ?>
	
<?php

}



function get_thisPost($post)
 {
		$args = array(
			'p' => $post
		);

		// The Query
		// 
	?>
	
	<?php

    $current_post = new WP_Query($args);
 
	if ($current_post->have_posts()): while($current_post->have_posts()): $current_post->the_post(); 
	?>
	 <div class="ms-item col-lg-4 col-md-4 col-sm-6 col-xs-12">

	 <div class="card-top"></div>
        <?php if (has_post_thumbnail()) : ?>
        
            <figure class="article-card-preview-image">
                
                <?php the_post_thumbnail('large'); ?>
                
            </figure>
        
        <?php else : ?>

        <?php endif; ?>
        <div class="card-bottom">
        <div class="post-cats">
<?php $cat = new WPSEO_Primary_Term('category', get_the_ID());
$cat = $cat->get_primary_term();
$catName = get_cat_name($cat);
$catLink = get_category_link($cat);

echo "<a href=" . $catLink . ">" . $catName . "</a>" ?>
        </div>
            <h2 class="post-title"><a href="<?php the_permalink(); ?>" class="post-title-link"><?php the_title(); ?></a></h2>
            
        <?php the_excerpt(); ?>
            
        
<a href="<?php the_permalink(); ?>" class="btn btn-green btn-block">Read More</a>

	 </div>
	 </div>
	 <?
	endwhile; endif; wp_reset_query(); ?>

	
	<?php

}





