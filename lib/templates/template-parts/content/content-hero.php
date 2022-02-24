<?php
/**
 * The template used for displaying hero content
 *
 * @package THEMENAME
 */

$enable_section = get_theme_mod( 'THEMENAME_hero_content_visibility', 'disabled' );

if ( ! THEMENAME_check_section( $enable_section ) ) {
	// Bail if hero content is not enabled
	return;
}

get_template_part( 'template-parts/hero-content/post-type-hero' );

