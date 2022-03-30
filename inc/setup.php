<?php
 /**
 * Theme setup. Functions
 *
 *  Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs before the init hook. The init hook is too late for some features, such as indicating support for post thumbnails.
 * @package creativity
 */

function creativity_setup() {
  add_action( 'after_setup_theme', 'creativity_content_width', 0 );
  add_action( 'after_setup_theme', 'creativity_custom_theme_features' );
  add_action( 'after_setup_theme', 'creativity_get_theme_widgets' );
  add_action( 'after_setup_theme', 'creativity_get_theme_customs' );
  add_action( 'after_setup_theme', 'create_post_type_creativity' );

  add_action( 'delete_category', 'creativity_category_transient_flusher' );
  add_action( 'get_header', 'enable_threaded_comments' ); // Enable Threaded Comments

  add_action( 'init', 'create_post_type_creativity' ); // Add our creativity Custom Post Type
  add_action( 'init', 'creativity_wp_pagination' ); // Add our creativity Pagination
  add_action( 'init', 'creativity_nav' ); // Add creativity Menu
  add_action( 'rest_api_init', 'creativity_cors_control' );
  add_action( 'save_post', 'creativity_category_transient_flusher' );

  add_action( 'widgets_init', 'creativity_widgets_init' );
  add_action( 'widgets_init', 'my_remove_recent_comments_style' ); // Remove inline Recent Comment Styles from wp_head()

  add_action( 'wp_enqueue_scripts', 'creativity_header_scripts' ); // Add Custom Scripts to wp_head
  add_action( 'wp_enqueue_scripts', 'creativity_remove_wp_block_library_css' );
  add_action( 'wp_enqueue_scripts', 'creativity_styles' ); // Add Theme Stylesheet

  add_action( 'wp_footer', 'creativity_include_svg_icons', 9999 );
  add_action( 'wp_head', 'creativity_add_og_tags' );
  add_action( 'wp_head', 'creativity_display_customizer_header_scripts', 999 );
  add_action( 'wp_head', 'creativity_pingback_header' );

  add_action( 'wp_print_scripts', 'creativity_conditional_scripts' ); // Add Conditional Page Scripts

  add_filter( 'avatar_defaults', 'creativity_gravatar' ); // Custom  Gravatar in Settings > Discussion
  add_filter( 'body_class', 'add_slug_to_body_class' ); // Add slug to body class (Starkers build)
  add_filter( 'body_class', 'creativity_body_classes' );
  add_filter( 'excerpt_length', 'creativity_excerpt_length' );
  add_filter( 'excerpt_more', 'creativity_excerpt_more' );
  add_filter( 'excerpt_more', 'creativity_view_article' ); // Add 'View Article' button instead of [...] for Excerpts


  add_filter( 'get_the_archive_title', 'creativity_remove_archive_title_prefix' );
  add_filter( 'get_the_excerpt', 'creativity_excerpt_more_for_manual_excerpts' );
  add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 ); // Remove width and height dynamic attributes to post images
  add_filter( 'init', 'creativity_disable_wpautop_for_gutenberg', 9 );
  add_filter('login_errors', 'generic_error_msgs');
  add_filter( 'nav_menu_item_title', 'creativity_dropdown_icon_to_menu_link', 10, 4 );
  add_filter( 'post_class', 'creativity_post_classes' );
  add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 ); // Remove width and height dynamic attributes to thumbnails
  add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 ); // Remove width and height dynamic attributes to post images

  add_filter( 'show_admin_bar', 'remove_admin_bar' ); // Remove Admin bar
  add_filter( 'style_loader_tag', 'creativity_style_remove' ); // Remove 'text/css' from enqueued stylesheet
  add_filter( 'the_category', 'remove_category_rel_from_category_list' ); // Remove invalid rel attribute
  add_filter( 'the_content', 'creativity_get_the_content', 20 );
  add_filter( 'the_content_more_link', 'creativity_content_more_link' );
  add_filter( 'the_content_more_link', 'creativity_move_more_link' );
  add_filter( 'the_excerpt', 'do_shortcode' ); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
  add_filter( 'the_excerpt', 'shortcode_unautop' ); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
  add_filter( 'the_generator', '__return_false' );
  add_filter( 'upload_mimes', 'creativity_custom_mime_types' );
  add_filter( 'walker_nav_menu_start_el', 'creativity_social_icons_menu', 10, 4 );
  add_filter( 'widget_text', 'do_shortcode' ); // Allow shortcodes in Dynamic Sidebar
  add_filter( 'widget_text', 'shortcode_unautop' ); // Remove <p>  tags in Dynamic Sidebars (better!)
  add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' ); // Remove surrounding <div> from WP Navigation
  add_filter( 'xmlrpc_enabled', '__return_false' );

  add_shortcode( 'creativity_copyright_year', 'creativity_copyright_year', 15 );
  add_shortcode( 'creativity_shortcode_demo', 'creativity_shortcode_demo' ); // You can place [creativity_shortcode_demo] in Pages, Posts now.
  add_shortcode( 'creativity_shortcode_demo_2', 'creativity_shortcode_demo_2' ); // Place [creativity_shortcode_demo_2] in Pages, Posts now.

  remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
  remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
  remove_action( 'wp_head', 'rel_canonical' );
  remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
  remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
  remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

  remove_filter( 'the_excerpt', 'wpautop' ); // Remove <p> tags from Excerpt altogether

}
add_action( 'after_setup_theme', 'creativity_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @author WebDevStudios
 */
function creativity_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'creativity_content_width', 1600 );
}

// Remove 'text/css' from our enqueued stylesheet
function creativity_style_remove( $tag ) {
    return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
}

// Custom Gravatar in Settings > Discussion
function creativity_gravatar ( $avatar_defaults ) {
    $myavatar                   = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = 'Custom Gravatar';
    return $avatar_defaults;
}

//Disable Print Wordpress Version for Security
remove_action('wp_head', 'wp_generator');
