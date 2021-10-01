<?php
/**
 * 	Template Name: AVINK
 *
 *
*/
get_header(); ?>



<div id="primary" class="content-area container">
	<main id="main" class="site-main " role="main">
		<?php
        echo("hola mundo");
        function remove_empty($field)
        {
            if (array_key_exists("findings", $field)) {
                return strlen($field['findings'])>0;
            } else {
                return strlen($field['select'])>0;
            }
        }

            the_title('<h1 class="entry-title">', '</h1>');

                        echo '<div class="living-first">';
                        get_template_part('components/page/content', 'page');
                        echo '</div>';

        query_posts(
            array(
                'post_type' => array('post'),
                'tag' => 'database',
                'posts_per_page' =>  -1
            )
        );
        while (have_posts()) : the_post();


                 ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">

						<?php the_title(sprintf('<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>

					</header>
					<div class="entry-summary">



						<?php
                            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size = 'large')[0];
                            if ($image) {
                                echo '<div class="entry-thumb"><a href="' . esc_url(get_permalink()) . '"><img class="wp-post-image" src="'.$image.'"></a></div>';
                            }
                            ?>


								<?php

                      $repeatable_fields = get_post_meta($post->ID, 'repeatable_fields', true);

                      if ($repeatable_fields) {
                          $repeatable_fields = array_filter($repeatable_fields, "remove_empty");

                          echo '<div class="database_block">';

                          if (has_excerpt($post->ID)) {
                              echo '<p>'.get_the_excerpt($post->ID).' </p>';
                          }

                          if (count($repeatable_fields)>0) {
                              echo '<h4>Related Analysis:</h4>';
                          }

                          foreach ($repeatable_fields as $field) {
                              $findings = isset($field->findings) ? $field['findings'] : null;
                              $findings = preg_replace('/<p>/', '', $findings);
                              $findings = preg_replace('/<\/p>/', '', $findings);

                              $findings = get_the_excerpt($field['select']);

                              $link = get_the_permalink($field['select']);
                              $title = get_the_title($field['select']);

                              if (strlen($field['select'])<1) {
                                  $link = 'https://beyondparallel.csis.org/25-years-of-negotiations-provocations/';
                                  $title = '25 Years of Negotiations and Provocations: North Korea and the United States';
                              }

                              echo '<h5><a href="'.$link.'">'.$title.'</a></h5>';
                              echo '<p>'.html_entity_decode(esc_attr($findings)).' <a href="'.$link.'" class="read-more">Read More</a></p>';

                              $related = isset($field->related) ? $field['related'] : null;
                              $related = preg_replace('/<p>/', '', $related);
                              $related = preg_replace('/<\/p>/', '', $related);

                              echo '<p>'.html_entity_decode(esc_attr($related)).'</p>';
                          }
                          echo '</div>';
                      } else {
                          if (has_excerpt($post->ID)) {
                              echo '<p>'.get_the_excerpt($post->ID).' </p>';
                          }
                      }
                ?>
						</div>

				<div class="clearfix"></div>
				</article>


			<?php
            endwhile;
            wp_reset_query();
            ?>





	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
