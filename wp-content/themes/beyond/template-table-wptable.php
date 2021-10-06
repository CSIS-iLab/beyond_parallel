<?php
/**
 * Template part for displaying maps on the table with wptable
 * 
 */
?>


<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="single__content">
    <?php echo do_shortcode("[wpdatatable id=64]"); ?>
  </div>
</article><!-- .post -->
  