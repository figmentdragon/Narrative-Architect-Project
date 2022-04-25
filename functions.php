<?php
 /**
 * Theme setup. Functions
 *
 *  Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs before the init hook. The init hook is too late for some features, such as indicating support for post thumbnails.
 * @package creativity
 */

 // global variables
 $themename = "creatvity";
 define('theme_name', $themename);

 global $content_width;
 if ( !isset( $content_width ) ) { $content_width = 1920; }

require get_template_directory() . '/inc/theme-support.php';
require get_template_directory() . '/inc/theme-settings.php';

require get_template_directory() . '/inc/custom/custom-comments.php';
require get_template_directory() . '/inc/custom/custom-header.php';
require get_template_directory() . '/inc/custom/custom-functions.php';
require get_template_directory() . '/inc/custom/image-sizes.php';

require get_template_directory() . '/inc/enqueues.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/hooks.php';
require get_template_directory() . '/inc/creativity-functions.php';
require get_template_directory() . '/inc/creativity-metabox.php';

require get_template_directory() . '/inc/acf.php';
require get_template_directory() . '/inc/backend-removals.php';
require get_template_directory() . '/inc/block-editor.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/admin-css.php';
require get_template_directory() . '/inc/compat.php';
require get_template_directory() . '/inc/deprecated.php';
require get_template_directory() . '/inc/editor.php';
require get_template_directory() . '/inc/pagination.php';
require get_template_directory() . '/inc/security.php';

require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

require get_template_directory() . '/assets/css/dynamic-style.php';

require get_template_directory() . '/inc/jetpack.php';
require get_template_directory() . '/woocommerce/woocommerce-functions.php';

function creativity_setup() {
	add_action( 'after_setup_theme', 'custom_theme_features' );
  add_action( 'init', 'creativity_pagination' ); // Add our creativity Pagination

  add_action( 'init', 'register_creativity_menu' ); // Add creativity Blank Menu
  add_action( 'widgets_init', 'creativity_widgets_init' );
  add_action( 'wp_enqueue_scripts', 'creativity_scripts' );
  add_action( 'wp_enqueue_scripts', 'creativity_styles_and_scripts' );
  add_action( 'wp_enqueue_scripts', 'creativity_styles' );
  remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'after_setup_theme', 'creativity_setup' );

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

// Register creativity Navigation
function register_creativity_menu() {
  register_nav_menus(
    array( // Using array to specify more menus if needed
      'header-menu'  => esc_html( 'Header Menu', 'creativity' ), // Main Navigation
      'extra-menu'   => esc_html( 'Extra Menu', 'creativity' ) // Extra Navigation if needed (duplicate as many as you need!)
    )
  );
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args( $args = '' ) {
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter( $var ) {
    return is_array( $var ) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list( $thelist ) {
    return str_replace( 'rel="category tag"', 'rel="tag"', $thelist );
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class( $classes ) {
    global $post;
    if ( is_home() ) {
        $key = array_search( 'blog', $classes, true );
        if ( $key > -1 ) {
            unset( $classes[$key] );
        }
    } elseif ( is_page() ) {
        $classes[] = sanitize_html_class( $post->post_name );
    } elseif ( is_singular() ) {
        $classes[] = sanitize_html_class( $post->post_name );
    }

    return $classes;
}

// Remove the width and height attributes from inserted images
function remove_width_attribute( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
    return $html;
}

// Create 20 Word Callback for Index page Excerpts, call using creativity_wp_excerpt('creativity_wp_index');
function creativity_wp_index( $length ) {
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using creativity_wp_excerpt('creativity_wp_custom_post');
function creativity_wp_custom_post( $length ) {
    return 40;
}

// Create the Custom Excerpts callback
function creativity_wp_excerpt( $length_callback = '', $more_callback = '' ) {
    global $post;
    if ( function_exists( $length_callback ) ) {
        add_filter( 'excerpt_length', $length_callback );
    }
    if ( function_exists( $more_callback ) ) {
        add_filter( 'excerpt_more', $more_callback );
    }
    $output = get_the_excerpt();
    $output = apply_filters( 'wptexturize', $output );
    $output = apply_filters( 'convert_chars', $output );
    $output = '<p>' . $output . '</p>';
    echo esc_html( $output );
}

// Custom View Article link to Post
function creativity_view_article( $more ) {
    global $post;
    return '... <a class="view-article" href="' . get_permalink( $post->ID ) . '">' . esc_html_e( 'View Article', 'creativity' ) . '</a>';
}

// Remove Admin bar
function remove_admin_bar() {
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function creativity_style_remove( $tag ) {
    return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', '', $html );
    return $html;
}

// Custom Gravatar in Settings > Discussion
function creativity_gravatar ( $avatar_defaults ) {
    $myavatar                   = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = 'Custom Gravatar';
    return $avatar_defaults;
}
