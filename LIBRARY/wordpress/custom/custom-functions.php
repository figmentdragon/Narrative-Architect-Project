<?php
/**
 * This is file for all of your custom functions for the project
 */

/**
 * Enables the Link Manager that existed in WordPress until version 3.5.
 */
// add_filter('pre_option_link_manager_enabled', '__return_true');


/**
 * Hide admin bar
 */

 add_filter( 'show_admin_bar', '__return_false' );


/**
 * Remove junk
 */
function THEMENAME_head_cleanup() {
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0 );
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
add_filter( 'style_loader_src', 'THEMENAME_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'THEMENAME_remove_wp_ver_css_js', 9999 );
add_filter( 'wp_title', 'rw_title', 10, 3 );
}

function rw_title( $title, $sep, $seplocation )
{
    global $page, $paged;

    // Don't affect in feeds.
    if ( is_feed() )
        return $title;

    // Add the blog name
    if ( 'right' == $seplocation )
        $title .= get_bloginfo( 'name' );
    else
        $title = get_bloginfo( 'name' ) . $title;

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title .= " {$sep} {$site_description}";

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
        $title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );

    return $title;
}


function THEMENAME_rss_version() { return ''; }

// remove WP version from scripts
function THEMENAME_remove_wp_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}


/**
 * Remove comments feed
 *
 * @return void
 */

function THEMENAME_post_comments_feed_link() {
    return;
}
// remove injected CSS for recent comments widget
function THEMENAME_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

// remove injected CSS from recent comments widget
function THEMENAME_remove_recent_comments_style() {
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
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

/**
 * Remove unnecessary scripts
 *
 * @return void
 */

function deregister_scripts() {
    wp_deregister_script( 'wp-embed' );
}

/**
 * Remove unnecessary styles
 *
 * @return void
 */
 function deregister_styles() {
     wp_dequeue_style( 'wp-block-library' );
 }

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


 function showads() {
  	return '<div id="adsense"><script type="text/javascript"><!–
  	google_ad_client = "pub-XXXXXXXXXXXXXX";
  	google_ad_slot = "4668915978";
  	google_ad_width = 468;
  	google_ad_height = 60;
  	//–>
  	</script>

  	<script type="text/javascript"
  	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
  	</script></div>';
  	}

  	add_shortcode('adsense', 'showads');
