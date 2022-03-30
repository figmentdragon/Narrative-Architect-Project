<?php

function creativity_nav() {
  wp_nav_menu(
    array(
      'theme_location'  => 'header-menu',
      'menu'            => '',
      'container'       => 'div',
      'container_class' => 'menu-{menu slug}-container',
      'container_id'    => '',
      'menu_class'      => 'menu',
      'menu_id'         => '',
      'echo'            => true,
      'fallback_cb'     => 'wp_page_menu',
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<ul>%3$s</ul>',
      'depth'           => 0,
      'walker'          => '',
    )
  );
}
// Register navigation menus.
register_nav_menus(
	[
	  'primary' => esc_html__( 'Primary Menu', 'creativity' ),
		'footer'  => esc_html__( 'Footer Menu', 'creativity' ),
		'mobile'  => esc_html__( 'Mobile Menu', 'creativity' ),
    'social'  => esc_html__( 'SOcial Menu', 'creativity' ),
	]
);

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args( $args = '' ) {
    $args['container'] = false;
    return $args;
}
