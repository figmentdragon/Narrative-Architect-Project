<?php
/**
 * Header Media Options
 *
 * @package creativityarchitect
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function creativityarchitect_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'creativityarchitect' );

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_option',
			'default'           => 'entire-site',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'creativityarchitect' ),
				'exclude-home'           => esc_html__( 'Excluding Homepage', 'creativityarchitect' ),
				'exclude-home-page-post' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'creativityarchitect' ),
				'entire-site'            => esc_html__( 'Entire Site', 'creativityarchitect' ),
				'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'creativityarchitect' ),
				'pages-posts'            => esc_html__( 'Pages and Posts', 'creativityarchitect' ),
				'disable'                => esc_html__( 'Disabled', 'creativityarchitect' ),
			),
			'label'             => esc_html__( 'Enable on', 'creativityarchitect' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	/* Scroll Down option */
	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_scroll_down',
			'sanitize_callback' => 'creativityarchitect_sanitize_checkbox',
			'default'           => 1,
			'label'             => esc_html__( 'Scroll Down Button', 'creativityarchitect' ),
			'section'           => 'header_image',
			'custom_control'    => 'creativityarchitect_Toggle_Control',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_image_position_desktop',
			'default'           => 'center center',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'label'             => esc_html__( 'Image Position (Desktop View)', 'creativityarchitect' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'choices'           => array(
				'left top'      => esc_html__( 'Left Top', 'creativityarchitect' ),
				'left center'   => esc_html__( 'Left Center', 'creativityarchitect' ),
				'left bottom'   => esc_html__( 'Left Bottom', 'creativityarchitect' ),
				'right top'     => esc_html__( 'Right Top', 'creativityarchitect' ),
				'right center'  => esc_html__( 'Right Center', 'creativityarchitect' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'creativityarchitect' ),
				'center top'    => esc_html__( 'Center Top', 'creativityarchitect' ),
				'center center' => esc_html__( 'Center Center', 'creativityarchitect' ),
				'center bottom' => esc_html__( 'Center Bottom', 'creativityarchitect' ),
			),
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_image_position_mobile',
			'default'           => 'center center',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'label'             => esc_html__( 'Image Position (Mobile View)', 'creativityarchitect' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'choices'           => array(
				'left top'      => esc_html__( 'Left Top', 'creativityarchitect' ),
				'left center'   => esc_html__( 'Left Center', 'creativityarchitect' ),
				'left bottom'   => esc_html__( 'Left Bottom', 'creativityarchitect' ),
				'right top'     => esc_html__( 'Right Top', 'creativityarchitect' ),
				'right center'  => esc_html__( 'Right Center', 'creativityarchitect' ),
				'right bottom'  => esc_html__( 'Right Bottom', 'creativityarchitect' ),
				'center top'    => esc_html__( 'Center Top', 'creativityarchitect' ),
				'center center' => esc_html__( 'Center Center', 'creativityarchitect' ),
				'center bottom' => esc_html__( 'Center Bottom', 'creativityarchitect' ),
			),
		)
	);

	/*Overlay Option for Header Media*/
	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_image_opacity',
			'default'           => '0',
			'sanitize_callback' => 'creativityarchitect_sanitize_number_range',
			'label'             => esc_html__( 'Header Media Overlay', 'creativityarchitect' ),
			'section'           => 'header_image',
			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 60px;',
				'min'   => 0,
				'max'   => 100,
			),
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_text_alignment',
			'default'           => 'text-align-left',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'choices'           => array(
				'text-align-center' => esc_html__( 'Center', 'creativityarchitect' ),
				'text-align-right'  => esc_html__( 'Right', 'creativityarchitect' ),
				'text-align-left'   => esc_html__( 'Left', 'creativityarchitect' ),
			),
			'label'             => esc_html__( 'Text Alignment', 'creativityarchitect' ),
			'section'           => 'header_image',
			'type'              => 'radio',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_content_alignment',
			'default'           => 'content-align-right',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'choices'           => array(
				'content-align-center' => esc_html__( 'Center', 'creativityarchitect' ),
				'content-align-right'  => esc_html__( 'Right', 'creativityarchitect' ),
				'content-align-left'   => esc_html__( 'Left', 'creativityarchitect' ),
			),
			'label'             => esc_html__( 'Content Alignment', 'creativityarchitect' ),
			'section'           => 'header_image',
			'type'              => 'radio',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_logo',
			'sanitize_callback' => 'esc_url_raw',
			'custom_control'    => 'WP_Customize_Image_Control',
			'label'             => esc_html__( 'Header Media Logo', 'creativityarchitect' ),
			'section'           => 'header_image',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_logo_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'creativityarchitect_sanitize_select',
			'active_callback'   => 'creativityarchitect_is_header_media_logo_active',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'creativityarchitect' ),
				'entire-site'            => esc_html__( 'Entire Site', 'creativityarchitect' ) ),
			'label'             => esc_html__( 'Enable Header Media logo on', 'creativityarchitect' ),
			'section'           => 'header_image',
			'type'              => 'select',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Tagline', 'creativityarchitect' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Header Media Title', 'creativityarchitect' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_text',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Site Header Text', 'creativityarchitect' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_url',
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'Header Media Url', 'creativityarchitect' ),
			'section'           => 'header_image',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_media_url_text',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Header Media Url Text', 'creativityarchitect' ),
			'section'           => 'header_image',
		)
	);

	creativityarchitect_register_option( $wp_customize, array(
			'name'              => 'creativityarchitect_header_url_target',
			'sanitize_callback' => 'creativityarchitect_sanitize_checkbox',
			'label'             => esc_html__( 'Open Link in New Window/Tab', 'creativityarchitect' ),
			'section'           => 'header_image',
			'custom_control'    => 'creativityarchitect_Toggle_Control',
		)
	);
}
add_action( 'customize_register', 'creativityarchitect_header_media_options' );

/** Active Callback Functions */

if ( ! function_exists( 'creativityarchitect_is_header_media_logo_active' ) ) :
	/**
	* Return true if header logo is active
	*
	* @since 1.0
	*/
	function creativityarchitect_is_header_media_logo_active( $control ) {
		$logo = $control->manager->get_setting( 'creativityarchitect_header_media_logo' )->value();
		if ( '' != $logo ) {
			return true;
		} else {
			return false;
		}
	}
endif;
