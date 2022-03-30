<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package creativity architect
 */

/**
 * Returns true if a blog has more than 1 category, else false.
 *
 * @author WebDevStudios
 *
 * @return bool Whether the blog has more than one category.
 */
function categorized_blog() {
	$category_count = get_transient( 'categories' );

	if ( false === $category_count ) {
		$category_count_query = get_categories( [ 'fields' => 'count' ] );

		$category_count = isset( $category_count_query[0] ) ? (int) $category_count_query[0] : 0;

		set_transient( 'categories', $category_count );
	}

	return $category_count > 1;
}

/**
 * Get an attachment ID from it's URL.
 *
 * @author WebDevStudios
 *
 * @param string $attachment_url The URL of the attachment.
 *
 * @return int    The attachment ID.
 */
function get_attachment_id_from_url( $attachment_url = '' ) {
	global $wpdb;

	$attachment_id = false;

	// If there is no url, return.
	if ( '' === $attachment_url ) {
		return false;
	}

	// Get the upload directory paths.
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image.
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image.
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL.
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Do something with $result.
		// phpcs:ignore phpcs:ignore WordPress.DB -- db call ok, cache ok, placeholder ok.
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM {$wpdb->posts} wposts, {$wpdb->postmeta} wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = %s AND wposts.post_type = 'attachment'", $attachment_url ) );
	}

	return $attachment_id;
}

/**
 * Shortcode to display copyright year.
 *
 * @author Haris Zulfiqar
 *
 * @param array $atts Optional attributes.
 *     $starting_year Optional. Define starting year to show starting year and current year e.g. 2015 - 2018.
 *     $separator Optional. Separator between starting year and current year.
 *
 * @return string Copyright year text.
 */
function copyright_year( $atts ) {
	// Setup defaults.
	$args = shortcode_atts(
		[
			'starting_year' => '',
			'separator'     => ' - ',
		],
		$atts
	);

	$current_year = gmdate( 'Y' );

	// Return current year if starting year is empty.
	if ( ! $args['starting_year'] ) {
		return $current_year;
	}

	return esc_html( $args['starting_year'] . $args['separator'] . $current_year );
}

add_shortcode( 'copyright_year', 'copyright_year', 15 );

/**
 * Retrieve the URL of the custom logo uploaded, if one exists.
 *
 * @author Corey Collins
 */
function get_custom_logo_url() {

	$custom_logo_id = get_theme_mod( 'custom_logo' );

	if ( ! $custom_logo_id ) {
		return;
	}

	$custom_logo_image = wp_get_attachment_image_src( $custom_logo_id, 'full' );

	if ( ! isset( $custom_logo_image[0] ) ) {
		return;
	}

	return $custom_logo_image[0];
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', '_tk' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'wp_title', 10, 2 );
