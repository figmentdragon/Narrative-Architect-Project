<?php
/**
 * Featured Slider Options
 *
 * @package creativityarchitect
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function creativityarchitect_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'creativityarchitect_featured_slider', array(
			'panel' => 'creativityarchitect_theme_options',
			'title' => esc_html__( 'Featured Slider', 'creativityarchitect' ),
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'choices'           => creativityarchitect_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_featured_slider',
			'type'              => 'select',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_slider_number',
			'default'           => '4',
			'sanitize_callback' => 'creativityarchitect_sanitize_number_range',

			'active_callback'   => 'creativityarchitect_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'creativityarchitect' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
				'max'   => 20,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of Slides', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_featured_slider',
			'type'              => 'number',
		)
	);

	$slider_number = get_theme_mod( 'creativityarchitect_slider_number', 4 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {

		creativityarchitect_register_option( $wp_customize, array(
				'name'              => 'creativityarchitect_slider_logo_image_' . $i,
				'sanitize_callback' => 'creativityarchitect_sanitize_image',
				'custom_control'    => 'WP_Customize_Image_Control',
				'active_callback'   => 'creativityarchitect_is_slider_active',
				'label'             => esc_html__( 'Logo Image #', 'creativityarchitect' ) . $i,
				'section'           => 'creativityarchitect_featured_slider',
			)
		);

		// Page Sliders
		creativityarchitect_register_option( $wp_customize, array(
				'name'              => 'creativityarchitect_slider_page_' . $i,
				'sanitize_callback' => 'creativityarchitect_sanitize_post',
				'active_callback'   => 'creativityarchitect_is_slider_active',
				'label'             => esc_html__( 'Page', 'creativityarchitect' ) . ' # ' . $i,
				'section'           => 'creativityarchitect_featured_slider',
				'type'              => 'dropdown-pages',
			)
		);
	} // End for().
}
add_action( 'customize_register', 'creativityarchitect_slider_options' );

/** Active Callback Functions */

if ( ! function_exists( 'creativityarchitect_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since 1.0
	*/
	function creativityarchitect_is_slider_active( $control ) {
		$enable = $control->manager->get_setting( 'creativityarchitect_slider_option' )->value();

		//return true only if previwed page on customizer matches the type option selected
		return creativityarchitect_check_section( $enable );
	}
endif;
