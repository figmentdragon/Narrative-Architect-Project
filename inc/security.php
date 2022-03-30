<?php
/**
 * Security functions.
 *
 * Enable or disable certain functionality to harden WordPress.
 *
 * @package creativity_ architect
 */

/**
 * Remove generator meta tags.
 *
 * @author WebDevStudios
 * @see https://developer.wordpress.org/reference/functions/the_generator/
 */

/**
 * Disable XML RPC.
 *
 * @author WebDevStudios
 * @see https://developer.wordpress.org/reference/hooks/xmlrpc_enabled/
 */


/**
 * Change REST-API header from "null" to "*".
 *
 * @author WebDevStudios
 * @see https://w3c.github.io/webappsec-cors-for-developers/#avoid-returning-access-control-allow-origin-null
 */
function creativity_cors_control() {
	header( 'Access-Control-Allow-Origin: *' );
}
