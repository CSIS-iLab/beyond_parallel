<?php
add_action( 'the_content', 'heavyheavy_endnotes_output', 1 );

/**
 * Endnotes Output
 *
 * Render endnotes.
 *
 * @package Endnotes
 * @version 1.0.0
 * @since 1.0.0
 * @author Heavy Heavy <@heavyheavyco>
 *
 */

function heavyheavy_endnotes_output( $content ) {

	$options    = get_option( '_heavyheavy_endnotes_settings' );
	$header     = ( isset( $options['endnotes_header'] ) ) ? $options['endnotes_header'] : '';
	$single     = ( isset( $options['endnotes_templates'] ) ) ? $options['endnotes_templates'] : '';
	$collapse   = ( isset( $options['endnotes_collapse'] ) ) ? $options['endnotes_collapse'] : '';
	$linksingle = false;
	$singleurl  = '';

	if ( !is_page() && !is_single() && $single ) $linksingle = true;

	$post_id = get_the_ID();

	$n = 1;
	$notes = array();
	if ( preg_match_all('/\[(\d+\. .*?)\]/s', $content, $matches ) ) {
		foreach( $matches[0] as $fn ) {
			$note = preg_replace( '/\[\d+\. (.*?)\]/s', '\1', $fn );
			$notes[$n] = $note;

			if ( $linksingle ) $singleurl = get_permalink();

			$content = str_replace( $fn, "<sup class='endnote'><a href='$singleurl#en-$post_id-$n' id='enref-$post_id-$n' onclick='return hhEndnotes_show($post_id)'>$n</a></sup>", $content );
			$n++;
		}

		// *****************************************************************************************************
		// Workaround for wpautop() bug. Otherwise it sometimes inserts an opening <p> but not the closing </p>.
		// There are a bunch of open wpautop tickets. See 4298 and 7988 in particular.
		$content .= "\n\n";
		// *****************************************************************************************************

		if ( !$linksingle ) {
			$content .= "<div class='endnotes' id='hhendnotes-$post_id'>";

			if ( $header ) {
				$content .= "<h3>" . esc_html( $header ) . "</h3>";
			}

			if ( $collapse ) {
				$content .= "<a href='#' onclick='return hhEndnotes_toggleVisible($post_id)' class='endnotetoggle'>";
				$content .= "<span class='endnoteshow'>" . sprintf( _n( 'Show %d Footnote', 'Show %d Footnotes', $n - 1, 'endnotes' ), $n - 1 ) . "</span>";
				$content .= "</a>";
				
				$content .= "<ol style='display: none'>";
			} else {
				$content .= "<ol>";
			}
			for( $i = 1; $i < $n; $i++ ) {
				$content .= "<li id='en-$post_id-$i'>$notes[$i] <span class='endnotereverse'><a href='#enref-$post_id-$i'>&#8617;</a></span></li>";
			}
			$content .= "</ol>";
			$content .= "</div>";

		}

	}

	return( $content );
}