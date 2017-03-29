<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Beyond_Parallel
 */

get_header(); ?>

	<div id="primary" class="content-area container">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="archive-header">
					<?php
							
					$text=get_the_archive_title();
					$text=explode(' ',$text);
					$text[0]='<span class="">'.$text[0].'</span>';
					$text=implode(' ',$text);
					echo $text;

					?>

			</h1>
				
			</header>

			<?php
			/* Start the Loop */

			while ( have_posts() ) : the_post();
				
				get_template_part( 'components/post/content-search', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'components/post/content', 'none' );

		endif; ?>

		</main>
	</div>
<?php
get_sidebar();
get_footer();
