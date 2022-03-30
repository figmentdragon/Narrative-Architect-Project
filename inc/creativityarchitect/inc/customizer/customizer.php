<?php
/**
 * Set up the theme customizer.
 *
 * @package creativity architect
 */

/**
 * Removes default customizer fields that we generally don't use.
 *
 * @param object $wp_customize The default Customizer settings.
 * @author Corey Collins
 */
function remove_default_customizer_sections( $wp_customize ) {

	// Remove sections.
	$wp_customize->remove_section( 'custom_css' );
	$wp_customize->remove_section( 'static_front_page' );
	$wp_customize->remove_section( 'background_image' );
	$wp_customize->remove_section( 'colors' );
}
add_action( 'customize_register', 'remove_default_customizer_sections', 15 );


function include_custom_controls() {
	require get_template_directory() . '/inc/customizer/panels.php';
	require get_template_directory() . '/inc/customizer/sections.php';
	require get_template_directory() . '/inc/customizer/settings.php';
	require get_template_directory() . '/inc/customizer/class-text-editor-custom-control.php';
}
add_action( 'customize_register', 'include_custom_controls', -999 );

function customize_scripts() {
	wp_enqueue_script( 'creativityarchitect-customize-livepreview', get_template_directory_uri() . '/inc/customizer/assets/scripts/livepreview.js', [ 'jquery', 'customize-preview' ], '1.0.0', true );
}
add_action( 'customize_preview_init', 'customize_scripts' );

function selective_refresh_support( $wp_customize ) {

	// The <div> classname to append edit icon too.
	$settings = [
		'blogname'          => '.site-title a',
		'blogdescription'   => '.site-description',
		'copyright_text' => '.site-info',
	];

	// Loop through, and add selector partials.
	foreach ( (array) $settings as $setting => $selector ) {
		$args = [ 'selector' => $selector ];
		$wp_customize->selective_refresh->add_partial( $setting, $args );
	}
}
add_action( 'customize_register', 'selective_refresh_support' );

function creativityarchitect_customize_register( $wp_customize ) {
  $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

  if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial(
      'blogname',
      array(
        'selector'        => '.site-title a',
        'render_callback' => 'creativityarchitect_customize_partial_blogname',
      )
    );
    $wp_customize->selective_refresh->add_partial(
      'blogdescription',
      array(
        'selector'        => '.site-description',
        'render_callback' => 'creativityarchitect_customize_partial_blogdescription',
      )
    );
  }
}
add_action( 'customize_register', 'creativityarchitect_customize_register' );

function creativityarchitect_customize_partial_blogname() {
	bloginfo( 'name' );
}

function creativityarchitect_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function live_preview_support( $wp_customize ) {

	// Settings to apply live preview to.
	$settings = [
		'blogname',
		'blogdescription',
		'header_textcolor',
		'background_image',
		'copyright_text',
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
add_action( 'customize_register', 'live_preview_support', 999 );

function creativityarchitect_customize_preview_js() {
	wp_enqueue_script( 'creativityarchitect-customizer', get_template_directory_uri() . '/inc/customizer/assets/scripts/customizer.js', array( 'customize-preview' ) );
}
add_action( 'customize_preview_init', 'creativityarchitect_customize_preview_js' );
