<?php

/* ____________________________________________ THEME SUPPORT */
function architecture_theme_support() {
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-header' );
	// wp thumbnails (sizes handled in functions.php)
	add_theme_support( 'post-thumbnails' );
	// default thumb size
	set_post_thumbnail_size( 1200, 9999 );
	// Add custom image size used in Cover Template.
	add_image_size( 'architecture-fullscreen', 1980, 9999 );
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
	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

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
	// Adds support for Jetpacks Social Menu
	add_theme_support('jetpack-social-menu');
	// Add support for Jetpack's Infinite Scroll
		add_theme_support('infinite-scroll', array('container' => 'content', 'footer' => 'page',	));
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

  	function architecture_register_nav_menus() {
		register_nav_menus([
        	'header' => 'Header',
        	'footer' => 'Footer',
		]);
    }

	function architecture_custom_new_menu() {
	  	register_nav_menus(
		  	array(
			  	'architecture-menu' => __( 'Site Menu' ),
			  	'social-menu' => __( 'Extra Menu' )
			)
		);
	}


	/**
	 * Nav menu args
	 *
	 * @param array $args
	 * @return void
	 */

	function architecture_nav_menu_args( $args ) {
	    $args['container'] = true;
	    $args['container_class'] = true;
	    $args['menu_id'] = true;
	    $args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';

	    return $args;
	}

	// Enable support for HTML5 markup.
	add_theme_support(
		'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

	if ( is_customize_preview() ) {
		require get_template_directory() . '/assets/inc/starter-content.php';
		add_theme_support( 'starter-content',
				architecture_get_starter_content() );
			// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
			// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );
			// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );
			// Add support for experimental cover block spacing.
		add_theme_support( 'custom-spacing' );
			// Add support for custom units.
			// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
		add_theme_support( 'custom-units' );
	}
}
 /* end architecture theme support */


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
/*
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
*/
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

/**
* Checks for single template by category
* Check by category slug and ID
*/
foreach((array)get_the_category() as $cat) :

	if(file_exists(SINGLE_PATH . '/docs/theme/site-templates/single-cat-' . $cat->slug . '.php'))
		return SINGLE_PATH . '/docs/theme/theme-template/single-cat-' . $cat->slug . '.php';

		elseif(file_exists(SINGLE_PATH . '/single-cat-' . $cat->term_id . '.php'))
			return SINGLE_PATH . '/single-cat-' . $cat->term_id . '.php';

			/**
		* Define a constant path to our single template folder
		*/
		define(SINGLE_PATH, TEMPLATEPATH . 'docs/theme/site-templates/single');

		/**
		* Filter the single_template with our custom function
		*/
		add_filter('single_template', 'my_single_author_template');

		/**
		* Single template function which will choose our template
		*/
		function my_single_author_template($single) {
		global $wp_query, $post;

		/**
		* Checks for single template by author
		* Check by user nicename and ID
		*/
		$curauth = get_userdata($wp_query->post->post_author);

		if(file_exists(SINGLE_PATH . '/single-author-' . $curauth->user_nicename . '.php'))
		return SINGLE_PATH . '/single-author-' . $curauth->user_nicename . '.php';

		elseif(file_exists(SINGLE_PATH . '/single-author-' . $curauth->ID . '.php'))
			return SINGLE_PATH . '/single-author-' . $curauth->ID . '.php';

		}

endforeach;


?>
