<?php
/**
 * creativity architect functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package creativity_architect
 */

 define('THEME_DIR_PATH', get_template_directory());
 define('THEME_DIR_URI', get_template_directory_uri());


if ( ! defined( 'CREATIVITYARCHITECT_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'CREATIVITYARCHITECT_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function creativityarchitect_setup() {
  load_theme_textdomain( 'creativityarchitect', get_template_directory() . '/languages' );

  $GLOBALS['content_width'] = apply_filters(
  'creativityarchitect_content_width', 1920 );

  require get_template_directory() . '/inc/custom-header.php';
  require get_template_directory() . '/inc/template-tags.php';
  require get_template_directory() . '/inc/template-functions.php';
  require get_template_directory() . '/inc/customizer/customizer.php';

  require get_template_directory() . '/includes/bootstrap-wp-navwalker.php';

  add_action( 'after_setup_theme', 'creativityarchitect_content_width', 0 );
  add_action( 'after_setup_theme', 'creativityarchitect_custom_features' );
  add_action( 'after_setup_theme', 'creativityarchitect_setup' );

  add_action( 'widgets_init', 'creativityarchitect_widgets_init' );

  add_action( 'wp_enqueue_scripts', 'creativityarchitect_scripts' );

}

register_nav_menus(
  array(
    'menu-1' => esc_html__( 'Primary', 'creativityarchitect' ),
  )
);

function creativityarchitect_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'creativityarchitect' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'creativityarchitect' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

function creativityarchitect_scripts() {
	wp_enqueue_style( 'creativityarchitect-style', get_stylesheet_uri(), array(), CREATIVITYARCHITECT_VERSION );
	wp_style_add_data( 'creativityarchitect-style', 'rtl', 'replace' );

	wp_enqueue_script( 'creativityarchitect-navigation', get_template_directory_uri() . '/src/js/navigation.js', array(), CREATIVITYARCHITECT_VERSION, true );
  wp_register_script( 'copyright', get_template_directory_uri() . '/src/js/css_comment.js' );

  wp_enqueue_style( 'creativityarchitect-fonts', get_template_directory() .  '/fonts/fonts.css', array(), CREATIVITYARCHITECT_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

function creativityarchitect_copyright() {
  global $wpdb;
  $copyright_dates = $wpdb->get_results("
  SELECT
  YEAR(min(post_date_gmt)) AS firstdate,
  YEAR(max(post_date_gmt)) AS lastdate
  FROM
  $wpdb->posts
  WHERE
  post_status = 'publish'
  ");
  $output = '';
  if($copyright_dates) {
    $copyright = "&copy; " . $copyright_dates[0]->firstdate;
    if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
      $copyright .= '-' . $copyright_dates[0]->lastdate;
    }
    $output = $copyright;
  }
  return $output;
}


if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
