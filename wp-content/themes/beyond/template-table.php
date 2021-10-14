<?php
/**
 * Template part for displaying maps on the table
 *
 *
 */
?>
<?php function get_related_analysis($related_analysis_table) { ?>
  <?php if ($related_analysis_table) { ?>
    <td>
      <a href="<?php the_permalink(); ?>" rel="bookmark" title="Download file <?php the_title_attribute(); ?>" target="_blank" download>
        <img src="<?php echo bloginfo('template_url'); ?>/assets/images/circle-download-icon.svg" />
      </a>
    </td>
    <td><?php the_title(sprintf('<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
      <div class="related-analysis">
        <?php foreach ($related_analysis_table as $id) { ?>
          <?php $analysis = get_post($id);   
          if ( $analysis ) { ?>
            <h3 class="related-heading">Related Analysis:</h3>
            <header class="entry-header living-header">
            <h3 class="entry-title featured-title"><a href="<?php echo esc_url(get_permalink($analysis)); ?>" rel="bookmark"><?php echo get_the_title($analysis); ?></a></h3>
            </header>
            <div class="entry-summary">
              <span class="excerpt-date"><?php echo get_the_date('', $analysis); ?> </span>
            </div>
          <?php } //close if?>
        <?php } //close foreach ?>
        <?php //wp_reset_postdata();?>
      </div> <!-- .related-analysis -->
    </td>  
  <?php } else { ?>
    <td>
      <a href="<?php the_permalink(); ?>" rel="bookmark" title="Download file <?php the_title_attribute(); ?>" target="_blank" download>
        <img src="<?php echo bloginfo('template_url'); ?>/assets/images/circle-download-icon.svg" />
      </a>
    </td>
    <td><?php the_title(sprintf('<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?></td>
  <?php } // end if?>
    <td><?php echo get_field('location-region', $post->ID) ?></td>
    <td><?php the_modified_date(); ?></td>
<?php } ?>

<?php
  if ( isset( $_GET['scale'] ) ) {
     // Grab the value selected in the dropdown from the URL
    $filter_by_scale = rawurldecode( $_GET['scale'] );
  } else {
    $filter_by_scale = 'all';
  }
?>

<table id="imageMaps" class="sortable">
  <thead>
    <th class="sorttable_nosort">
      <img src="<?php echo bloginfo('template_url'); ?>/assets/images/blue-oval-icon.svg" />
    </th>
    <th class="sorttable_nosort"><?php esc_html_e('Description'); ?></th>
    <th><?php esc_html_e('Province'); ?></th>
    <th><?php esc_html_e('Last Updated'); ?></th>
  </thead>
  <tbody>
  <?php foreach ($args['pdfs'] as $post) { ?>
    <?php setup_postdata($post); ?>
    <?php $related_analysis_table = beyondparallel_get_posts_using_attachment($post->ID); ?>
    <?php 
      $scale = get_field('scale', $post);
      if ('all' == $filter_by_scale) { ?>                    
        <tr>  <!-- tr -->
        <!-- Gets all related analysis -->
          <?php get_related_analysis($related_analysis_table); ?>
        </tr> <!-- close tr -->
    <?php } elseif ($scale == $filter_by_scale){ ?>
      <tr>
        <!-- Gets related analysis -->
        <?php get_related_analysis($related_analysis_table); ?>
      </tr>
    <?php } //close elseif  ?> 
  <?php } ?> <!-- close foreach -->
  </tbody>
</table>