<?php
/**
 * Template part for displaying maps on the table
 *
 * 
 */
?>
<?php 
  // var_dump( $args[0] );
  // $field_name = get_field('location-region', $args[0]->ID);
  // echo $field_name;
  // echo $args[0]->ID;
  // $first_post = beyondparallel_get_posts_using_attachment($args[0]->ID)[0];
  // echo $first_post;
  

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
  <div class="single__content">
  <?php
    // foreach ($args as $post) {
      
      // var_dump ($post);
      // esc_html_e(get_permalink());
      // the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
    // }
  ?>
	  <div class="maps-table banded alignwide">
      
      <table id="imageMaps">
        <thead>
          <th><?php esc_html_e( 'Description' ); ?></th>
          <th><?php esc_html_e( 'Province' ); ?></th>
          <th><?php esc_html_e( 'Last Updated' ); ?></th>
        </thead>
        <tbody>
          <?php foreach ( $args as $post ) { ?>
            <?php setup_postdata( $post ); ?>
            <?php $related_analysis = beyondparallel_get_posts_using_attachment( $post->ID ); ?>
          <tr>  
            <?php if ( $related_analysis ) { ?>
              <td><?php the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
							  <div class="related-analysis">
								  <h3 class="related-heading">Related Analysis:</h3>
                  <?php foreach ($related_analysis as $analysis) { ?>
                    
                    <header class="entry-header living-header">
										  <?php the_title( sprintf( '<h3 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink($analysis) ) ), '</a></h3>' ); ?>
									  </header>
                    
                  <?php } ?>
                  <?php //wp_reset_postdata(); ?>
                </div> <!-- .related-analysis -->
              </td>  
            <?php } else { ?>
              <td><?php the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?></td>
            <?php } // end if ?>
            <td><?php echo get_field( 'location-region', $post->ID ) ?></td>
            <td><?php the_modified_date(); ?></td>
          </tr>
          <?php } // end foreach ?>
        </tbody>
      </table>
    </div><!-- .beyond-table banded -->

</article><!-- .post -->
  