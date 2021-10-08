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
      
      // var_dump ($args);
      // esc_html_e(get_permalink());
      // the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
    // }
  ?>
	  <div class="maps-table banded alignwide">
      
      <table id="imageMaps">
        <thead>
          <th><?php esc_html_e( ' ' ); ?></th>
          <th><?php esc_html_e( 'Description' ); ?></th>
          <th><?php esc_html_e( 'Province' ); ?></th>
          <th><?php esc_html_e( 'Last Updated' ); ?></th>
        </thead>
        <tbody>
          <?php foreach ( $args['pdfs'] as $post ) { ?>
            <?php setup_postdata( $post ); ?>
            <?php $related_analysis = beyondparallel_get_posts_using_attachment( $post->ID ); ?>
            <?php // var_dump($post);
              $scale = get_field('scale', $post);
              // var_dump($scale);
              var_dump($selected_filter);
              if (isset($_POST['selectData'])) {
                var_dump($_POST['selectData']); // $_POST['selectData'] is the selected value
                // query here
                // and you can return the result if you want to do some things cool ;)
            }
            ?>
          <tr>  
            <?php if ( $related_analysis ) { ?>
              <td>
                <a href="<?php the_permalink(); ?>" rel="bookmark" title="Download file <?php the_title_attribute(); ?>" target="_blank" download>
                  <svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.66659 18.6432L9.66659 20.6432H20.3333V18.6432H21.6666V21.9765H8.33325L8.33325 18.6432H9.66659Z" fill="#10355F"/>
                    <path d="M14.9999 19.9193L14.3904 19.3099L14.3332 19.3099V19.2527L9.39044 14.3099L10.3332 13.367L14.3333 17.3671L14.3333 8.64319L15.6666 8.64319L15.6666 17.367L19.6666 13.367L20.6094 14.3099L15.6666 19.2527V19.3099H15.6094L14.9999 19.9193Z" fill="#10355F"/>
                    <rect x="0.5" y="0.809814" width="29" height="29" rx="14.5" stroke="#10355F" stroke-opacity="0.9"/>
                  </svg>
                </a>
              </td>
              <td><?php the_title( sprintf( '<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
							  <div class="related-analysis">
								  <h3 class="related-heading">Related Analysis:</h3>
                  <?php foreach ($related_analysis as $id) { ?>
                    <?php $analysis = get_post($id);   ?>
                    <header class="entry-header living-header">
                    <h3 class="entry-title featured-title"><a href="<?php echo esc_url( get_permalink( $analysis ) ); ?>" rel="bookmark"><?php echo get_the_title( $analysis ); ?></a></h3>
									  </header>
                    <div class="entry-summary">
										  <span class="excerpt-date"><?php echo get_the_date( 'l, F j, Y', $analysis ); ?> </span>
									  </div>
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
  