<?php
/**
 * creativity_ Theme Customizer
 *
 * @package creativity_
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function creativity_customize_register( $wp_customize ) {
	// Add postMessage support for site title and description so we can preview changes instantly.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

  // Change default background section.
	$wp_customize->get_control( 'background_color' )->section   = 'background_image';
	$wp_customize->get_section( 'background_image' )->title     = esc_html__( 'Page Background', 'creativity' );

	// Add selective refresh for site title and description.
	if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'blogname',
      array(
        'selector'        => '.site-title a',
        'render_callback' => 'creativity_customize_partial_blogname',
      )
    );
    $wp_customize->selective_refresh->add_partial( 'blogdescription',
      array(
        'selector'        => '.site-description',
        'render_callback' => 'creativity_customize_partial_blogdescription',
      )
    );
    /*Main custom panel for theme settings*/
		$wp_customize->add_panel( 'creativity_panel',
			array(
				'priority'   => 10,
				'capability' => 'edit_theme_options',
				'title'      => __( 'Theme Options', 'creativity' ),
			)
		);

		/*Header Options*/
		$wp_customize->add_section( 'header_section',
			array(
				'title' => __( 'Header Options', 'creativity' ),
				'panel' => 'creativity_panel',
			)
		);

		/*Search Icon*/
		$wp_customize->add_setting( 'creativity-search-icon',
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => 1,
				'sanitize_callback' => 'creativity_sanitize_checkbox',
			)
		);

		$wp_customize->add_control( 'creativity-search-icon',
			array(
				'label'       => __( 'Show Search Icon', 'creativity' ),
				'description' => __( 'Checked to show the search icon.', 'creativity' ),
				'section'     => 'header_section',
				'type'        => 'checkbox',
			)
		);
    /*Footer Options*/
		$wp_customize->add_section( 'copyright_option',
			array(
				'title' => __( 'Copyright Options', 'creativity' ),
				'panel' => 'creativity_panel',
			)
		);

		/*Copyright Text*/
		$wp_customize->add_setting( 'creativity-copyright-text',
			array(
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
				'default'           => __( '© 2022', 'creativity' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control( 'creativity-copyright-text',
			array(
				'label'       => __( 'Copyright Text', 'creativity' ),
				'description' => __( 'Enter your copyright text here.', 'creativity' ),
				'section'     => 'copyright_option',
				'type'        => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'creativity_customize_register' );

/**
 * Include other customizer files.
 *
 * @author WebDevStudios
 */
function creativity_include_custom_controls() {
	require get_template_directory() . '/inc/customizer/panels.php';
	require get_template_directory() . '/inc/customizer/sections.php';
	require get_template_directory() . '/inc/customizer/settings.php';
	require get_template_directory() . '/inc/customizer/class-text-editor-custom-control.php';
}
add_action( 'customize_register', 'creativity_include_custom_controls', -999 );


/**
 * Render the site title for the selective refresh partial.
 */
function creativity_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function creativity_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Add support for the fancy new edit icons.
 *
 * @param object $wp_customize Instance of WP_Customize_Class.
 *
 * @author WebDevStudios
 * @link https://make.wordpress.org/core/2016/02/16/selective-refresh-in-the-customizer/.
 */
function creativity_selective_refresh_support( $wp_customize ) {
	// The <div> classname to append edit icon too.
	$settings = [
		'blogname'          => '.site-title a',
		'blogdescription'   => '.site-description',
		'creativity_copyright_text' => '.site-info',
	];
	// Loop through, and add selector partials.
	foreach ( (array) $settings as $setting => $selector ) {
		$args = [ 'selector' => $selector ];
		$wp_customize->selective_refresh->add_partial( $setting, $args );
	}
}
add_action( 'customize_register', 'creativity_selective_refresh_support' );
/**
 * Add live preview support via postMessage.
 *
 * Note: You will need to hook this up via livepreview.js
 *
 * @author WebDevStudios
 *
 * @param object $wp_customize Instance of WP_Customize_Class.
 * @link https://codex.wordpress.org/Theme_Customization_API#Part_3:_Configure_Live_Preview_.28Optional.29.
 */
function creativity_live_preview_support( $wp_customize ) {

	// Settings to apply live preview to.
	$settings = [
		'blogname',
		'blogdescription',
		'header_textcolor',
		'background_image',
		'creativity_copyright_text',
	];

	// Loop through and add the live preview to each setting.
	foreach ( (array) $settings as $setting_name ) {

		// Try to get the customizer setting.
		$setting = $wp_customize->get_setting( $setting_name );

		// Skip if it is not an object to avoid notices.
		if ( ! is_object( $setting ) ) {
			continue;
		}

		// Set the transport to avoid page refresh.
		$setting->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'creativity_live_preview_support', 999 );

/**
 * Enqueue customizer related scripts.
 *
 * @author WebDevStudios
 */
/**
 * Embed JS for Customizer Controls.
 */
function creativity_customizer_controls_js() {
	wp_enqueue_script( 'creativity-customizer-controls', get_template_directory_uri() . '/src/js/customizer/customizer-controls.js', array( 'customize-preview' ), 'creativity_VERSION', true );
}
add_action( 'customize_controls_enqueue_scripts', 'creativity_customizer_controls_js' );

 /**
  * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
  */
function creativity_customize_scripts() {
	wp_enqueue_script( 'creativity-customize-livepreview', get_template_directory_uri() . '/src/js/customizer/livepreview.js', [ 'jquery', 'customize-preview' ], '1.0.0', true );
}
add_action( 'customize_preview_init', 'creativity_customize_scripts' );

/**
 * Embed CSS styles Customizer Controls.
 */
function creativity_customizer_controls_css() {
	wp_enqueue_style( 'creativity-customizer-controls', get_template_directory_uri() . '/src/css/customizer-controls.css', array(), '20180609' );
}
add_action( 'customize_controls_print_styles', 'creativity_customizer_controls_css' );

/**
 * Display the customizer header scripts.
 *
 * @author Greg Rickaby
 *
 * @return string Header scripts.
 */
function creativity_display_customizer_header_scripts() {
	// Check for header scripts.
	$scripts = get_theme_mod( 'creativity_header_scripts' );

	// None? Bail...
	if ( ! $scripts ) {
		return false;
	}

	// Otherwise, echo the scripts!
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
	echo creativity_get_the_content( $scripts );
}


/**
 * Display the customizer footer scripts.
 *
 * @author Greg Rickaby
 *
 * @return string Footer scripts.
 */
function creativity_display_customizer_footer_scripts() {
	// Check for footer scripts.
	$scripts = get_theme_mod( 'creativity_footer_scripts' );

	// None? Bail...
	if ( ! $scripts ) {
		return false;
	}

	// Otherwise, echo the scripts!
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
	echo creativity_get_the_content( $scripts );
}

add_action( 'wp_footer', 'creativity_display_customizer_footer_scripts', 999 );
