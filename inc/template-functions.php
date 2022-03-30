<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package creativity_
 */

 if ( ! function_exists( 'creativity_fallback_menu' ) ) :
 	/**
 	 * Display default page as navigation if no custom menu was set
 	 */
 	function creativity_fallback_menu() {
 		$pages = wp_list_pages( 'title_li=&echo=0' );
 		echo '<ul id="menu-main-navigation" class="main-navigation-menu menu">' .  $pages  . '</ul>';  // WPCS: XSS OK.
 	}
 endif;

 /**
  * Adds custom classes to the array of post classes.
  *
  * @param array $classes Classes for the post element.
  * @return array
  */
 function creativity_post_classes( $classes ) {

 	// Add comments-off class.
 	if ( ! ( comments_open() || get_comments_number() ) ) {
 		$classes[] = 'comments-off';
 	}

 	return $classes;
 }
 add_filter( 'post_class', 'creativity_post_classes' );


//	Move the read more link outside of the post summary paragraph
add_filter( 'the_content_more_link', 'creativity_move_more_link' );
	function creativity_move_more_link() {
	return '<p><a class="more-link" href="'. esc_url(get_permalink()) . '">' . esc_html__( 'Continue Reading', 'creativity' ) . '</a></p>';
}

/**
 * Change excerpt length for default posts
 * @param int $length Length of excerpt in number of words.
 * @return int
 */
function creativity_excerpt_length( $length ) {

 if ( is_admin() ) {
   return $length;
 }

 // Get excerpt length from database.
 $excerpt_length = esc_attr(get_theme_mod( 'creativity_excerpt_length', '35' ) );
 // Return excerpt text.
 if ( $excerpt_length >= 0 ) :
   return absint( $excerpt_length );
 else :
   return 35; // Number of words.
 endif;
}
add_filter( 'excerpt_length', 'creativity_excerpt_length' );

/**
 * Adding the read more button to our custom excerpt
 * @link https://codex.wordpress.org/Function_Reference/has_excerpt
 */
function creativity_excerpt_more_for_manual_excerpts( $excerpt ) {
    global $post;

    if ( has_excerpt( $post->ID ) ) {
        $excerpt .= creativity_excerpt_more( '&hellip;' );
    }

    return $excerpt;
}
add_filter( 'get_the_excerpt', 'creativity_excerpt_more_for_manual_excerpts' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function creativity_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'creativity_pingback_header' );
