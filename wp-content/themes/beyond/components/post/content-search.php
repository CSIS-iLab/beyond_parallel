<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Beyond_Parallel
 */

?>

<article id="post-<?php the_ID(); ?>" class=<?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<div class="post-cats">
			<?php echo get_the_category_list(", "); ?>
		</div>
	</header>
	<div class="entry-summary">
	
	<div class="entry-thumb">

	<?php echo get_the_post_thumbnail( $page->ID, 'thumbnail' ); ?>

		
	</div>
			<span class="excerpt-date"><?php beyond_posted_on(); ?>&#8212; </span>

	<?php
if ( has_excerpt( get_the_id() ) ){
	$excerpt = get_the_excerpt();

	$excerptLength =  strlen($excerpt);
	if ($excerptLength <= 120){
	echo $excerpt . ".. " . wp_trim_words( get_the_content(),35);
	} elseif ($excerptLength > 120 && $excerptLength < 140){
echo $excerpt . ".. " . wp_trim_words( get_the_content(), 25, "...");
} elseif ($excerptLength > 145 && $excerptLength < 250){
echo $excerpt . ".. " . wp_trim_words( get_the_content(), 15);
}else {
		echo $excerpt;
	}


}
 else {
 	echo wp_trim_words( get_the_content(), 50);
 }

?>
	</div>
	<div class="clearfix"></div>
</article>
