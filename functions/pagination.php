<?php
/**
 * Sleekr Lite Custom Pagination Functions
 *
 * @since 1.0.0
 * @package Sleekr_Lite
 */
//Archive Pages Pagination Between Lists of Posts
function sleekr_custom_pagination() {
    if ( !is_single() && !is_page() ) {
	    echo '<ul class="pager"><li class="previous">';
        next_posts_link( esc_html_x('&larr; Older','Blog/Archive pagination','sleekr-lite') );
        echo '</li><li class="next">';
        previous_posts_link( esc_html_x('Newer &rarr;','Blog/Archive pagination','sleekr-lite') );
        echo '</li></ul>';
    } else {
        wp_link_pages( array(
        	'before'            => '<div class="text-center"><ul class="pagination">',
        	'after'             => '</ul></div>',
        	'link_before'       => '',
        	'link_after'        => '',
        	'next_or_number'    => 'number',
        	) );
    }
}
//Single Post/Page Pagination Inside Post/Page
function sleekr_link_pages( $link ) {
    if ( ctype_digit( $link ) ) {
        return '<li class="active"><span>' . $link . '</span></li>';
    } else {
        return '<li>' . $link . '</li>';
    }
    return $link;
}
add_filter( 'wp_link_pages_link', 'sleekr_link_pages' );
