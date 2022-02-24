<?php
/**
 * Add WooCommerce Elements in header
 *
 * @package THEMENAME
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    // Bail if WooCommerce is not installed
    return;
}

if ( get_theme_mod( 'THEMENAME_header_cart_enable', 0 ) && function_exists( 'THEMENAME_header_cart' ) ) {
	THEMENAME_header_cart();
}
