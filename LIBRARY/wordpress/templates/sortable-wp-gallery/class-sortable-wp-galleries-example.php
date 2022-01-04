<?php

require_once 'class.php';

new Sortable_WordPress_Galleries();

add_action( 'admin_init', 'create_sortable_wordpress_gallery' );

function create_sortable_wordpress_gallery() {
	add_action( 'load-post.php',     'sortable_wordpress_gallery' );
    add_action( 'load-post-new.php', 'sortable_wordpress_gallery' );
	add_action( 'admin_enqueue_scripts', 'sortable_wordpress_gallery_script' );
}

function sortable_wordpress_gallery() {
	$title = __( "Sortable Gallery", 'my_text_domain');
	new Sortable_WordPress_Gallery( "post-metabox", $title );
}

function sortable_wordpress_gallery_script() {
	/**
	 * Be carefull with the path
	 */
	wp_enqueue_script( 'sortable-gallery-admin-js', plugin_dir_url( __FILE__ ). 'admin.js', array( 'jquery' ) );
    wp_enqueue_style( 'sortable-gallery-admin-css', plugin_dir_url( __FILE__ ). 'admin.css' );
}

add_filter( 'sortable_wordpress_galleries', 'add_sortable_gallery' );

function add_sortable_gallery( $galleries ) {
	$galleries[] = array(
		'class' => 'Sortable_WordPress_Gallery',
		'id' => 'post-metabox',
		'title' => 'Sortable Gallery' 
	);

	$galleries[] = array(
		'class' => 'Sortable_WordPress_Gallery',
		'id' => 'post-metabox-2',
		'title' => 'Sortable Gallery-2' 
	);

	return $galleries;
}

/**
 * Filtering the second gallery display option
 */
add_filter( 'sortable_wordpress_gallery_post-metabox-2_post_types',  'second_gallery_only_on_page' );
function second_gallery_only_on_page( $post_types ) {
  
  return array( 'page' );
}