<?php
		/*-----------------------------------------------------------------------------------*/
		/* This file will be referenced every time a template/page loads on your Wordpress site
		/* This is the place to define custom fxns and specialty code
		/*-----------------------------------------------------------------------------------*/

// Define the version so we can easily replace it throughout the theme
define( 'architecture_VERSION', 1.0 );

require_once( 'theme/inc/architecture.php' );
require_once( 'theme/inc/custom-functions.php' );

require get_template_directory() . '/inc/starter-content.php';
require get_template_directory() . '/inc/class-architecture-svg-icons.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/menu-functions.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/class-architecture-customize.php';
new architecture_Customize();

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*_____________________________________________________ SETUP */
function architecture_setup() {

	architecture_theme_support();

	add_editor_style( get_stylesheet_directory_uri() . 'theme/assets/scripts/css/editor-style.css' );

	//add_action( 'admin_menu' , 'front_page_on_pages_menu' );
	add_action( 'after_setup_theme', 'architecture_custom_logo_setup' );
	add_action( 'after_setup_theme', 'architecture_register_nav_menus', 0 );
	add_action( 'customize_preview_init', 'architecture_customize_preview_init' );
	add_action( 'customize_controls_enqueue_scripts', 'architecture_customize_controls_enqueue_scripts' );
	add_action( 'customize_register', 'architecture_theme_customizer' );
	add_action( 'init', 'architecture_head_cleanup' );
	add_action( 'init', 'architecture_custom_menu' );
	add_action( 'widgets_init', 'architecture_register_sidebars' );
	add_action( 'wp_enqueue_scripts', 'architecture_scripts' );
	add_action( 'wp_enqueue_scripts', 'architecture_style' );
	add_action( 'wp_footer', 'deregister_scripts' );
	add_action( 'wp_head', 'add_gtag_to_head' );
	add_action( 'wp_head', 'architecture_head_cleanup' );
	add_action( 'wp_head', 'architecture_remove_recent_comments_style', 1 );

	add_action( 'wp_print_styles', 'deregister_styles', 100 );

  	add_filter( 'excerpt_more', 'architecture_excerpt_more' );
	add_filter( 'gallery_style', 'architecture_gallery_style' );
	add_filter( 'image_size_names_choose', 'architecture_custom_image_sizes' );
	add_filter( 'post_comments_feed_link', 'architecture_post_comments_feed_link');
	add_filter( 'post_thumbnail_html', 'wpb_autolink_featured_images', 10, 3 );
	add_filter( 'script_loader_tag', 'defer_scripts', 10, 3 );
	add_filter( 'show_admin_bar', '__return_false' );
  add_filter( 'the_content', 'architecture_filter_ptags_on_images' );
	add_filter( 'the_generator', 'architecture_rss_version' );
	add_filter( 'wp_head', 'architecture_remove_wp_widget_recent_comments_style', 1 );
	add_filter( 'wp_nav_menu_args', 'architecture_nav_menu_args');
	add_filter( 'wp_title', 'rw_title', 10, 3 );

}
add_action( 'after_setup_theme', 'architecture_setup' );


if ( ! isset( $content_width ) ) $content_width = 900;

/*________________________________________________ THUMBNAILS */
add_image_size( 'architecture-thumb-600', 600, 150, true );
add_image_size( 'architecture-thumb-300', 300, 100, true );


function architecture_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'architecture-thumb-600' => __('600px by 150px'),
        'architecture-thumb-300' => __('300px by 100px'),
    ) );
}

/*__________________________________________ REGISTER SIDEBAR */
function architecture_register_sidebars() {
	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'footer', 					// Make an ID
		'name' => 'Footer',				// Name it
		'description' => 'Social Icons', // Dumb description for the admin side
		'before_widget' => '<div>',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title' => '</h3>',		// What to display following each widget's title
		'empty_title'=> '',					// What to display in the case of no title defined for a widget
		// Copy and paste the lines above right here if you want to make another sidebar,
		// just change the values of id and name to another word/name
	));
}


/*____________________________________________ Comment Layout */
function architecture_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'architecture' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'architecture' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'architecture' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'architecture' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!






	/*-----------------------------------------------------------------------------------*/
	/* Enqueue Styles and Scripts
	/*-----------------------------------------------------------------------------------*/

function architecture_style() {
	wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');

	wp_register_style( 'aos-css', get_stylesheet_directory_uri() . '/theme/assets/vendor/aos/aos.css' );

	wp_register_style( 'bootstrap-icons', get_stylesheet_directory_uri() . '/theme/assets/vendor/bootstrap-icons/bootstrap-icons.css' );

	wp_register_style( 'boxicons-css',
	get_stylesheet_directory_uri() . '/theme/assets/vendor/boxicons/css/boxicons.min.css', );

	wp_register_style( 'glightbox-css',
	get_stylesheet_directory_uri() . '/theme/assets/vendor/glightbox/css/glightbox.min.css', );

	wp_register_style( 'swiper-css', get_stylesheet_directory_uri() . '/theme/assets/vendor/swiper/swiper-bundle.min.css', );

	wp_register_style( 'fontawesome-style', get_stylesheet_directory_uri() . '/theme/assets/img/icons/fontawesome/css/all.css' );

	wp_enqueue_style( 'aos-css' );
	wp_enqueue_style( 'bootstrap-icons' );
	wp_enqueue_style( 'boxicons-css' );
	wp_enqueue_style( 'glightbox-css' );
	wp_enqueue_style( 'swiper-css' );
	wp_enqueue_style( 'fontawesome-style' );
}

function architecture_scripts() {
//adding scripts file in the footer
	wp_register_script( 'architecture', get_stylesheet_directory_uri().
	'assets/scripts/js/scripts.js', array( 'jquery' ) );
	wp_register_script( 'portfolio-main', get_stylesheet_directory_uri() .
	'assets/scripts/js/main.js' );
	wp_register_script( 'cardspec', get_stylesheet_directory_uri() . 'assets/scripts/js/cardsSpec.js' );
	wp_register_script( 'purecounter', get_stylesheet_directory_uri() . 'assets/vendor/purecounter/purecounter.js' );
    wp_register_script( 'portfolio', get_stylesheet_directory_uri() . 'assets/scripts/js/portfolio.js' );
	wp_register_script(  'aos', get_stylesheet_directory_uri() . 'theme/assets/vendor/aos/aos.js' );

	wp_register_script(  'glightbox', get_stylesheet_directory_uri() . 'theme/assets/vendor/glightbox/js/glightbox.min.js' );

	wp_register_script( 'isotope', get_stylesheet_directory_uri() . 'theme/assets/vendor/isotope-layout/isotope.pkgd.min.js' );

	wp_register_script( 'swiper', get_stylesheet_directory_uri() . 'theme/assets/vendor/swiper/swiper-bundle.min.js' );

	wp_register_script(  'typed', get_stylesheet_directory_uri() . 'theme/assets/vendor/typed.js/typed.min.js' );

	wp_register_script( 'noframework', get_stylesheet_directory_uri() . 'theme/assets/vendor/waypoints/noframework.waypoints.js' );

	wp_register_script( 'email-form', get_stylesheet_directory_uri() . 'theme/assets/vendor/php-email-form/validate.js' );

	wp_register_script( 'fontawesome',
	get_stylesheet_directory_uri() . 'theme/assets/scripts/js/fontawesome/all.js' );

	wp_register_script( 'base-components',
	get_stylesheet_directory_uri() . 'theme/assets/vendor/bootstrap/js/dist/base-components.js' );

	wp_register_script( 'button',
	get_stylesheet_directory_uri() . 'theme/assets/vendor/bootstrap/js/dist/button.js' );

	wp_register_script( 'carousel',
	get_stylesheet_directory_uri() . 'theme/assets/vendor/bootstrap/js/dist/carousel.js' );

	wp_register_script( 'drop-down',
	get_stylesheet_directory_uri() . 'theme/assets/vendor/bootstrap/js/dist/dropdown.js' );

	wp_register_script( 'modal',
	get_stylesheet_directory_uri() . 'theme/assets/vendor/bootstrap/js/dist/modal.js' );

	wp_register_script( 'scrollspy',
	get_stylesheet_directory_uri() . 'theme/assets/vendor/bootstrap/js/dist/scrollspy.js' );

	wp_register_script( 'tab',
	get_stylesheet_directory_uri() . 'theme/assets/vendor/bootstrap/js/dist/tab.js' );

// add theme scripts
	wp_enqueue_script( 'architecture' );
	wp_enqueue_script( 'portfolio-main' );
	wp_enqueue_script( 'cardspec' );
	wp_enqueue_script( 'purecounter' );
	wp_enqueue_script( 'aos' );
	wp_enqueue_script( 'glightbox' );
	wp_enqueue_script( 'isotope' );
	wp_enqueue_script( 'swiper' );
	wp_enqueue_script( 'typed' );
	wp_enqueue_script( 'noframework' );
	wp_enqueue_script( 'email-form' );
	wp_enqueue_script( 'fontawesome' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'tab' );
	wp_enqueue_script( 'scrollspy' );
	wp_enqueue_script( 'modal' );
	wp_enqueue_script( 'drop-down' );
	wp_enqueue_script( 'carousel' );
	wp_enqueue_script( 'button' );
	wp_enqueue_script( 'base-components' );
}

function architecture_customize_preview_init() {
	wp_enqueue_script(
		'architecture-customize-helpers',
		get_theme_file_uri( '/theme/assets/scripts/js/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);

	wp_enqueue_script(
		'architecture-customize-preview',
		get_theme_file_uri( '/theme/assets/scripts/js/customize-preview.js' ),
		array( 'customize-preview', 'customize-selective-refresh', 'jquery', 'architecture-customize-helpers' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}


/**
* Enqueue scripts for the customizer.
*
* @since architecture 1.0
*
* @return void
*/
function architecture_customize_controls_enqueue_scripts() {

	wp_enqueue_script(
		'architecture-customize-helpers',
		get_theme_file_uri( '/theme/assets/scripts/js/customize-helpers.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}

/**
* Calculate classes for the main <html> element.
*
* @since architecture 1.0
*
* @return void
*/
function architecture_the_html_classes() {
/**
 * Filters the classes for the main <html> element.
 *
 * @since architecture 1.0
 *
 * @param string The list of classes. Default empty string.
 */
$classes = apply_filters( 'architecture_html_classes', '' );
if ( ! $classes ) {
	return;
}
echo 'class="' . esc_attr( $classes ) . '"';
}

/* ________________________________________________ COPYRIGHT */
function architecture_copyright() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results(
		"SELECT
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

	/************* THEME CUSTOMIZE *********************/

	/*
	  A good tutorial for creating your own Sections, Controls and Settings:
	  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722

	  Good articles on modifying the default options:
	  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
	  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162

	  To do:
	  - Create a js for the postmessage transport method
	  - Create some sanitize functions to sanitize inputs
	  - Create some boilerplate Sections, Controls and Settings
	*/

	function architecture_theme_customizer($wp_customize) {
	  // $wp_customize calls go here.
	  //
	  // Uncomment the below lines to remove the default customize sections

	 //  $wp_customize->remove_section('title_tagline');
	 //  $wp_customize->remove_section('colors');
	 //  $wp_customize->remove_section('background_image');
	 //  $wp_customize->remove_section('static_front_page');
	 //  $wp_customize->remove_section('nav');

	 // Uncomment the below lines to remove the default controls
	 //  $wp_customize->remove_control('blogdescription');

	  // Uncomment the following to change the default sectiontitles
	 //  $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
	 //  $wp_customize->get_section('background_image')->title = __( 'Images' );
	}
