<?php
/**
 * Hero Content Options
 *
 * @package creativityarchitect
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function creativityarchitect_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'creativityarchitect_hero_content_options', array(
			'title' => esc_html__( 'Hero Content', 'creativityarchitect' ),
			'panel' => 'creativityarchitect_theme_options',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_content_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'choices'           => creativityarchitect_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'select',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'creativityarchitect_sanitize_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'dropdown-pages',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_content_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Sub Headline', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'textarea',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_experience_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Experience Title', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'text',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_date_one',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Date 1', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'text',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_experience_one',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Experience 1', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'text',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_date_two',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Date 2', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'text',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_experience_two',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Experience 2', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'text',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_date_three',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Date 3', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'text',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_experience_three',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Experience 3', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'text',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_date_four',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Date 4', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'text',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_hero_experience_four',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'creativityarchitect_is_hero_content_active',
			'label'             => esc_html__( 'Experience 4', 'creativityarchitect' ),
			'section'           => 'creativityarchitect_hero_content_options',
			'type'              => 'text',
		)
	);

}
add_action( 'customize_register', 'creativityarchitect_hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'creativityarchitect_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since 1.0
	*/
	function creativityarchitect_is_hero_content_active( $control ) {
		$enable = $control->manager->get_setting( 'creativityarchitect_hero_content_visibility' )->value();

		return creativityarchitect_check_section( $enable );
	}
endif;
