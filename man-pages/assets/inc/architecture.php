<?php
/* Welcome to architecture :)
This is the core architecture file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

Developed by: Eddie Machado
URL: http://themble.com/architecture/

  - head cleanup (remove rsd, uri links, junk css, ect)
  - enqueueing scripts & styles
  - theme support functions
  - custom menu output & fallbacks
  - related post function
  - page-navi function
  - removing <p> from around images
  - customizing the post excerpt

*/

/*********************
WP_HEAD GOODNESS
The default wordpress head is
a mess. Let's clean it up by
removing all the junk we don't
need.
*********************/

function architecture_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
	// remove WP version from css
	add_filter( 'style_loader_src', 'architecture_remove_wp_ver_css_js', 9999 );
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'architecture_remove_wp_ver_css_js', 9999 );
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');

} /* end architecture head cleanup */

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
function architecture_rss_version() { return ''; }

// remove WP version from scripts
function architecture_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove injected CSS for recent comments widget
function architecture_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function architecture_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
	}
}

/**
 * Remove comments feed
 *
 * @return void
 */

function architecture_post_comments_feed_link() {
    return;
}

// remove injected CSS from gallery
function architecture_gallery_style($css) {
	return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}


/*********************
SCRIPTS & ENQUEUEING
*********************/
function architecture_style() {
// register main stylesheet
	wp_enqueue_style( 'architecture-stylesheet', get_stylesheet_directory_uri() . 'style.css', array(), '', 'all' );
}
// loading modernizr and jquery, and reply script
function architecture_scripts() {

  global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

  if (!is_admin()) {

		// modernizr (without media query polyfill)
		wp_register_script( 'architecture-modernizr', get_stylesheet_directory_uri() . 'assets/scripts/js/libs/modernizr.custom.min.js', array(), '2.5.3', false );


		// ie-only style sheet
		wp_register_style( 'architecture-ie-only', get_stylesheet_directory_uri() . '/assets/scripts/css/ie.css', array(), '' );

    // comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
		  wp_enqueue_script( 'comment-reply' );
    }

		//adding scripts file in the footer
		wp_register_script( 'architecture-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );

		// enqueue styles and scripts
		wp_enqueue_script( 'architecture-modernizr' );
		wp_enqueue_style( 'architecture-stylesheet' );
		wp_enqueue_style( 'architecture-ie-only' );

		$wp_styles->add_data( 'architecture-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

		/*
		I recommend using a plugin to call jQuery
		using the google cdn. That way it stays cached
		and your site will load faster.
		*/
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'architecture-js' );

	}
}

/**
 * Add async and defer attributes to enqueued scripts
 *
 * @param string $tag
 * @param string $handle
 * @param string $src
 * @return void
 */

function defer_scripts( $tag, $handle, $src ) {

	// The handles of the enqueued scripts we want to defer
	$defer_scripts = [
        'SCRIPT_ID'
    ];

    // Find scripts in array and defer
    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script type="text/javascript" src="' . $src . '" defer="defer"></script>' . "\n";
    }

    return $tag;
}

add_filter( 'script_loader_tag', 'defer_scripts', 10, 3 );


/**
 * Add custom scripts to head
 *
 * @return string
 */

function add_gtag_to_head() {

    // Check is staging environment
    if ( strpos( get_bloginfo( 'url' ), '.test' ) !== false ) return;

    // Google Analytics
    $tracking_code = 'UA-*********-1';

    ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $tracking_code; ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '<?php echo $tracking_code; ?>');
        </script>
    <?php
}

add_action( 'wp_head', 'add_gtag_to_head' );

/**
 * Remove unnecessary scripts
 *
 * @return void
 */

function deregister_scripts() {
    wp_deregister_script( 'wp-embed' );
}

add_action( 'wp_footer', 'deregister_scripts' );


/**
 * Remove unnecessary styles
 *
 * @return void
 */

function deregister_styles() {
    wp_dequeue_style( 'wp-block-library' );
}

add_action( 'wp_print_styles', 'deregister_styles', 100 );



/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function architecture_theme_support() {
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'align-wide' );


	add_theme_support( 'custom-header' );
	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );

	// default thumb size
	set_post_thumbnail_size(125, 125, true);

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
	    array(
	    'default-image' => '',    // background image default
	    'default-color' => '',    // background color default (dont add the #)
	    'wp-head-callback' => '_custom_background_cb',
	    'admin-head-callback' => '',
	    'admin-preview-callback' => ''
	    )
	);

	$logo_width                                   = 300;
	$logo_height                                  = 100;

	add_theme_support(
		'custom-logo',
		array(
			'height'                                  => $logo_height,
			'width'                                   => $logo_width,
			'flex-width'                              => true,
			'flex-height'                             => true,
			'unlink-homepage-logo'                    => true,
		)
	);

	// rss thingy
	add_theme_support( 'automatic-feed-links' );

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);

	// wp menus
	add_theme_support( 'menus' );

	// registering wp3+ menus
	register_nav_menus(
		array(
			'primary'	                                  =>	__( 'Primary Menu', 'architecture' ), // Register the Primary menu
			// Copy and paste the line above right here if you want to make another menu,
			// just change the 'primary' to another name
		)
	);

	/**
	 * Nav menu args
	 *
	 * @param array $args
	 * @return void
	 */

	function architecture_nav_menu_args( $args ) {
	    $args['container'] = false;
	    $args['container_class'] = false;
	    $args['menu_id'] = false;
	    $args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';

	    return $args;
	}

	// Enable support for HTML5 markup.
	add_theme_support(
		'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );

// Add support for experimental link color control.
	add_theme_support( 'experimental-link-color' );

} /* end architecture theme support */


/**
 * Button Shortcode
 *
 * @param array $atts
 * @param string $content
 * @return void
 */

function architecture_button_shortcode( $atts, $content = null ) {
    $atts['class'] = isset($atts['class']) ? $atts['class'] : 'btn';
    return '<a class="' . $atts['class'] . '" href="' . $atts['link'] . '">' . $content . '</a>';
}


/**
 * Get post thumbnail url
 *
 * @param string $size
 * @param boolean $post_id
 * @param boolean $icon
 * @return void
 */

function get_post_thumbnail_url( $size = 'full', $post_id = false, $icon = false ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $thumb_url_array = wp_get_attachment_image_src(
        get_post_thumbnail_id( $post_id ), $size, $icon
    );
    return $thumb_url_array[0];
}


/**
 * Add Front Page edit link to admin Pages menu
 */

function front_page_on_pages_menu() {
    global $submenu;
    if ( get_option( 'page_on_front' ) ) {
        $submenu['edit.php?post_type=page'][501] = array(
            __( 'Front Page', 'architecture' ),
            'manage_options',
            get_edit_post_link( get_option( 'page_on_front' ) )
        );
    }
}


/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function architecture_page_navi() {
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

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function architecture_filter_ptags_on_images($content){
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function architecture_excerpt_more($more) {
	global $post;
	// edit here if you like
	return '...  <a class="excerpt-read-more" href="'. get_permalink( $post->ID ) . '" title="'. __( 'Read ', 'architecture' ) . esc_attr( get_the_title( $post->ID ) ).'">'. __( 'Read more &raquo;', 'architecture' ) .'</a>';
}



?>
