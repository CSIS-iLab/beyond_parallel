<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Beyond_Parallel
 */

if ( ! function_exists( 'beyond_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function beyond_posted_on() {

	 if ( function_exists( 'coauthors_posts_links' ) ) :
        printf( __( '%2$s<span class="meta-sep">, by</span> %3$s', 'beyond' ),
            'meta-prep meta-prep-author',
            sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
                get_permalink(),
                esc_attr( get_the_time() ),
                get_the_date()
            ),
            coauthors_posts_links( null, null, null, null, false )
        );
    else:
        printf( __( '%2$s <span class="meta-sep">by</span> %3$s', 'beyond' ),
            'meta-prep meta-prep-author',
            sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
                get_permalink(),
                esc_attr( get_the_time() ),
                get_the_date()
            ),
            sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                get_author_posts_url( get_the_author_meta( 'ID' ) ),
                esc_attr( sprintf( __( 'View all posts by %s', 'beyond' ), get_the_author() ) ),
                get_the_author()
            )
        );
    endif;



}
endif;

if ( ! function_exists( 'beyond_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function beyond_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'beyond' ) );
		if ( $categories_list && beyond_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'beyond' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'beyond' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'beyond' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'beyond' ), esc_html__( '1 Comment', 'beyond' ), esc_html__( '% Comments', 'beyond' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'beyond' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function beyond_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'beyond_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'beyond_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so beyond_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so beyond_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in beyond_categorized_blog.
 */
function beyond_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'beyond_categories' );
}
add_action( 'edit_category', 'beyond_category_transient_flusher' );
add_action( 'save_post',     'beyond_category_transient_flusher' );
