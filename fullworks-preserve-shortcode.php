<?php

/*
Plugin Name: Preserve Shortcode
Plugin URI: https://fullworks.net
Description: Shortcode for multisite to preserve scripst and iframes
Version: 1.0
Author: Alan
Author URI: https://fullworks.net
License: A "Slug" license name e.g. GPL2
*/

/* ------------------------------ generic short codes ------------------------------------- */
/*  [preserve][/preserve] to emebed javascript and html without the page editor modifying it
/*----------------------------------------------------------------------------------------- */

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_content', 'wptexturize' );

add_filter( 'the_content', function ($content) {
	$new_content      = '';
	$pattern_full     = '{(\[preserve\].*?\[/preserve\])}is';
	$pattern_contents = '{\[preserve\](.*?)\[/preserve\]}is';
	$pieces           = preg_split( $pattern_full, $content, - 1, PREG_SPLIT_DELIM_CAPTURE );

	foreach ( $pieces as $piece ) {
		if ( preg_match( $pattern_contents, $piece, $matches ) ) {
			$new_content .= html_entity_decode( $matches[1] );
		} else {
			$new_content .= wptexturize( wpautop( $piece ) );
		}
	}

	return $new_content;
}, 10 );
