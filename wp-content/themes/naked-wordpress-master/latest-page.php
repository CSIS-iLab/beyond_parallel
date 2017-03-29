<?php
/**
 * 	Template Name: Latest Page
 *
 *	This page template has a sidebar built into it,
 * 	and can be used as a home page, in which case the title will not show up.
 *
*/
get_header(); // This fxn gets the header.php file and renders it ?>
<article class="bodytexture">
<div class="satellitetext">
<div id="primary" class="row-fluid">
<div id="content" role="main" class="span12">

<?php the_title( '<h1 style="margin-top:50px;">', '</h1>' ); 
				echo "<hr>";
				
				?>
			</header><!-- .entry-header -->
			<div class="text-center search-container">

<form role="search" method="get" id="searchform" style="margin-bottom:50px;text-align:center;" action="http://beyondparallel.csis.org/">
    <div class="input-group">
    	<label class="screen-reader-text" for="s">Search for:</label>
        <input type="text" value="" name="s" id="s" class="form-control" placeholder="Search" style="width:34%">
        </span>
<button type="submit" style="border:none;background:none;"><i style="font-size:1em !important;" class="fa fa-search"></i></button>
    </div>
<input type="hidden" name="lang" value="en"></form>

 <?php $query = new WP_Query( array( 'category_name' => 'analysis' ) );

if ( $query->have_posts() ) : ?>

<!-- the loop -->


	<?php while ( $query->have_posts() ) : $query->the_post();

?>

 <?php
echo ( '<div class="post_entry">' ); 
 ?>

		<?php

		// Echo title, date, excerpt, and featured image


				the_title( '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</h2></a>' );


 ?>

<?php
echo "<strong>";
 the_time ('F jS, Y');
echo "</strong>";
?>
<?php echo get_the_post_thumbnail( $_post->ID, 'thumbnail' );

?>




 <?php
echo ( '<div class="excerpt">' ); 
	 echo get_the_excerpt ();
echo ( '<div class="topics">' ); 
echo "  ".__ ('<h3> Topics:</h3>')." ".get_the_category_list(', ');
echo  ('</div>');
echo  ('</div>');
echo  ('</div>');
	 endwhile;

 ?>



	<!-- end of the loop -->


	<?php wp_reset_postdata(); ?>

<?php else : ?>
<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>


			</div>

		<?php
		if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
         ?>

				 		<?php
 			echo '<div class="entry-content">';
 			echo get_the_excerpt();
 			echo '</div>';
 		?>



<?
			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

<a href="http://beyondparallel.csis.org/?s="> <button type="button" class="all-posts btn btn-primary">View All Posts</button></a>


</main><!-- #main -->
</div><!-- .row -->
</div><!-- #primary -->
</div>
</article>


<?php get_footer(); // This fxn gets the footer.php file and renders it ?>

<style>

.btn,.all-posts {
    margin-bottom: 70px;
    font-size: 20px;
margin-left:0;
}


.attachment-thumbnail, .size-thumbnail .wp-post-image {
    float: left;
    padding-right: 10px;
    width: auto;
    height: 220px;
   }
.post_entry {
margin-bottom:70px;
}

.topics {
    margin-top: 18px;
    opacity: .9;
    padding: 10px;
    clear: both;
}

.excerpt {
font-size:20px;
}

@media only screen and (max-width: 500px) {

.excerpt {
clear:both;
}
.attachment-thumbnail, .size-thumbnail .wp-post-image {
display: none;
}

.post_entry {
margin-bottom:50px;
}
 }

</style>
