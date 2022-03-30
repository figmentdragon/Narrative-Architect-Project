<?php

function creativity_custom_theme_features() {
  if ( ! isset( $content_width ) ) {
      $content_width = 1600;
  }

  add_editor_style( 'style-editor.css' );

  add_theme_support( 'align-wide' );
  add_theme_support( 'automatic-feed-links' );
  // Add Support for Custom Backgrounds - Uncomment below if you're going to use.
  add_theme_support('custom-background',
    array(
      'default-color' => 'FFF',
      'default-image' => get_template_directory_uri() . '/images/backgrounds/mobile/darkgreen.png'
  ));
  // Add Support for Custom Header - Uncomment below if you're going to use.
  add_theme_support('custom-header',
    array(
      'default-image'          => get_template_directory_uri() . '/images/background/text-titles/titles-white-bg.png',
      'header-text'            => false,
      'default-text-color'     => '000',
      'width'                  => 1000,
      'height'                 => 198,
      'random-default'         => false
    ));
  add_theme_support( 'custom-line-height' );
  $logo_width  = 400;
  $logo_height = 400;
  add_theme_support( 'custom-logo',
    array(
      'height'               => $logo_height,
      'width'                => $logo_width,
      'flex-width'           => true,
      'flex-height'          => true,
    )
  );
  add_theme_support( 'custom-spacing' );
  add_theme_support( 'custom-units' );
  add_theme_support( 'customize-selective-refresh-widgets' );
  add_theme_support( 'editor-font-sizes',
    array(
      array(
        'name' => esc_html__( 'Small', 'creativity' ),
        'size' => 13,
        'slug' => 'small',
      ),
      array(
        'name' => esc_html__( 'Regular', 'creativity' ),
        'size' => 17,
        'slug' => 'regular',
      ),
      array(
        'name' => esc_html__( 'Medium', 'creativity' ),
        'size' => 26,
        'slug' => 'medium',
      ),
      array(
        'name' => esc_html__( 'Large', 'creativity' ),
        'size' => 36,
        'slug' => 'large',
      ),
      array(
        'name' => esc_html__( 'Huge', 'creativity' ),
        'size' => 50,
        'slug' => 'huge',
      ),
    )
  );
  add_theme_support( 'editor-styles' );
  add_theme_support( 'html5',
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
  add_theme_support( 'menus' );
  add_theme_support( 'post-formats',
    array(
      'link',
      'aside',
      'gallery',
      'image',
      'quote',
      'status',
      'video',
      'audio',
      'chat',
    )
  );
  add_theme_support( 'post-thumbnails' );
    add_image_size( 'creativity-blogthumb', 1300, 9999, true ); //Custom Thumbnail Size call using the_post_thumbnail('creativity-blogthumb');
    add_image_size( 'creativity-logo', 400, 400, true );
    add_image_size( 'creativity-portfolio', 1920, 9999, true ); // Flexible Height
    add_image_size( 'creativity-slider', 1920, 1080, true ); // Ratio 16:9
  add_theme_support( 'responsive-embeds' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'widgets' );

  add_post_type_support( 'page', 'excerpt' );
  add_post_type_support( 'post', 'comments' );
  add_post_type_support( 'page', 'post-formats' );

  // Localisation Support.
  load_theme_textdomain( 'creativity', get_template_directory() . '/languages' );
}
