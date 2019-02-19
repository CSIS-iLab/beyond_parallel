<?php
/**
 * Custom shortcodes for the theme
 *
 * @package Beyond_Parallel
 */

 /**
  * Adds styled link to specific post
  * @param  array $atts    Modifying arguments
  * @param  string $content Embedded content
  * @return string          Styled Link
  */
  function shortcode_button($atts)
  {
    //   // Attributes
    //   $atts = shortcode_atts(
    //     array(
    //         'id' => null,
    //         'title' => null,
    //         'url' => null,
    //     ),
    //     $atts,
    //     'button'
    // );
      $title = $atts['title'];
      $id = $atts['id'];
      $post_title = get_the_title($id);
      $post_url = get_the_permalink($id);
      $url = $post_url;
      $post_type = ucwords(get_post_type($id));

      if (empty($title)) {
          if (has_tag('database')) {
              $title = 'READ THE ANALYSIS';
          } else {
              $title = 'EXPLORE THE DATA';
          }
      }

      if (empty($id)) {
          $url = $atts['url'];

          if (empty($atts['title'])) {
            $title = 'READ THE ANALYSIS';
          } else{
            $title = $atts['title'];
          }
      }

      return  '<div class="followButton"> <a href="'.esc_url($url).'" rel="bookmark" title="' . esc_attr($title) .'"> <span class="arrow">'.esc_attr($title).'</span> </a> </div>';
  }
 add_shortcode('button', 'shortcode_button');

 /**
 * Shortcode for displaying an aside block in posts.
 * @param  array $atts    Modifying arguments
 * @param  string $content Embedded content
 * @return string          Aside block
 */
function shortcode_aside($atts, $content = null)
{
    $atts = shortcode_atts(
        array(
            'align' => 'left',
        ),
        $atts,
        'aside'
    );
    if ('right' == $atts['align']) {
        $align_class = ' alignright';
    } elseif ('left' == $atts['align']) {
        $align_class = ' alignleft';
    } elseif ('center' == $atts['align']) {
        $align_class = ' aligncenter';
    }
    return '<aside class="post-aside' . $align_class . '"><div class="rule"></div><p>' . do_shortcode($content) . '</p></aside>';
}
add_shortcode('aside', 'shortcode_aside');
