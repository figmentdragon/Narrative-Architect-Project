<?php

function creativity_remove_wp_block_library_css() {
  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-block-library-theme' );
  wp_dequeue_style( 'wc-blocks-style' );
}

// Threaded Comments
function enable_threaded_comments() {
  if ( ! is_admin() ) {
    if ( is_singular() AND comments_open() AND ( get_option( 'thread_comments' ) == 1 ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
}

// Load HTML5 Blank scripts (header.php)
function creativity_header_scripts() {
  if ( $GLOBALS['pagenow'] != 'wp-login.php' && ! is_admin() ) {
    if ( HTML5_DEBUG ) {
      wp_deregister_script( 'jquery' );
      wp_register_script( 'jquery', get_template_directory_uri() . '/js/lib/jquery.js', array(), '1.11.1' );
      wp_register_script( 'conditionizr', get_template_directory_uri() . '/assets/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0' );
      wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/js/lib/modernizr.js', array(), '2.6.2' );
      wp_register_script(
        'creativity-scripts',
        get_template_directory_uri() . '/js/scripts.js',
          array(
            'conditionizr',
            'modernizr',
            'jquery'
          ),
          '1.0.0' );

          wp_enqueue_script( 'creativity-scripts' );
        } else {
          wp_register_script( 'creativity-scripts-min', get_template_directory_uri() . '/assets/js/scripts.min.js', array(), '1.0.0' );
          wp_enqueue_script( 'creativity-scripts-min' );
        }
      }
    }

function creativity_scripts() {
  wp_enqueue_script( 'creativity-navigation', get_template_directory_uri() . '/assets/js/lib/navigation.js', array('jquery') );
	wp_enqueue_script( 'creativity-script', get_template_directory_uri() . '/src/js/functions.js', array('jquery') );

}

// Load HTML5 Blank conditional scripts
function creativity_conditional_scripts() {
  if ( is_page( 'pagenamehere' ) ) {
    // Conditional script(s)
    wp_register_script( 'scriptname', get_template_directory_uri() . '/js/scriptname.js', array( 'jquery' ), '1.0.0' );
    wp_enqueue_script( 'scriptname' );
    }
}

// Load HTML5 Blank styles
function creativity_styles() {
  if ( HTML5_DEBUG ) {
    wp_register_style( 'normalize', get_template_directory_uri() . '/assets/css/lib/normalize.css', array(), '7.0.0' );
    wp_register_style( 'style', get_template_directory_uri() . '/style.css', array( 'normalize' ), '1.0' );
    wp_enqueue_style( 'style' );
  } else {
    wp_enqueue_style( 'normalize' );
    wp_register_style( 'style', get_template_directory_uri() . '/style.css', array(), '1.0' );
    wp_enqueue_style( 'style' );
    wp_enqueue_style( 'custom-css', get_template_directory_uri() . '/assets/css/custom.css' );
    wp_enqueue_style( 'doodle', get_template_directory_uri() . '/node_modules/doodle.css/doodle.css', );
  }
}
