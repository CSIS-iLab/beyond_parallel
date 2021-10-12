<?php
/**
 * Template part for displaying maps on the table
 *
 *
 */
?>

<?php function get_related_analysis($related_analysis_table) { ?>
  <?php if ($related_analysis_table) { ?>
    <td style="width: 5%;">
      <a href="<?php the_permalink(); ?>" rel="bookmark" title="Download file <?php the_title_attribute(); ?>" target="_blank" download>
        <svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M9.66659 18.6432L9.66659 20.6432H20.3333V18.6432H21.6666V21.9765H8.33325L8.33325 18.6432H9.66659Z" fill="#10355F"/>
          <path d="M14.9999 19.9193L14.3904 19.3099L14.3332 19.3099V19.2527L9.39044 14.3099L10.3332 13.367L14.3333 17.3671L14.3333 8.64319L15.6666 8.64319L15.6666 17.367L19.6666 13.367L20.6094 14.3099L15.6666 19.2527V19.3099H15.6094L14.9999 19.9193Z" fill="#10355F"/>
          <rect x="0.5" y="0.809814" width="29" height="29" rx="14.5" stroke="#10355F" stroke-opacity="0.9"/>
        </svg>
      </a>
    </td>
    <td style="width: 55%;"><?php the_title(sprintf('<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
      <div class="related-analysis">
        <?php foreach ($related_analysis_table as $id) { ?>
          <?php $analysis = get_post($id);   
          if ( $analysis ) { ?>
            <h3 class="related-heading">Related Analysis:</h3>
            <header class="entry-header living-header">
            <h3 class="entry-title featured-title"><a href="<?php echo esc_url(get_permalink($analysis)); ?>" rel="bookmark"><?php echo get_the_title($analysis); ?></a></h3>
            </header>
            <div class="entry-summary">
              <span class="excerpt-date"><?php echo get_the_date('l, F j, Y', $analysis); ?> </span>
            </div>
          <?php } //close if?>
        <?php } //close foreach ?>
        <?php //wp_reset_postdata();?>
      </div> <!-- .related-analysis -->
    </td>  
  <?php } else { ?>
    <td></td>
    <td style="width: 55%;"><?php the_title(sprintf('<h2 class="entry-title featured-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?></td>
  <?php } // end if?>
    <td style="width: 20%;"><?php echo get_field('location-region', $post->ID) ?></td>
    <td style="width: 20%;"><?php the_modified_date(); ?></td>
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
    <th class="sorttable_nosort" style="width: 5%;"><?php esc_html_e(' '); ?></th>
    <th class="sorttable_nosort" style="width: 55%;"><?php esc_html_e('Description'); ?></th>
    <th style="width: 20%;"><?php esc_html_e('Province'); ?></th>
    <th style="width: 20%;"><?php esc_html_e('Last Updated'); ?></th>
  </thead>
  <tbody>
  <?php foreach ($args['pdfs'] as $post) { ?>
    <?php setup_postdata($post); ?>
    <?php $related_analysis_table = beyondparallel_get_posts_using_attachment($post->ID); ?>
    <?php // var_dump($post);
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