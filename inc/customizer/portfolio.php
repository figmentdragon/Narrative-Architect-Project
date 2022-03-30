<?php
/**
 * Add Portfolio Settings in Customizer
 *
 * @package
 */

/**
 * Add portfolio options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function creativityarchitect_portfolio_options( $wp_customize ) {
	// Add note to Jetpack Portfolio Section
	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_jetpack_portfolio_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'creativityarchitect_Note_Control',
			'label'             => sprintf( esc_html__( 'For Portfolio Options for Theme, go %1$shere%2$s', 'creativityarchitect' ),
				 '<a href="javascript:wp.customize.section( \'creativityarchitect_portfolio\' ).focus();">',
				 '</a>'
			),
			'section'           => 'jetpack_portfolio',
			'type'              => 'description',
			'priority'          => 1,
		)
	);

	$wp_customize->add_section( 'creativityarchitect_portfolio', array(
			'panel'    => 'creativityarchitect_theme_options',
			'title'    => esc_html__( 'Portfolio', 'creativityarchitect' ),
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
            'name'              => 'creativityarchitect_portfolio_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'creativityarchitect_Note_Control',
          	'active_callback'   => 'creativityarchitect_is_ect_portfolio_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
            'label'             => sprintf( esc_html__( 'For Portfolio, install %1$sEssential Content Types%2$s Plugin with Portfolio Type Enabled', 'creativityarchitect' ),
                '<a target="_blank" href="' . esc_url( $install_url ) . '">',
                '</a>'

            ),
           'section'            => 'creativityarchitect_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_portfolio_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'active_callback'   => 'creativityarchitect_is_ect_portfolio_active',
			'choices'           => creativityarchitect_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_portfolio',
			'type'              => 'select',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_portfolio_cpt_note',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'creativityarchitect_Note_Control',
			'active_callback'   => 'creativityarchitect_is_portfolio_active',
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'creativityarchitect' ),
				 '<a href="javascript:wp.customize.control( \'jetpack_portfolio_title\' ).focus();">',
				 '</a>'
			),
			'section'           => 'creativityarchitect_portfolio',
			'type'              => 'description',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_portfolio_number',
			'default'           => 6,
			'sanitize_callback' => 'creativityarchitect_sanitize_number_range',
			'active_callback'   => 'creativityarchitect_is_portfolio_active',
			'label'             => esc_html__( 'Number of items to show', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_portfolio',
			'type'              => 'number',
			'input_attrs'       => array(
				'style'             => 'width: 100px;',
				'min'               => 0,
			),
		)
	);

	$number = get_theme_mod( 'creativityarchitect_portfolio_number', 6 );

	for ( $i = 1; $i <= $number ; $i++ ) {
		//for CPT
		creativityarchitect_register_option( $wp_customize, array(
				'name'              => 'creativityarchitect_portfolio_cpt_' . $i,
				'sanitize_callback' => 'creativityarchitect_sanitize_post',
				'active_callback'   => 'creativityarchitect_is_portfolio_active',
				'label'             => esc_html__( 'Portfolio', 'creativityarchitect' ) . ' ' . $i ,
				'section'           => 'creativityarchitect_portfolio',
				'type'              => 'select',
				'choices'           => creativityarchitect_generate_post_array( 'jetpack-portfolio' ),
			)
		);


	} // End for().

}
add_action( 'customize_register', 'creativityarchitect_portfolio_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'creativityarchitect_is_portfolio_active' ) ) :
	/**
	* Return true if portfolio is active
	*
	* @since 1.0
	*/
	function creativityarchitect_is_portfolio_active( $control ) {
		$enable = $control->manager->get_setting( 'creativityarchitect_portfolio_option' )->value();

		//return true only if previwed page on customizer matches the type of content option selected
		return ( creativityarchitect_is_ect_portfolio_active( $control ) && creativityarchitect_check_section( $enable ) );
	}
endif;


if ( ! function_exists( 'creativityarchitect_is_ect_portfolio_inactive' ) ) :
    /**
    *
    * @since 1.0
    */
    function creativityarchitect_is_ect_portfolio_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

if ( ! function_exists( 'creativityarchitect_is_ect_portfolio_active' ) ) :
    /**
    *
    * @since 1.0
    */
    function creativityarchitect_is_ect_portfolio_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;
