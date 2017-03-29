<?php
/**
 * The template for displaying any single post.
 *
 */

get_header(); // This fxn gets the header.php file and renders it ?>



		<div id="post-<?php the_ID(); ?>" role="main" class="span8 offset2 " style="width:100%;margin-left:0;">

			
<?php if ( have_posts() ) : 
			// Do we have any posts in the databse that match our query?
			?>

				<?php while ( have_posts() ) : the_post(); 
				// If we have a post to show, start a loop that will display it
				?>
		<article class="post">

<div class="postTop">
<center><?php the_post_thumbnail(); ?>
</center>
	
							
						</div>



<div id="post-<?php the_ID(); ?>" class="meta-group">

							<p>By <?php the_author(); ?> | <?php the_time('F j, Y'); // Display the time it was published ?> </p></div>
					<!--/post-meta -->

						<div id="post-<?php the_ID(); ?>" class="the-content satellitetext">

<?php the_title( '<h1 style="margin-top:50px;">', '</h1>' ); ?>
						
							<?php the_content(); 
							// This call the main content of the post, the stuff in the main text box while composing.
							// This will wrap everything in p tags
							?>
							
							<?php wp_link_pages(); // This will display pagination links, if applicable to the post ?>
						<!-- the-content -->
						
						
					</article>

</div>

				<?php endwhile; // OK, let's stop the post loop once we've displayed it ?>
				
			


			<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>
				
				<article class="post error">
					<h1 class="404">Nothing has been posted like that yet</h1>
				</article>

			<?php endif; // OK, I think that takes care of both scenarios (having a post or not having a post to show) ?>

		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->


<?php get_footer(); // This fxn gets the footer.php file and renders it ?>
