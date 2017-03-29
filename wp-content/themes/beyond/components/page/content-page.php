<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Beyond_Parallel
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header">
		<?php //the_title( '<h1 class="entry-title">', '</h1>' ); 
		?>
	</div><!--/entry header-->


	<div class="the-content">
		<?php the_content(); 
							// This call the main content of the post, the stuff in the main text box while composing.
							// This will wrap everything in p tags
		?>


	</div><!-- the-content -->
	<footer class="entry-footer">
			<?php wp_link_pages(); // This will display pagination links, if applicable to the post ?>
		

	

	</footer>
</article><!-- #post-## -->