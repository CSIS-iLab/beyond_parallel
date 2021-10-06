<?php
/**
 * Template part for displaying maps on the table
 *
 * 
 */
?>


<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="single__content">
<?php
    // $image_maps_posts = get_posts(array(
    //     'post_type' => 'attachment',
    //     'tag' => 'image-maps',
    //     // 'post_mime_type' => 'image/png',
    //     'post_mime_type' => 'application/pdf',
    //     'posts_per_page' =>  -1
    // ));
    foreach ($args as $post) {
      setup_postdata($post);
      // var_dump ($post);
      // esc_html_e(get_permalink());
      // the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
    }
    
    ?>
	  <div class="maps-table banded alignwide">
      
      <table id="imageMaps">
        <thead>
          <th><?php esc_html_e( 'Description' ); ?></th>
          <th><?php esc_html_e( 'Province'); ?></th>
          <th><?php esc_html_e( 'Last Updated'); ?></th>
        </thead>
        <tbody>
          <?php foreach ($args as $post) { ?>
          <tr>
            <td><?php the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?></td>
            <td>Hamgyongnam-do</td>
            <td>May 18, 2021</td>
          </tr>
          <?php } // end foreach ?>
          <tr>
            <td>Ch’aho Navy Base</td>
            <td>Hamgyongnam-do</td>
            <td>February 2, 2021</td>
          </tr>
        </tbody>
      </table>
    </div><!-- .beyond-table banded -->

</article><!-- .post -->
  