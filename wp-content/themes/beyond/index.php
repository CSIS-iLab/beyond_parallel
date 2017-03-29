<?php get_header(); ?>
<div class="container">
	<div id="featured">
<?php
query_posts('posts_per_page=3&cat=39'); /*1, 2*/

if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php if (has_post_thumbnail()) : ?>
        
      <figure class="article-preview-image">
                
          <?php the_post_thumbnail('medium'); ?>
                
      </figure>

<?php endif; ?>

<h2><a href="<?php the_permalink(); ?>"><?php the_title();/*3*/ ?></a></h2>
<p><?php the_excerpt(); ?></p>
<p><a href="<?php the_permalink(); ?>">continue reading</a></p>
<?php endwhile; ?> <?php wp_reset_query(); /*4*/ ?>
</div>


<div class="row" id="ms-container">


<?php
  $args = array(
        'posts_per_page' => 5,
        'meta_key' => 'meta-checkbox',
        'meta_value' => 'yes'
    );
    $featured = new WP_Query($args);
 
if ($featured->have_posts()): while($featured->have_posts()): $featured->the_post(); ?>

                
    <div class="ms-item col-lg-4 col-md-4 col-sm-6 col-xs-12">
        
        <?php if (has_post_thumbnail()) : ?>
        
            <figure class="article-preview-image">
                
                <?php the_post_thumbnail('medium'); ?>
                
            </figure>
        
        <?php else : ?>

        <?php endif; ?>
        <?php $cat = new WPSEO_Primary_Term('category', get_the_ID());
$cat = $cat->get_primary_term();
$catName = get_cat_name($cat);
$catLink = get_category_link($cat);
echo "<a href=" . $catLink . ">" . $catName . "</a>" ?>
        
            <h2 class="post-title"><a href="<?php the_permalink(); ?>" class="post-title-link"><?php the_title(); ?></a></h2>
            
        <?php the_excerpt(); ?>
            
    <div class="clearfix"></div>
    
<a href="<?php the_permalink(); ?>" class="btn btn-green btn-block">Read More</a>

    <div class="clearfix"></div>
    
    </div>
                
    <?php endwhile;
                


    else : ?>

        <article class="no-posts">

            <h1><?php _e('No posts were found.'); ?></h1>

        </article>
    <?php endif; ?>
                    
                </div>
<div class="clearfix"></div>




    <script type="text/javascript">
        
        jQuery(window).load(function() {
      var container = document.querySelector('#ms-container');
      var msnry = new Masonry( container, {
        itemSelector: '.ms-item',
        columnWidth: '.ms-item',                
      });  
      
        });

      
    </script>
    </div>
<?php get_footer(); ?>