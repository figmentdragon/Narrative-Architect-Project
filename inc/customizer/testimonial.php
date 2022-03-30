<?php
/**
 * Add Testimonial Settings in Customizer
 *
 * @package
*/

/**
 * Add testimonial options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function creativityarchitect_testimonial_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_jetpack_testimonial_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'creativityarchitect_Note_Control',
			'label'             => sprintf( esc_html__( 'For Testimonial Options for Theme, go %1$shere%2$s', 'creativityarchitect' ),
				'<a href="javascript:wp.customize.section( \'creativityarchitect_testimonials\' ).focus();">',
				 '</a>'
			),
		   'section'            => 'jetpack_testimonials',
			'type'              => 'description',
			'priority'          => 1,
		)
	);

	$wp_customize->add_section( 'creativityarchitect_testimonials', array(
			'panel'    => 'creativityarchitect_theme_options',
			'title'    => esc_html__( 'Testimonials', 'creativityarchitect' ),
		)
	);

	$action = 'install-plugin';
    $slug   = 'essential-content-types';

    $install_url = wp_nonce_url(
        add_query_arg(
            array(
                'action' => $action,
                'plugin' => $slug
            ),
            admin_url( 'update.php' )
        ),
        $action . '_' . $slug
    );

    creativityarchitect_register_option( $wp_customize, array(
            'name'              => 'creativityarchitect_testimonial_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'creativityarchitect_Note_Control',
            'active_callback'   => 'creativityarchitect_is_ect_testimonial_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with testimonial Type Enabled', 'creativityarchitect' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'creativityarchitect_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_testimonial_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'active_callback'   => 'creativityarchitect_is_ect_testimonial_active',
			'choices'           => creativityarchitect_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_testimonials',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_testimonial_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'creativityarchitect_Note_Control',
			'active_callback'   => 'creativityarchitect_is_testimonial_active',
			/* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'creativityarchitect' ),
				'<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
				'</a>'
			),
			'section'           => 'creativityarchitect_testimonials',
			'type'              => 'description',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_testimonial_number',
			'default'           => '3',
			'sanitize_callback' => 'creativityarchitect_sanitize_number_range',
			'active_callback'   => 'creativityarchitect_is_testimonial_active',
			'label'             => esc_html__( 'Number of items', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_testimonials',
			'type'              => 'number',
			'input_attrs'       => array(
				'style'             => 'width: 100px;',
				'min'               => 0,
			),
		)
	);

	$number = get_theme_mod( 'creativityarchitect_testimonial_number', 3 );

	for ( $i = 1; $i <= $number ; $i++ ) {

		//for CPT
		creativityarchitect_register_option( $wp_customize, array(
				'name'              => 'creativityarchitect_testimonial_cpt_' . $i,
				'sanitize_callback' => 'creativityarchitect_sanitize_post',
				'active_callback'   => 'creativityarchitect_is_testimonial_active',
				'label'             => esc_html__( 'Testimonial', 'creativityarchitect' ) . ' ' . $i ,
				'section'           => 'creativityarchitect_testimonials',
				'type'              => 'select',
				'choices'           => creativityarchitect_generate_post_array( 'jetpack-testimonial' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'creativityarchitect_testimonial_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'creativityarchitect_is_testimonial_active' ) ) :
	/**
	* Return true if testimonial is active
	*
	* @since 1.0
	*/
	function creativityarchitect_is_testimonial_active( $control ) {
		$enable = $control->manager->get_setting( 'creativityarchitect_testimonial_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( creativityarchitect_is_ect_testimonial_active( $control ) && creativityarchitect_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'creativityarchitect_is_ect_testimonial_inactive' ) ) :
    /**
    *
    * @since 1.0
    */
    function creativityarchitect_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;

if ( ! function_exists( 'creativityarchitect_is_ect_testimonial_active' ) ) :
    /**
    *
    * @since 1.0
    */
    function creativityarchitect_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_testimonial' ) );
    }
endif;
