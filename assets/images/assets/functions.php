<?php
 /** -------------------------------------------------------------------------*
 * creativity functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package creativity
 *
 * This file will be referenced every time a template/page loads on your Wordpress site
 * This is the place to define custom fxns and specialty code
 * --------------------------------------------------------------------------*/

/**-----------------------------*
 * Definitions
 * -----------------------------*/

// Define the version so we can easily replace it throughout the theme
if ( ! defined( 'CREATIVITY_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'CREATIVITY_VERSION', '1.0.0' );
}

/*-----------------------------*
 * Required Files
 *-----------------------------*/
// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

require get_template_directory() . '/inc/custom-functions.php';

// SVG Icons
require get_template_directory() . '/inc/icons.php';
require get_template_directory() . '/inc/inline-styles.php';
require get_template_directory() . '/inc/sidebars.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/theme-support.php';




if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/*-----------------------------*
 * Set Up
 *-----------------------------*/

function creativity_setup() {
	global $content_width;
	if ( ! isset( $content_width ) ) {
    $content_width = 1600;
	}
  $GLOBALS['content_width'] = 1600;

  add_action( 'after_setup_theme', 'creativity_content_width', 0 );
  add_action( 'after_setup_theme', 'creativity_custom_logo_setup' );
  add_action( 'after_setup_theme', 'creativity_custom_theme_features' );
  add_action( 'after_setup_theme', 'creativity_setup' );

  add_action( 'after_switch_theme', 'creativity_setup_options' );

  // launching operation cleanup
  add_action( 'init', 'creativity_head_cleanup' );

  add_action( 'tgmpa_register', 'creativity_register_required_plugins' );

  add_action( 'widgets_init', 'creativity_register_sidebars' );

  add_action( 'wp_enqueue_scripts', 'creativity_conditional_scripts' );
  add_action( 'wp_enqueue_styles', 'creativity_get_font_face_styles');
  add_action( 'wp_enqueue_scripts', 'creativity_scripts' );
  add_action( 'wp_enqueue_scripts', 'creativity_scripts_and_styles' );
  add_action( 'wp_enqueue_scripts', 'creativity_styles' );

  add_action( 'wp_head', 'creativity_javascript_detection', 0 );
  add_action( 'wp_head', 'creativity_preload_webfonts' );


  add_filter( 'excerpt_length', 'creativity_excerpt_length', 999 );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'creativity_excerpt_more' );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'creativity_gallery_style' );
  add_filter( 'image_size_names_choose', 'creativity_custom_image_sizes' );
  // remove Wp version from scripts
	add_filter( 'script_loader_src', 'creativity_remove_wp_ver_css_js', 9999 );
  // remove WP version from css
	add_filter( 'style_loader_src', 'creativity_remove_wp_ver_css_js', 9999 );
  // cleaning up random code around images
  add_filter( 'the_content', 'creativity_filter_ptags_on_images' );
  add_filter( 'the_content_more_link', 'creativity_more_link', 10, 2 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'creativity_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'creativity_remove_wp_widget_recent_comments_style', 1 );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );

  add_image_size( 'creativity-blogthumb', 1300, 9999, true );
  add_image_size( 'creativity-logo', 400, 400, true );
  add_image_size( 'creativity-portfolio', 1920, 9999, true ); // Flexible Height
  add_image_size( 'creativity-slider', 1920, 1080, true ); // Ratio 16:9

  load_theme_textdomain( '', get_template_directory() . '/languages' );

  // links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
  // previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
  // EditURI link
  remove_action( 'wp_head', 'rsd_link' );
  // start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
  // windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
  // WP version
	remove_action( 'wp_head', 'wp_generator' );

}

/*-----------------------------*
 * Register
 *-----------------------------*/


function creativity_register_sidebars() {
  register_sidebar(
    array(
			'name'          => esc_html__( 'Sidebar', 'creativity' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'creativity' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

function creativity_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// Catch Web Tools.
		array(
			'name' => 'Catch Web Tools', // Plugin Name, translation not required.
			'slug' => 'catch-web-tools',
		),
		// Catch IDs
		array(
			'name' => 'Catch IDs', // Plugin Name, translation not required.
			'slug' => 'catch-ids',
		),
		// To Top.
		array(
			'name' => 'To top', // Plugin Name, translation not required.
			'slug' => 'to-top',
		),
		// Catch Gallery.
		array(
			'name' => 'Catch Gallery', // Plugin Name, translation not required.
			'slug' => 'catch-gallery',
		),
	);

	if ( ! class_exists( 'Catch_Infinite_Scroll_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Infinite Scroll', // Plugin Name, translation not required.
			'slug' => 'catch-infinite-scroll',
		);
	}

	if ( ! class_exists( 'Essential_Content_Types_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Content Types', // Plugin Name, translation not required.
			'slug' => 'essential-content-types',
		);
	}

	if ( ! class_exists( 'Essential_Widgets_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Widgets', // Plugin Name, translation not required.
			'slug' => 'essential-widgets',
		);
	}

	if ( ! class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Instagram Feed Gallery & Widget', // Plugin Name, translation not required.
			'slug' => 'catch-instagram-feed-gallery-widget',
		);
	}

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'creativity',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

/*-----------------------------*
 * Functions
 *-----------------------------*/

function creativity_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

function creativity_copyright() {
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

function creativity_custom_image_sizes( $sizes ) {
  return array_merge( $sizes,
    array(
      'creativity-slider' => __('1920px by 1080px'),
      'creativity-portfolio' => __('1920px by 9999px'),
      'creativity-logo' => __('400px by 400px'),
      'creativity-blogthumb' => __('1300px by 9999px'),
    )
  );
}
if( esc_attr(get_theme_mod( 'creativity_crop_large_featured', false ) ) ) {
  add_image_size( 'creativity-large', 960, 575, true );
}

// Recent Posts widget thumbnail
if( esc_attr(
  get_theme_mod(
    'creativity_crop_recent', false )
    )
  )
  {
    add_image_size( 'creativity-recent-thumbnail', 90, 120, true );
  }


// remove injected CSS from gallery
function creativity_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

// A better title
// http://www.deluxeblogtips.com/2012/03/better-title-meta-tag.html
function rw_title( $title, $sep, $seplocation ) {
  global $page, $paged;

  // Don't affect in feeds.
  if ( is_feed() ) return $title;

  // Add the blog's name
  if ( 'right' == $seplocation ) {
    $title .= get_bloginfo( 'name' );
  } else {
    $title = get_bloginfo( 'name' ) . $title;
  }

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );

  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title .= " {$sep} {$site_description}";
  }

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 ) {
    $title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );
  }

  return $title;

} // end better title

// remove WP version from RSS
function creativity_rss_version() { return ''; }

// remove WP version from scripts
function creativity_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function creativity_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}


/*-----------------------------*
 * If Function Exist
 *-----------------------------*/


if ( ! function_exists( 'creativity_more_link' ) ) :
	/**
	 * Replacing Continue reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 *
	 * @since 1.0
	 */
	function creativity_more_link( $more_link, $more_link_text ) {
		$more_tag_text = get_theme_mod( 'creativity_excerpt_more_text', esc_html__( 'Continue reading', 'creativity' ) );

		return ' &hellip; ' . str_replace( $more_link_text, wp_kses_data( $more_tag_text ), $more_link );
	}
endif; //creativity_more_link


/*-----------------------------*
 * Cleanup Items
 *-----------------------------*/

 // remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
 function creativity_filter_ptags_on_images($content){
 	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
 }


/*-----------------------------*
 * Enqueue Styles and Scripts
 *-----------------------------*/

function creativity_scripts_and_styles()  {


  function creativity_styles() {
    // get the theme directory style.css and link to it in the header
    wp_enqueue_style( 'creativity-css', get_template_directory_uri() . '/style.css', array(),  filemtime( get_template_directory() . '/style.css' ), false);
  }

  function creativity_scripts() {
    $min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    $path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'src/js/source/' : 'assets/js/';

    // add fitvid
    wp_enqueue_script( 'creativity-fitvid', get_theme_file_uri( $path . 'jquery.fitvids.js' ), array( 'jquery' ), 'CREATIVITY_VERSION', true );

    // add theme scripts
    wp_enqueue_script( 'creativity',get_template_directory_uri() . $path . '/theme' . $min . '.js', array(), 'CREATIVITY_VERSION', true );
	  wp_enqueue_script( 'creativity-scripts', get_template_directory_uri() . $path . 'theme-scripts.js', array( 'jquery' ), null, true );

    wp_enqueue_script( 'creativity-skip-link-focus-fix', gget_template_directory_uri() . $path . 'skip-link-focus-fix' . $min . '.js', array( 'jquery' ), true );

    wp_enqueue_script( 'creativity-script', get_template_directory_uri() . $path . 'functions' . $min . '.js', $deps, true );
    wp_localize_script( 'creativity-script', 'creativityOptions',
      array(
        'screenReaderText' => array(
          'expand'   => esc_html__( 'expand child menu', 'creativity' ),
          'collapse' => esc_html__( 'collapse child menu', 'creativity' ),
          'icon'     => creativity_get_svg(
            array(
              'icon'     => 'angle-down',
              'fallback' => true,
            )
          ),
        ),
        'iconNavPrev'     => creativity_get_svg(
          array(
            'icon'     => 'angle-left',
            'fallback' => true,
          )
        ),
        'iconNavNext'     => creativity_get_svg(
          array(
            'icon'     => 'angle-right',
            'fallback' => true,
          )
        ),
        'iconTestimonialNavPrev'     => '<span>' . esc_html__( 'PREV', 'creativity' ) . '</span>',
        'iconTestimonialNavNext'     => '<span>' . esc_html__( 'NEXT', 'creativity' ) . '</span>',
        'rtl' => is_rtl(),
        'dropdownIcon'     => creativity_get_svg(
          array(
            'icon' => 'angle-down', 'fallback' => true
          )
        ),
      )
    );

    wp_enqueue_script( 'creativity-navigation', get_template_directory_uri() .  $path . 'navigation.js', array( 'jquery' ), true );
	  wp_localize_script( 'creativity-navigation', 'creativity_menu_title', array( creativity_get_svg( 'menu' ) . esc_html__( 'Menu', 'creativity' ) ) );
    wp_enqueue_script( 'creativity-script', get_template_directory_uri() . $path . 'script.js', array( 'jquery' ), true );
  }

  function creativity_conditional_scripts() {
    $deps[] = 'jquery';
    $enable_portfolio = get_theme_mod( 'creativity_portfolio_option', 'disabled' );
    if ( creativity_check_section( $enable_portfolio ) ) {
      $deps[] = 'jquery-masonry';
    }
    $enable_featured_content = get_theme_mod( 'creativity_featured_content_option', 'disabled' );
    //Slider Scripts
    $enable_slider      = creativity_check_section( get_theme_mod( 'creativity_slider_option', 'disabled' ) );
    $enable_testimonial_slider      = creativity_check_section( get_theme_mod( 'creativity_testimonial_option', 'disabled' ) ) && get_theme_mod( 'creativity_testimonial_slider', 1 );
    if ( $enable_slider || $enable_testimonial_slider ) {
      // Enqueue owl carousel css. Must load CSS before JS.
      wp_enqueue_style( 'owl-carousel-core', get_theme_file_uri( 'css/owl-carousel/owl.carousel.min.css' ), null, '2.3.4' );
      wp_enqueue_style( 'owl-carousel-default', get_theme_file_uri( 'css/owl-carousel/owl.theme.default.min.css' ), null, '2.3.4' );
      // Enqueue script
      wp_enqueue_script( 'owl-carousel', get_theme_file_uri( $path . 'owl.carousel' . $min . '.js' ), array( 'jquery' ), '2.3.4', true );
      $deps[] = 'owl-carousel';
    }
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
}

function creativity_get_font_face_styles() {
  return "
  @font-face { font-family: 'Avdira';
    src: url('" . get_theme_file_uri( 'fonts/avdira/Avdira_R.woff' ) . "') format('woff');
    src: url('" . get_theme_file_uri( 'fonts/avdira/Avdira_R.svg' ) . "') format('svg');
    src: url('" . get_theme_file_uri( 'fonts/avdira/Avdira_R.ttf' ) . "') format('ttf');
    src: url('" . get_theme_file_uri( 'fonts/avdira/Avdira_R.eot' ) . "') format('eot');
    font-weight: normal;
    font-style: normal;
  }
  @font-face { font-family: 'Enjoy Writing';
    font-style: normal;
    font-weight: 400;
    src: url('" . get_theme_file_uri( 'fonts/enjoy-writing/enjoywrting.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Glass Antiqua';
    font-weight: 400;
    font-style: normal;
    src: url('" . get_theme_file_uri( 'fonts/glass-antiqua/glassantiqua.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Hand TypeWriter';
    font-weight: 400;
    font-style: normal;
    src: url('" . get_theme_file_uri( 'fonts/hand-typewriter/handtypewriter.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Life Savers';
    font-style: normal;
    font-weight: 700;
    font-display: swap;
    src: url('fonts.gstatic.com/s/lifesavers/v13/ZXu_e1UftKKabUQMgxAal8HXOR5amcb4pA.woff2') format('woff2');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
  }
  @font-face { font-family: 'Life Savers';
    font-style: normal;
    font-weight: 700;
    font-display: swap;
    src: url('fonts.gstatic.com/s/lifesavers/v13/ZXu_e1UftKKabUQMgxAal8HXOR5UmcY.woff2') format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
  }
  @font-face { font-family: 'Pompiere';
    font-style: normal;
    font-weight: 400;
    src: url('fonts.cdnfonts.com/s/12351/Pompiere-Regular.woff') format('woff');
  }
  @font-face { font-family: 'Raleway';
    font-style: normal;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Thin.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-ExtraLight';
    font-style: normal;
    font-weight: 275;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-ExtraLight.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-Light';
    font-style: normal;
    font-weight: 300;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Light.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-Italic';
    font-style: italic;
    font-weight: 400;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Italic.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway';
    font-style: normal;
    font-weight: 500;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Medium.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway';
    font-style: normal;
    font-weight: 600;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-SemiBold.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-Bold';
    font-style: normal;
    font-weight: 700;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Bold.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-ExtraBold';
    font-style: normal;
    font-weight: 800;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-ExtraBold.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-Black';
    font-style: normal;
    font-weight: 900;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Black.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'raleway-blackitalic';
    font-style: italic;
    font-weight: 900;
    src: url('" . get_theme_file_uri( 'fonts/raleway/raleway-blackitalic.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raylig';
    font-style: normal;
    font-weight: 600;
    src: url('fonts.cdnfonts.com/s/70312/RayligSemibold-Wy9mE.woff') format('woff');
  }
  @font-face { font-family: 'TELETYPE 1945-1985';
    src: url('" . get_theme_file_uri( '/fonts/teletype_1945_1985/TELETYPE1945-1985.woff' ) . "') format('woff');
      font-weight: normal;
      font-style: normal;
    src: url('//db.onlinewebfonts.com/t/83dc401685732778308fc7cdfe8af34e.eot?#iefix') format('embedded-opentype');
    src: url('//db.onlinewebfonts.com/t/83dc401685732778308fc7cdfe8af34e.woff2') format('woff2');
    src: url('//db.onlinewebfonts.com/t/83dc401685732778308fc7cdfe8af34e.ttf') format('truetype');
    src: url('//db.onlinewebfonts.com/t/83dc401685732778308fc7cdfe8af34e.svg#TELETYPE 1945-1985') format('svg');
  }
  @font-face { font-family: 'Wanda';
    font-weight: 700;
    font-style: normal;
    src: url('" . get_theme_file_uri( 'fonts/fonts/wanda/wanda.woff' ) . "') format('woff');
  }
";}

function creativity_preload_webfonts() {
  ?>
  <link rel="preload" href="<?php echo esc_url( get_theme_file_uri( 'fonts/avdira/Avdira_R.woff' ) ); ?>" as="font" type="font/woff" crossorigin>
  <?php
}

function creativity_pingback_url() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo( 'pingback_url' )) );
	}
}
add_action( 'wp_head', 'creativity_pingback_url' );

/*-----------------------------*
 * Comment Layout
 *-----------------------------*/
function creativity_comments( $comment, $args, $depth ) {
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
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'creativity' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'creativity' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'creativity' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'creativity' ) ?></p>
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

// Related Posts Function (call using creativity_related_posts(); )
function creativity_related_posts() {
	echo '<ul id="creativity-related-posts">';
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	if($tags) {
		foreach( $tags as $tag ) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => 5, /* you can change this to show more */
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts( $args );
		if($related_posts) {
			foreach ( $related_posts as $post ) : setup_postdata( $post ); ?>
				<li class="related_post"><a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; }
		else { ?>
			<?php echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'creativity' ) . '</li>'; ?>
		<?php }
	}
	wp_reset_postdata();
	echo '</ul>';
} /* end creativity related posts function */

// Numeric Page Navi (built into the theme by default)
function creativity_page_navi() {
  global $wp_query;
  $bignum = 999999999;
  if ( $wp_query->max_num_pages <= 1 )
    return;
  echo '<nav class="pagination">';
  echo paginate_links( array(
    'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
    'format'       => '',
    'current'      => max( 1, get_query_var('paged') ),
    'total'        => $wp_query->max_num_pages,
    'prev_text'    => '&larr;',
    'next_text'    => '&rarr;',
    'type'         => 'list',
    'end_size'     => 3,
    'mid_size'     => 3
  ) );
  echo '</nav>';
} /* end page navi */
