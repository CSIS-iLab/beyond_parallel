<?php
/**
 * The template for displaying the home/index page.
 * This template will also be called in any case where the Wordpress engine 
 * doesn't know which template to use (e.g. 404 error)
 */

get_header(); // This fxn gets the header.php file and renders it ?>
<div class="bodytexture">
<div id="primary" class="row-fluid">
<div id="content" role="main" class="span8 offset2">

<center><h2 style="padding-top: 32px;"> SEARCH RESULTS </h2></center>


<?php if ( have_posts() ) : 
// Do we have any posts in the databse that match our query?
// In the case of the home page, this will call for the most recent posts 
?>

<?php while ( have_posts() ) : the_post(); 
// If we have some posts to show, start a loop that will display each one the same way
?>

<article class="post">
<h1 class="title">
<a href="<?php the_permalink(); // Get the link to this post ?>" title="<?php the_title(); ?>">
<?php the_title(); // Show the title of the posts as a link ?>
</a>
</h1>

<?php the_excerpt(); ?>

<div class="meta clearfix">
<div class="category"><?php echo get_the_category_list(); // Display the categories this post belongs to, as links ?></div>
<div class="tags"><?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); // Display the tags this post has, as links separated by spaces and pipes ?></div>
</div><!-- Meta -->
</article>

<?php endwhile; // OK, let's stop the posts loop once we've exhausted our query/number of posts ?>


<?php
global $wp_query;

$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages
) );
?>


<?php else : // Well, if there are no posts to display and loop through, let's apologize to the reader (also your 404 error) ?>
<article class="post error">
<center><p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p></center>

</article>

<?php endif; // OK, I think that takes care of both scenarios (having posts or not having any posts) ?>
</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
</div>
<?php get_footer(); // This fxn gets the footer.php file and renders it ?>

<style>
 .post {
    margin-bottom:40px;
}
p {
 font-family: 'museo-sans', sans-serif;
    font-size:20px;
line-height:30px;
}

.nav-links {
    margin-bottom: 18px;
    padding: 10px;
    display: inline-block;
}

a {
    font-family: 'museo-sans',sans-serif;
}

.screen-reader-text {
display:none;
}
.fa {

border: none !important;
}

.current {
    color: #0f2a48 !important;
     font-family: 'museo-sans', sans-serif;
}

</style>