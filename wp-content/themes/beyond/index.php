<?php get_header(); ?>
<div class="articles-homepage">
<div class="container">
<h2 class="gray top">Featured Articles</h2>
<?php


    if(is_front_page()) {

        global $hb_options;

        $featuredPost = get_option('featured_post');
        $postArray = get_option('position_array');

        $imageArray = get_option('media_select');

        $imageLoc = explode(",", $imageArray);


        $pieces = explode(",", $postArray);

        $featured = get_featured($featuredPost);

        $content = $featured;
        
        $content .= get_recentPosts();

        foreach($pieces as $key => $value) {

            $imageL = $imageLoc[$key +1];
            
            //$post = $value;
           echo get_thisPost($key, $value, $imageL);

        }
        // WP_Query argument
        echo '</div>';
        
    }
    



function get_featured($featuredPost) {
    $args = array(
        'p' => $featuredPost,
    );

        // The Query
    $featured = new WP_Query($args);
 
    if ($featured->have_posts()): while($featured->have_posts()): $featured->the_post(); 
        $tagClass= '';
    if ( has_tag("NGA") ) {
        $tagClass = 'homeNGAtag';
    }
         if (has_post_thumbnail()) { 
            $thumb_id = get_post_thumbnail_id();
            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
            $thumb_url = $thumb_url_array[0]; ?>
             <a href="<?php the_permalink(); ?>" alt="<?php the_title();?>">
                <figure class="article-preview-image <?php echo $tagClass; ?>" style="background-image: url( <?php echo $thumb_url ?> )" >
                </figure>
            </a>
        
        <?php }; ?>

        <div class="col-sm-6">
            <h2>
                <a href="<?php the_permalink(); ?>" alt="<?php the_title();?>"><?php the_title();?>
                </a>
            </h2>
            <?php beyond_posted_on(); ?>
        </div>
        
        <div class="featured-content col-sm-6">
            <?php if ( has_excerpt( $post->ID ) ){
                        $excerpt = get_the_excerpt(); 
                        echo $excerpt . ' <span class="read-more"><a href="'. get_permalink($post->ID) . '">READ MORE</span></a>'; 
                    } else {
                        echo wp_trim_words( get_the_content(), 40, '... ') . ' <span class="read-more"><a href="'. get_permalink($post->ID) . '">READ MORE</span></a>';
                    } ?>
        </div>


        
        
        <div class="clearfix"></div>

        <div class="row" id="ms-container">
        
        <?php endwhile; endif; wp_reset_query(); 
}



function get_thisPost($key, $value, $imageL){
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

                
                switch ($imageL) {
                    case "c":
                        $image_position = "center";
                        break;
                    case "r":
                        $image_position = "right";
                        break;
                    case "l":
                        $image_position = "left";
                        break;
                }
            $tagClass= '';
            if ( has_tag("NGA") ) {
                $tagClass = 'homeNGAtag';
            }
                ?>
                
                <a href="<?php the_permalink(); ?>" alt="<?php the_title();?>">
                    <figure class="article-card-preview-image figure_<?php echo $random ?> <?php echo $tagClass; ?>" style="background-image: url( <?php echo $thumb_url ?> ); background-position: <?php echo $image_position ?>">
                    </figure>
                </a>

                <?php } else { 
                    $random = rand ( 1 , 3 );?>
                <a href="<?php the_permalink(); ?>" alt="<?php the_title();?>">
                    <figure class="article-card-preview-image figure_<?php echo $random ?>" style="background-image: url( <?php echo plugin_dir_url( __FILE__ ) . 'images/beyond-default-banner.jpg'; ?> );">
                    </figure>
                </a>



                <?php }; ?>
            <div class="card-bottom">
         
            <div class="post-cats">
                    <?php $cat = new WPSEO_Primary_Term('category', get_the_ID());
                    
                    $cat = $cat->get_primary_term();
                    $catName = get_cat_name($cat);
                    $catLink = get_category_link($cat);
            
                    
                    echo "<a href='" . $catLink . "'>" . $catName . "</a>";
                    ?>
                <a href="<?php esc_html($catLink) ?>" alt="<?php $catName ?>"><?php esc_html($catName) ?></a>
                </div>
                <div class="home-postTitle" class="post-title">
                    <a href="<?php the_permalink() ?>" alt="<?php the_title();?>" class="post-title-link"><?php the_title() ?>
                    </a>
                </div>
                <p>

                <?php 
                
                    if ( has_excerpt( $post->ID ) ){
                        $excerpt = get_the_excerpt(); 
                        echo wp_trim_words($excerpt, 35, '... ') . ' <span class="read-more"><a href="'. get_permalink($post->ID) . '">READ MORE</span></a>'; 
                    } else {
                        echo wp_trim_words( get_the_content(), 20, '... ') . ' <span class="read-more"><a href="'. get_permalink($post->ID) . '">READ MORE</span></a>';
                    } 
                ?>
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
        <a href="/all-posts/" alt="See all Recent Articles"><div class="recentPosts-title home-postTitle">Recent Articles</div></a>
        <div class="card-bottom">
            <?php
            foreach( $recent_posts as $recent ){
            ?>
                <time class="entry-date" datetime="<?php echo get_the_date( 'c' ); ?>" pubdate>
                <?php echo get_the_date('F j, Y', $recent["ID"]); ?>
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





?>


    </div>
    <a href="/analysis" alt="More articles" class="catAll"><span class="arrow">Explore More Articles</span></a>
    </div>

    <div class="intro-homepage">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h2 class="gray">Latest Tweets</h2>
                    <div class="tweet-container">
                        <a class="twitter-timeline" data-theme="light" data-link-color="#98B0BC" data-height="350" data-chrome="noheader nofooter noborders transparent"  data-tweet-limit="4" href="https://twitter.com/beyondcsiskorea">Tweets by Beyond Parallel</a> 
                        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                    </div><!--/tweet container-->
                </div><!--/col-sm-4-->
                <div class="col-sm-8">
                     <h2 class="gray">About Beyond Parallel</h2>
                         <p><em>Beyond Parallel</em> is a nonpartisan and authoritative analytic vehicle for delivering greater clarity and understanding to policymakers, strategists, and opinion leaders about Korean unification. The project will address issues that hold strategic significance for unification and functional issues such as economic development, migration, food security, transitional justice, human rights, and health that will be at the heart of how unification is carried out.</p>
                         
                        <a href="/about" alt="Read about Beyond Parallel" class="followButton"><span class="arrow ">Learn More</span>
                        </a>
                </div><!--/col-sm-8-->
            </div><!--/row-->
        </div><!--/container-->
    </div><!--/intro homepage-->

<?php get_footer(); ?>