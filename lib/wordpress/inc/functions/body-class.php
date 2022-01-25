function architecture_body_classes( $classes ) {
	global $post;
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if( is_singular( array( 'post', 'page' )) ) {
		$post_sidebar = get_post_meta( $post->ID, 'architecture_sidebar_layout', true );
		if( empty( $post_sidebar ) ) {
			$classes[] = 'right_sidebar';
		}else{
			$classes[] = $post_sidebar;
		}
	}

	return $classes;
}
add_filter( 'body_class', 'architecture_body_classes' );
