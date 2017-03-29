<article class="masonry-entry" id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
<?php if ( has_post_thumbnail() ) : ?>
    <div class="masonry-thumbnail">
        <a href="<?php the_permalink(' ') ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('masonry-thumb'); ?></a>
    </div><!--.masonry-thumbnail-->
<?php endif; ?>
    <div class="masonry-details">
        <h5><a href="<?php the_permalink(' ') ?>" title="<?php the_title(); ?>"><span class="masonry-post-title"> <?php the_title(); ?></span></a></h5>
        <div class="masonry-post-excerpt">
            <?php the_excerpt(); ?>
        </div><!--.masonry-post-excerpt-->
    </div><!--/.masonry-entry-details -->  
</article><!--/.masonry-entry-->