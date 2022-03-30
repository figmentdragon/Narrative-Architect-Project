<?php
/**
 * Services options
 *
 * @package
 */

/**
 * Add services content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function creativityarchitect_service_options( $wp_customize ) {
	// Add note to Jetpack Testimonial Section
    creativityarchitect_register_option( $wp_customize, array(
            'name'              => 'creativityarchitect_service_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'creativityarchitect_Note_Control',
            'label'             => sprintf( esc_html__( 'For all Services Options, go %1$shere%2$s', 'creativityarchitect' ),
                '<a href="javascript:wp.customize.section( \'creativityarchitect_service\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'services',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'creativityarchitect_service', array(
			'title' => esc_html__( 'Services', 'creativityarchitect' ),
			'panel' => 'creativityarchitect_theme_options',
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
            'name'              => 'creativityarchitect_service_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'creativityarchitect_Note_Control',
            'active_callback'   => 'creativityarchitect_is_ect_services_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Service Type Enabled', 'creativityarchitect' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'creativityarchitect_service',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	// Add color scheme setting and control.
	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_service_option',
			'default'           => 'disabled',
			'active_callback'   => 'creativityarchitect_is_ect_services_active',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'choices'           => creativityarchitect_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_service',
			'type'              => 'select',
		)
	);

    creativityarchitect_register_option( $wp_customize, array(
            'name'              => 'creativityarchitect_service_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'creativityarchitect_Note_Control',
            'active_callback'   => 'creativityarchitect_is_services_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'creativityarchitect' ),
                 '<a href="javascript:wp.customize.control( \'ect_service_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'creativityarchitect_service',
            'type'              => 'description',
        )
    );

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_service_number',
			'default'           => 4,
			'sanitize_callback' => 'creativityarchitect_sanitize_number_range',
			'active_callback'   => 'creativityarchitect_is_services_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Services is changed (Max no of Services is 20)', 'creativityarchitect' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of items', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_service',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	$number = get_theme_mod( 'creativityarchitect_service_number', 4 );

	//loop for services post content
	for ( $i = 1; $i <= $number ; $i++ ) {
		creativityarchitect_register_option( $wp_customize, array(
				'name'              => 'creativityarchitect_service_cpt_' . $i,
				'sanitize_callback' => 'creativityarchitect_sanitize_post',
				'active_callback'   => 'creativityarchitect_is_services_active',
				'label'             => esc_html__( 'Services', 'creativityarchitect' ) . ' ' . $i ,
				'section'           => 'creativityarchitect_service',
				'type'              => 'select',
                'choices'           => creativityarchitect_generate_post_array( 'ect-service' ),
			)
		);

	} // End for().
}
add_action( 'customize_register', 'creativityarchitect_service_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'creativityarchitect_is_services_active' ) ) :
	/**
	* Return true if services content is active
	*
	* @since 1.0
	*/
	function creativityarchitect_is_services_active( $control ) {
		$enable = $control->manager->get_setting( 'creativityarchitect_service_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( creativityarchitect_is_ect_services_active( $control ) && creativityarchitect_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'creativityarchitect_is_ect_services_inactive' ) ) :
    /**
    * Return true if service is active
    *
    * @since 1.0
    */
    function creativityarchitect_is_ect_services_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

if ( ! function_exists( 'creativityarchitect_is_ect_services_active' ) ) :
    /**
    * Return true if service is active
    *
    * @since 1.0
    */
    function creativityarchitect_is_ect_services_active( $control ) {
        return ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;
