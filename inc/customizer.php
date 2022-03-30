<?php
/**
 * creativity architect Theme Customizer
 *
 * @package creativity_architect
 */

 if ( ! defined( 'ABSPATH' ) ) {
 	exit; // Exit if accessed directly.
 }

add_action( 'customize_register', 'creativityarchitect_set_customizer_helpers', 1 );
add_action( 'customize_register', 'creativityarchitect_customize_register' );
add_action( 'customize_preview_init', 'creativityarchitect_customize_preview_js' );

/**
 * Set up helpers early so they're always available.
 * Other modules might need access to them at some point.
 *
 */
 function creativityarchitect_set_customizer_helpers( $wp_customize ) {
 	// Load helpers
 	get_template_part( 'inc/customizer/customizer', 'helpers' );


	/**
	 * Add our base options to the Customizer.
   * Add postMessage support for site title and description for the Theme Customizer.
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function creativityarchitect_customize_register( $wp_customize ) {
		// Get our default values
		$defaults = creativityarchitect_get_defaults();

		if ( $wp_customize->get_control( 'blogdescription' ) ) {
			$wp_customize->get_control('blogdescription')->priority = 3;
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		}

		if ( $wp_customize->get_control( 'blogname' ) ) {
			$wp_customize->get_control('blogname')->priority = 1;
			$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		}

		if ( $wp_customize->get_control( 'custom_logo' ) ) {
			$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';
		}

    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		// Add control types so controls can be built using JS
		if ( method_exists( $wp_customize, 'register_control_type' ) ) {
			$wp_customize->register_control_type( 'creativityarchitect_Customize_Misc_Control' );
			$wp_customize->register_control_type( 'creativityarchitect_Range_Slider_Control' );
		}

		// Add upsell section type
		if ( method_exists( $wp_customize, 'register_section_type' ) ) {
			$wp_customize->register_section_type( 'creativityarchitect_Upsell_Section' );
		}

    // Add Layout section
		$wp_customize->add_section( 'creativityarchitect_layout_container',
			array(
				'title' => __( 'Container', 'creativityarchitect' ),
				'priority' => 10,
				'panel' => 'creativityarchitect_layout_panel'
			)
		);
    $wp_customize->add_section( 'creativityarchitect_layout_effects',
      array(
        'title' => __( 'creativityarchitect Effects', 'creativityarchitect' ),
        'priority' => 24,
			)
		);
    $wp_customize->add_section( 'creativityarchitect_top_bar',
      array(
        'title' => __( 'Top Bar', 'creativityarchitect' ),
        'priority' => 15,
        'panel' => 'creativityarchitect_layout_panel',
      )
    );
    $wp_customize->add_section( 'creativityarchitect_layout_header',
      array(
        'title' => __( 'Header', 'creativityarchitect' ),
        'priority' => 20,
        'panel' => 'creativityarchitect_layout_panel'
      )
    );
    $wp_customize->add_section( 'creativityarchitect_layout_navigation',
      array(
        'title' => __( 'Primary Navigation', 'creativityarchitect' ),
        'priority' => 30,
        'panel' => 'creativityarchitect_layout_panel'
      )
    );
    $wp_customize->add_section( 'creativityarchitect_layout_sidecontent',
      array(
        'title' => __( 'Fixed Side Content', 'creativityarchitect' ),
        'priority' => 39,
        'panel' => 'creativityarchitect_layout_panel'
      )
    );
    $wp_customize->add_section( 'creativityarchitect_layout_sidebars',
      array(
        'title' => __( 'Sidebars', 'creativityarchitect' ),
        'priority' => 40,
        'panel' => 'creativityarchitect_layout_panel'
      )
    );
    $wp_customize->add_section( 'creativityarchitect_layout_footer',
      array(
        'title' => __( 'Footer', 'creativityarchitect' ),
        'priority' => 50,
        'panel' => 'creativityarchitect_layout_panel'
      )
    );
    $wp_customize->add_section( 'creativityarchitect_blog_section',
      array(
        'title' => __( 'Blog', 'creativityarchitect' ),
        'priority' => 55,
        'panel' => 'creativityarchitect_layout_panel'
      )
    );
    $wp_customize->add_section( 'creativityarchitect_general_section',
      array(
        'title' => __( 'General', 'creativityarchitect' ),
        'priority' => 99
      )
    );
    $wp_customize->add_section( 'creativityarchitect_socials_section',
      array(
        'title' => __( 'Socials', 'creativityarchitect' ),
        'priority' => 99
      )
    );

		// Add selective refresh to site title and description
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'blogname', array(
				'selector' => '.main-title a',
				'render_callback' => 'creativityarchitect_customize_partial_blogname',
			) );

			$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
				'selector' => '.site-description',
				'render_callback' => 'creativityarchitect_customize_partial_blogdescription',
			) );
		}

		// Remove title
		$wp_customize->add_setting(
			'creativityarchitect_settings[hide_title]',
			array(
				'default' => $defaults['hide_title'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[hide_title]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Hide site title', 'creativityarchitect' ),
				'section' => 'title_tagline',
				'priority' => 2
			)
		);

		// Remove tagline
		$wp_customize->add_setting(
			'creativityarchitect_settings[hide_tagline]',
			array(
				'default' => $defaults['hide_tagline'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_checkbox'
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[hide_tagline]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Hide site tagline', 'creativityarchitect' ),
				'section' => 'title_tagline',
				'priority' => 4
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[retina_logo]',
			array(
				'type' => 'option',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'creativityarchitect_settings[retina_logo]',
				array(
					'label' => __( 'Retina Logo', 'creativityarchitect' ),
					'section' => 'title_tagline',
					'settings' => 'creativityarchitect_settings[retina_logo]',
					'active_callback' => 'creativityarchitect_has_custom_logo_callback'
				)
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[side_inside_color]', array(
				'default' => $defaults['side_inside_color'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'creativityarchitect_settings[side_inside_color]',
				array(
					'label' => __( 'Inside padding', 'creativityarchitect' ),
					'section' => 'colors',
					'settings' => 'creativityarchitect_settings[side_inside_color]',
					'active_callback' => 'creativityarchitect_is_side_padding_active',
				)
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[text_color]', array(
				'default' => $defaults['text_color'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'creativityarchitect_settings[text_color]',
				array(
					'label' => __( 'Text Color', 'creativityarchitect' ),
					'section' => 'colors',
					'settings' => 'creativityarchitect_settings[text_color]'
				)
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[link_color]', array(
				'default' => $defaults['link_color'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'creativityarchitect_settings[link_color]',
				array(
					'label' => __( 'Link Color', 'creativityarchitect' ),
					'section' => 'colors',
					'settings' => 'creativityarchitect_settings[link_color]'
				)
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[link_color_hover]', array(
				'default' => $defaults['link_color_hover'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_hex_color',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'creativityarchitect_settings[link_color_hover]',
				array(
					'label' => __( 'Link Color Hover', 'creativityarchitect' ),
					'section' => 'colors',
					'settings' => 'creativityarchitect_settings[link_color_hover]'
				)
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[link_color_visited]', array(
				'default' => $defaults['link_color_visited'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_hex_color',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'creativityarchitect_settings[link_color_visited]',
				array(
					'label' => __( 'Link Color Visited', 'creativityarchitect' ),
					'section' => 'colors',
					'settings' => 'creativityarchitect_settings[link_color_visited]'
				)
			)
		);

		if ( ! function_exists( 'creativityarchitect_colors_customize_register' ) && ! defined( 'creativityarchitect_PREMIUM_VERSION' ) ) {
			$wp_customize->add_control(
				new creativityarchitect_Customize_Misc_Control(
					$wp_customize,
					'colors_get_addon_desc',
					array(
						'section' => 'colors',
						'type' => 'addon',
						'label' => __( 'More info', 'creativityarchitect' ),
						'description' => __( 'More colors are available in creativityarchitect premium version. Visit wpkoi.com for more info.', 'creativityarchitect' ),
						'url' => esc_url( creativityarchitect_theme_uri_link() ),
						'priority' => 30,
						'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname'
					)
				)
			);
		}

		if ( class_exists( 'WP_Customize_Panel' ) ) {
			if ( ! $wp_customize->get_panel( 'creativityarchitect_layout_panel' ) ) {
				$wp_customize->add_panel( 'creativityarchitect_layout_panel', array(
					'priority' => 25,
					'title' => __( 'Layout', 'creativityarchitect' ),
				) );
			}
		}


		// Container width
		$wp_customize->add_setting(
			'creativityarchitect_settings[container_width]',
			array(
				'default' => $defaults['container_width'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_integer',
				'transport' => 'postMessage'
			)
		);

		$wp_customize->add_control(
			new creativityarchitect_Range_Slider_Control(
				$wp_customize,
				'creativityarchitect_settings[container_width]',
				array(
					'type' => 'creativityarchitect-range-slider',
					'label' => __( 'Container Width', 'creativityarchitect' ),
					'section' => 'creativityarchitect_layout_container',
					'settings' => array(
						'desktop' => 'creativityarchitect_settings[container_width]',
					),
					'choices' => array(
						'desktop' => array(
							'min' => 700,
							'max' => 2000,
							'step' => 5,
							'edit' => true,
							'unit' => 'px',
						),
					),
					'priority' => 0,
				)
			)
		);


		// Add Top Bar width
		$wp_customize->add_setting(
			'creativityarchitect_settings[top_bar_width]',
			array(
				'default' => $defaults['top_bar_width'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add Top Bar width control
		$wp_customize->add_control(
			'creativityarchitect_settings[top_bar_width]',
			array(
				'type' => 'select',
				'label' => __( 'Top Bar Width', 'creativityarchitect' ),
				'section' => 'creativityarchitect_top_bar',
				'choices' => array(
					'full' => __( 'Full', 'creativityarchitect' ),
					'contained' => __( 'Contained', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[top_bar_width]',
				'priority' => 5,
				'active_callback' => 'creativityarchitect_is_top_bar_active',
			)
		);

		// Add Top Bar inner width
		$wp_customize->add_setting(
			'creativityarchitect_settings[top_bar_inner_width]',
			array(
				'default' => $defaults['top_bar_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add Top Bar width control
		$wp_customize->add_control(
			'creativityarchitect_settings[top_bar_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Top Bar Inner Width', 'creativityarchitect' ),
				'section' => 'creativityarchitect_top_bar',
				'choices' => array(
					'full' => __( 'Full', 'creativityarchitect' ),
					'contained' => __( 'Contained', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[top_bar_inner_width]',
				'priority' => 10,
				'active_callback' => 'creativityarchitect_is_top_bar_active',
			)
		);

		// Add top bar alignment
		$wp_customize->add_setting(
			'creativityarchitect_settings[top_bar_alignment]',
			array(
				'default' => $defaults['top_bar_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'creativityarchitect_settings[top_bar_alignment]',
			array(
				'type' => 'select',
				'label' => __( 'Top Bar Alignment', 'creativityarchitect' ),
				'section' => 'creativityarchitect_top_bar',
				'choices' => array(
					'left' => __( 'Left', 'creativityarchitect' ),
					'center' => __( 'Center', 'creativityarchitect' ),
					'right' => __( 'Right', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[top_bar_alignment]',
				'priority' => 15,
				'active_callback' => 'creativityarchitect_is_top_bar_active',
			)
		);

		// Add Header Layout setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[header_layout_setting]',
			array(
				'default' => $defaults['header_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add Header Layout control
		$wp_customize->add_control(
			'creativityarchitect_settings[header_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Header Width', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_header',
				'choices' => array(
					'fluid-header' => __( 'Full', 'creativityarchitect' ),
					'contained-header' => __( 'Contained', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[header_layout_setting]',
				'priority' => 5
			)
		);

		// Add Inside Header Layout setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[header_inner_width]',
			array(
				'default' => $defaults['header_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add Header Layout control
		$wp_customize->add_control(
			'creativityarchitect_settings[header_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Header Width', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_header',
				'choices' => array(
					'contained' => __( 'Contained', 'creativityarchitect' ),
					'full-width' => __( 'Full', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[header_inner_width]',
				'priority' => 6
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[header_alignment_setting]',
			array(
				'default' => $defaults['header_alignment_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'creativityarchitect_settings[header_alignment_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Header Alignment', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_header',
				'choices' => array(
					'left' => __( 'Left', 'creativityarchitect' ),
					'center' => __( 'Center', 'creativityarchitect' ),
					'right' => __( 'Right', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[header_alignment_setting]',
				'priority' => 10
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[nav_layout_setting]',
			array(
				'default' => $defaults['nav_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'creativityarchitect_settings[nav_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Width', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_navigation',
				'choices' => array(
					'fluid-nav' => __( 'Full', 'creativityarchitect' ),
					'contained-nav' => __( 'Contained', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[nav_layout_setting]',
				'priority' => 15
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[nav_inner_width]',
			array(
				'default' => $defaults['nav_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'creativityarchitect_settings[nav_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Navigation Width', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_navigation',
				'choices' => array(
					'contained' => __( 'Contained', 'creativityarchitect' ),
					'full-width' => __( 'Full', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[nav_inner_width]',
				'priority' => 16
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[nav_alignment_setting]',
			array(
				'default' => $defaults['nav_alignment_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'creativityarchitect_settings[nav_alignment_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Alignment', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_navigation',
				'choices' => array(
					'left' => __( 'Left', 'creativityarchitect' ),
					'center' => __( 'Center', 'creativityarchitect' ),
					'right' => __( 'Right', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[nav_alignment_setting]',
				'priority' => 20
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[nav_position_setting]',
			array(
				'default' => $defaults['nav_position_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => ( '' !== creativityarchitect_get_setting( 'nav_position_setting' ) ) ? 'postMessage' : 'refresh'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'creativityarchitect_settings[nav_position_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Location', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_navigation',
				'choices' => array(
					'nav-below-header' => __( 'Below Header', 'creativityarchitect' ),
					'nav-above-header' => __( 'Above Header', 'creativityarchitect' ),
					'nav-float-right' => __( 'Float Right', 'creativityarchitect' ),
					'nav-float-left' => __( 'Float Left', 'creativityarchitect' ),
					'nav-left-sidebar' => __( 'Left Sidebar', 'creativityarchitect' ),
					'nav-right-sidebar' => __( 'Right Sidebar', 'creativityarchitect' ),
					'' => __( 'No Navigation', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[nav_position_setting]',
				'priority' => 22
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[nav_dropdown_type]',
			array(
				'default' => $defaults['nav_dropdown_type'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'creativityarchitect_settings[nav_dropdown_type]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Dropdown', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_navigation',
				'choices' => array(
					'hover' => __( 'Hover', 'creativityarchitect' ),
					'click' => __( 'Click - Menu Item', 'creativityarchitect' ),
					'click-arrow' => __( 'Click - Arrow', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[nav_dropdown_type]',
				'priority' => 22
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[nav_search]',
			array(
				'default' => $defaults['nav_search'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'creativityarchitect_settings[nav_search]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Search', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_navigation',
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[nav_search]',
				'priority' => 23
			)
		);

		// Add navigation setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[nav_effect]',
			array(
				'default' => $defaults['nav_effect'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		// Add navigation control
		$wp_customize->add_control(
			'creativityarchitect_settings[nav_effect]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Effects', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_navigation',
				'choices' => array(
					'none' => __( 'None', 'creativityarchitect' ),
					'stylea' => __( 'Brackets', 'creativityarchitect' ),
					'styleb' => __( 'Borders', 'creativityarchitect' ),
					'stylec' => __( 'Switch', 'creativityarchitect' ),
					'styled' => __( 'Fall down', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[nav_effect]',
				'priority' => 24
			)
		);

		// Add content setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[content_layout_setting]',
			array(
				'default' => $defaults['content_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add content control
		$wp_customize->add_control(
			'creativityarchitect_settings[content_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Content Layout', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_container',
				'choices' => array(
					'separate-containers' => __( 'Separate Containers', 'creativityarchitect' ),
					'one-container' => __( 'One Container', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[content_layout_setting]',
				'priority' => 25
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[fixed_side_content]',
			array(
				'default' => $defaults['fixed_side_content'],
				'type' => 'option',
				'sanitize_callback' => 'wp_kses_post',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[fixed_side_content]',
			array(
				'type' 		 => 'textarea',
				'label'      => __( 'Fixed Side Content', 'creativityarchitect' ),
				'description'=> __( 'Content that You want to display fixed on the left.', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_layout_sidecontent',
				'settings'   => 'creativityarchitect_settings[fixed_side_content]',
			)
		);

		// Add Layout setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[layout_setting]',
			array(
				'default' => $defaults['layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		// Add Layout control
		$wp_customize->add_control(
			'creativityarchitect_settings[layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Sidebar Layout', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'creativityarchitect' ),
					'right-sidebar' => __( 'Content / Sidebar', 'creativityarchitect' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'creativityarchitect' ),
					'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'creativityarchitect' ),
					'both-left' => __( 'Sidebar / Sidebar / Content', 'creativityarchitect' ),
					'both-right' => __( 'Content / Sidebar / Sidebar', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[layout_setting]',
				'priority' => 30
			)
		);

		// Add Layout setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[blog_layout_setting]',
			array(
				'default' => $defaults['blog_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		// Add Layout control
		$wp_customize->add_control(
			'creativityarchitect_settings[blog_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Blog Sidebar Layout', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'creativityarchitect' ),
					'right-sidebar' => __( 'Content / Sidebar', 'creativityarchitect' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'creativityarchitect' ),
					'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'creativityarchitect' ),
					'both-left' => __( 'Sidebar / Sidebar / Content', 'creativityarchitect' ),
					'both-right' => __( 'Content / Sidebar / Sidebar', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[blog_layout_setting]',
				'priority' => 35
			)
		);

		// Add Layout setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[single_layout_setting]',
			array(
				'default' => $defaults['single_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		// Add Layout control
		$wp_customize->add_control(
			'creativityarchitect_settings[single_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Single Post Sidebar Layout', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( 'Sidebar / Content', 'creativityarchitect' ),
					'right-sidebar' => __( 'Content / Sidebar', 'creativityarchitect' ),
					'no-sidebar' => __( 'Content (no sidebars)', 'creativityarchitect' ),
					'both-sidebars' => __( 'Sidebar / Content / Sidebar', 'creativityarchitect' ),
					'both-left' => __( 'Sidebar / Sidebar / Content', 'creativityarchitect' ),
					'both-right' => __( 'Content / Sidebar / Sidebar', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[single_layout_setting]',
				'priority' => 36
			)
		);

		// Add footer setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[footer_layout_setting]',
			array(
				'default' => $defaults['footer_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add content control
		$wp_customize->add_control(
			'creativityarchitect_settings[footer_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Width', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_footer',
				'choices' => array(
					'fluid-footer' => __( 'Full', 'creativityarchitect' ),
					'contained-footer' => __( 'Contained', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[footer_layout_setting]',
				'priority' => 40
			)
		);

		// Add footer setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[footer_widgets_inner_width]',
			array(
				'default' => $defaults['footer_widgets_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
			)
		);

		// Add content control
		$wp_customize->add_control(
			'creativityarchitect_settings[footer_widgets_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Footer Widgets Width', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_footer',
				'choices' => array(
					'contained' => __( 'Contained', 'creativityarchitect' ),
					'full-width' => __( 'Full', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[footer_widgets_inner_width]',
				'priority' => 41
			)
		);

		// Add footer setting
		$wp_customize->add_setting(
			'creativityarchitect_settings[footer_inner_width]',
			array(
				'default' => $defaults['footer_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add content control
		$wp_customize->add_control( 'creativityarchitect_settings[footer_inner_width]',
			array(
				'type' => 'select',
				'label' => __( 'Inner Footer Width', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_footer',
				'choices' => array(
					'contained' => __( 'Contained', 'creativityarchitect' ),
					'full-width' => __( 'Full', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[footer_inner_width]',
				'priority' => 41
			)
		);

		// Add footer widget setting
		$wp_customize->add_setting( 'creativityarchitect_settings[footer_widget_setting]',
			array(
				'default' => $defaults['footer_widget_setting'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add footer widget control
		$wp_customize->add_control( 'creativityarchitect_settings[footer_widget_setting]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Widgets', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_footer',
				'choices' => array(
					'0' => '0',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5'
				),
				'settings' => 'creativityarchitect_settings[footer_widget_setting]',
				'priority' => 45
			)
		);

		// Add footer widget setting
		$wp_customize->add_setting( 'creativityarchitect_settings[footer_bar_alignment]',
			array(
				'default' => $defaults['footer_bar_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices',
				'transport' => 'postMessage'
			)
		);

		// Add footer widget control
		$wp_customize->add_control( 'creativityarchitect_settings[footer_bar_alignment]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Bar Alignment', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_footer',
				'choices' => array(
					'left' => __( 'Left','creativityarchitect' ),
					'center' => __( 'Center','creativityarchitect' ),
					'right' => __( 'Right','creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[footer_bar_alignment]',
				'priority' => 47,
				'active_callback' => 'creativityarchitect_is_footer_bar_active'
			)
		);

		// Add back to top setting
		$wp_customize->add_setting( 'creativityarchitect_settings[back_to_top]',
			array(
				'default' => $defaults['back_to_top'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		// Add content control
		$wp_customize->add_control( 'creativityarchitect_settings[back_to_top]',
			array(
				'type' => 'select',
				'label' => __( 'Back to Top Button', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_footer',
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[back_to_top]',
				'priority' => 50
			)
		);

		$wp_customize->add_setting( 'creativityarchitect_settings[blog_header_image]',
			array(
				'default' => $defaults['blog_header_image'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url_raw'
			)
		);

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'creativityarchitect_settings[blog_header_image]',
				array(
					'label' => __( 'Blog Header image', 'creativityarchitect' ),
					'section' => 'creativityarchitect_blog_section',
					'settings' => 'creativityarchitect_settings[blog_header_image]',
					'description' => __( 'Recommended size: 1520*660px', 'creativityarchitect' )
				)
			)
		);

		// Blog header texts
		$wp_customize->add_setting( 'creativityarchitect_settings[blog_header_title]',
			array(
				'default' => $defaults['blog_header_title'],
				'type' => 'option',
				'sanitize_callback' => 'wp_kses_post',
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[blog_header_title]',
			array(
				'type' 		 => 'textarea',
				'label'      => __( 'Blog Header title', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_blog_section',
				'settings'   => 'creativityarchitect_settings[blog_header_title]',
				'description' => __( 'HTML allowed.', 'creativityarchitect' )
			)
		);

		$wp_customize->add_setting( 'creativityarchitect_settings[blog_header_text]',
			array(
				'default' => $defaults['blog_header_text'],
				'type' => 'option',
				'sanitize_callback' => 'wp_kses_post',
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[blog_header_text]',
			array(
				'type' 		 => 'textarea',
				'label'      => __( 'Blog Header text', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_blog_section',
				'settings'   => 'creativityarchitect_settings[blog_header_text]',
			)
		);

		$wp_customize->add_setting( 'creativityarchitect_settings[blog_header_button_text]',
			array(
				'default' => $defaults['blog_header_button_text'],
				'type' => 'option',
				'sanitize_callback' => 'esc_html',
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[blog_header_button_text]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Blog Header button text', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_blog_section',
				'settings'   => 'creativityarchitect_settings[blog_header_button_text]',
			)
		);

		$wp_customize->add_setting( 'creativityarchitect_settings[blog_header_button_url]',
			array(
				'default' => $defaults['blog_header_button_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[blog_header_button_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Blog Header button url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_blog_section',
				'settings'   => 'creativityarchitect_settings[blog_header_button_url]',
			)
		);

		// Add Layout setting
		$wp_customize->add_setting( 'creativityarchitect_settings[post_content]',
			array(
				'default' => $defaults['post_content'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_blog_excerpt'
			)
		);

		// Add Layout control
		$wp_customize->add_control( 'blog_content_control',
			array(
				'type' => 'select',
				'label' => __( 'Content Type', 'creativityarchitect' ),
				'section' => 'creativityarchitect_blog_section',
				'choices' => array(
					'full' => __( 'Full', 'creativityarchitect' ),
					'excerpt' => __( 'Excerpt', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[post_content]',
				'priority' => 10
			)
		);

		if ( ! function_exists( 'creativityarchitect_blog_customize_register' ) && ! defined( 'creativityarchitect_PREMIUM_VERSION' ) ) {
      $wp_customize->add_control( new creativityarchitect_Customize_Misc_Control( $wp_customize, 'blog_get_addon_desc',
        array(
          'section' => 'creativityarchitect_blog_section',
          'type' => 'addon',
          'label' => __( 'Learn more', 'creativityarchitect' ),
          'description' => __( 'More options are available for this section in our premium version.', 'creativityarchitect' ),
          'url' => esc_url( creativityarchitect_theme_uri_link() ),
          'priority' => 30,
          'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname'
        )
        )
      );
    }

		if ( ! apply_filters( 'creativityarchitect_fontawesome_essentials', false ) ) {
      $wp_customize->add_setting( 'creativityarchitect_settings[font_awesome_essentials]',
				array(
					'default' => $defaults['font_awesome_essentials'],
					'type' => 'option',
					'sanitize_callback' => 'creativityarchitect_sanitize_checkbox'
				)
			);

			$wp_customize->add_control( 'creativityarchitect_settings[font_awesome_essentials]',
				array(
					'type' => 'checkbox',
					'label' => __( 'Load essential icons only', 'creativityarchitect' ),
					'description' => __( 'Load essential Font Awesome icons instead of the full library.', 'creativityarchitect' ),
					'section' => 'creativityarchitect_general_section',
					'settings' => 'creativityarchitect_settings[font_awesome_essentials]',
				)
			);
		}

		$wp_customize->add_setting( 'creativityarchitect_settings[socials_display_side]',
			array(
				'default' => $defaults['socials_display_side'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_checkbox'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[socials_display_side]',
      array(
				'type' => 'checkbox',
				'label' => __( 'Display on fixed side', 'creativityarchitect' ),
				'section' => 'creativityarchitect_socials_section'
			)
		);

		$wp_customize->add_setting( 'creativityarchitect_settings[socials_display_top]',
			array(
				'default' => $defaults['socials_display_top'],
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_checkbox'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[socials_display_top]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Display on top bar', 'creativityarchitect' ),
				'section' => 'creativityarchitect_socials_section'
			)
		);

		$wp_customize->add_setting( 'creativityarchitect_settings[socials_facebook_url]',
			array(
				'default' => $defaults['socials_facebook_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[socials_facebook_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Facebook url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_facebook_url]',
			)
		);

		$wp_customize->add_setting( 'creativityarchitect_settings[socials_twitter_url]',
			array(
				'default' => $defaults['socials_twitter_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_twitter_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Twitter url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_twitter_url]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_google_url]',
			array(
				'default' => $defaults['socials_google_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_google_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Google url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_google_url]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_tumblr_url]',
			array(
				'default' => $defaults['socials_tumblr_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_tumblr_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Tumblr url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_tumblr_url]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_pinterest_url]',
			array(
				'default' => $defaults['socials_pinterest_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_pinterest_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Pinterest url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_pinterest_url]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_youtube_url]',
			array(
				'default' => $defaults['socials_youtube_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_youtube_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Youtube url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_youtube_url]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_linkedin_url]',
			array(
				'default' => $defaults['socials_linkedin_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_linkedin_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Linkedin url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_linkedin_url]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_linkedin_url]',
			array(
				'default' => $defaults['socials_linkedin_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_linkedin_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Linkedin url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_linkedin_url]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_custom_icon_1]',
			array(
				'default' => $defaults['socials_custom_icon_1'],
				'type' => 'option',
				'sanitize_callback' => 'esc_attr',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_custom_icon_1]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 1', 'creativityarchitect' ),
				'description'=> sprintf(
					'%1$s<br>%2$s<code>fa-file-pdf-o</code><br>%3$s<a href="%4$s" target="_blank">%5$s</a>',
					esc_html__( 'You can add icon code for Your button.', 'creativityarchitect' ),
					esc_html__( 'Example: ', 'creativityarchitect' ),
					esc_html__( 'Use the codes from ', 'creativityarchitect' ),
					esc_url( CREATIVITYARCHITECT_FONT_AWESOME_LINK ),
					esc_html__( 'this link', 'creativityarchitect' )
				),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_custom_icon_1]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_custom_icon_url_1]',
			array(
				'default' => $defaults['socials_custom_icon_url_1'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_custom_icon_url_1]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 1 url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_custom_icon_url_1]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_custom_icon_2]',
			array(
				'default' => $defaults['socials_custom_icon_2'],
				'type' => 'option',
				'sanitize_callback' => 'esc_attr',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_custom_icon_2]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 2', 'creativityarchitect' ),
				'description'=> sprintf(
					'%1$s<br>%2$s<code>fa-file-pdf-o</code><br>%3$s<a href="%4$s" target="_blank">%5$s</a>',
					esc_html__( 'You can add icon code for Your button.', 'creativityarchitect' ),
					esc_html__( 'Example: ', 'creativityarchitect' ),
					esc_html__( 'Use the codes from ', 'creativityarchitect' ),
					esc_url( CREATIVITYARCHITECT_FONT_AWESOME_LINK ),
					esc_html__( 'this link', 'creativityarchitect' )
				),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_custom_icon_2]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_custom_icon_url_2]',
			array(
				'default' => $defaults['socials_custom_icon_url_2'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_custom_icon_url_2]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 2 url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_custom_icon_url_2]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_custom_icon_3]',
			array(
				'default' => $defaults['socials_custom_icon_3'],
				'type' => 'option',
				'sanitize_callback' => 'esc_attr',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_custom_icon_3]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 3', 'creativityarchitect' ),
				'description'=> sprintf(
					'%1$s<br>%2$s<code>fa-file-pdf-o</code><br>%3$s<a href="%4$s" target="_blank">%5$s</a>',
					esc_html__( 'You can add icon code for Your button.', 'creativityarchitect' ),
					esc_html__( 'Example: ', 'creativityarchitect' ),
					esc_html__( 'Use the codes from ', 'creativityarchitect' ),
					esc_url( CREATIVITYARCHITECT_FONT_AWESOME_LINK ),
					esc_html__( 'this link', 'creativityarchitect' )
				),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_custom_icon_3]',
			)
		);

		$wp_customize->add_setting(
			'creativityarchitect_settings[socials_custom_icon_url_3]',
			array(
				'default' => $defaults['socials_custom_icon_url_3'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[socials_custom_icon_url_3]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'Custom icon 3 url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_custom_icon_url_3]',
			)
		);

		$wp_customize->add_setting(
      'creativityarchitect_settings[socials_mail_url]',
			array(
				'default' => $defaults['socials_mail_url'],
				'type' => 'option',
				'sanitize_callback' => 'esc_attr',
			)
		);
		$wp_customize->add_control(
      'creativityarchitect_settings[socials_mail_url]',
			array(
				'type' 		 => 'text',
				'label'      => __( 'E-mail url', 'creativityarchitect' ),
				'section'    => 'creativityarchitect_socials_section',
				'settings'   => 'creativityarchitect_settings[socials_mail_url]',
			)
		);


		// BG dots
		$wp_customize->add_setting( 'creativityarchitect_settings[bg_dots]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);
		$wp_customize->add_control( 'creativityarchitect_settings[bg_dots]',
			array(
				'type' => 'select',
				'label' => __( 'BG dots', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[bg_dots]',
				'section' => 'creativityarchitect_layout_effects',
				'priority' => 1
      )
    );

		// Magic cursor
		$wp_customize->add_setting( 'creativityarchitect_settings[magic_cursor]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[magic_cursor]',
			array(
				'type' => 'select',
				'label' => __( 'Magic cursor', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[magic_cursor]',
				'section' => 'creativityarchitect_layout_effects',
				'priority' => 2
			)
		);

    // Blog post background
		$wp_customize->add_setting(
			'creativityarchitect_settings[blog_bg]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control(
			'creativityarchitect_settings[blog_bg]',
			array(
				'type' => 'select',
				'label' => __( 'Blog post background', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[blog_bg]',
				'section' => 'creativityarchitect_layout_effects',
				'priority' => 3
			)
		);

		// Add navigation extra button text
		$wp_customize->add_setting( 'creativityarchitect_settings[nav_btn_text]',
			array(
				'default' => '',
				'type' => 'option',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
		$wp_customize->add_control(
			'creativityarchitect_settings[nav_btn_text]',
			array(
				'type' => 'text',
				'label' => __( 'Extra button text', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_effects',
				'settings' => 'creativityarchitect_settings[nav_btn_text]',
				'priority' => 25
			)
		);

		// Add navigation extra button url
		$wp_customize->add_setting(
			'creativityarchitect_settings[nav_btn_url]',
			array(
				'default' => '',
				'type' => 'option',
				'sanitize_callback' => 'esc_url'
			)
		);
		$wp_customize->add_control(
			'creativityarchitect_settings[nav_btn_url]',
			array(
				'type' => 'text',
				'label' => __( 'Extra button URL', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_effects',
				'settings' => 'creativityarchitect_settings[nav_btn_url]',
				'priority' => 25
			)
		);

    // Add border under header
		$wp_customize->add_setting( 'creativityarchitect_settings[header_border_none]',
			array(
				'default' => false,
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_checkbox'
			)
		);
		$wp_customize->add_control( 'creativityarchitect_settings[header_border_none]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Disable border under header', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_header',
				'priority' => 2
			)
		);

    // Header border
		$wp_customize->add_setting( 'creativityarchitect_settings[header_border]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[header_border]',
			array(
				'type' => 'select',
				'label' => __( 'Header border', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[header_border]',
				'section' => 'creativityarchitect_layout_effects',
				'priority' => 1
			)
		);

    // Sidebar border
		$wp_customize->add_setting( 'creativityarchitect_settings[sidebar_border]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[sidebar_border]',
			array(
				'type' => 'select',
				'label' => __( 'Sidebar border', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[sidebar_border]',
				'section' => 'creativityarchitect_layout_effects',
				'priority' => 2
			)
		);

    // Header type effect
		$wp_customize->add_setting( 'creativityarchitect_settings[type_effect]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[type_effect]',
			array(
				'type' => 'select',
				'label' => __( 'Header type effect', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[type_effect]',
				'section' => 'creativityarchitect_layout_effects',
				'priority' => 3
			)
		);



		// Add border next to logo
		$wp_customize->add_setting( 'creativityarchitect_settings[logo_border_none]',
			array(
				'default' => false,
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_checkbox'
			)
		);
		$wp_customize->add_control( 'creativityarchitect_settings[logo_border_none]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Disable border next to logo', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_navigation',
				'priority' => 2
			)
		);

    // Borders
		$wp_customize->add_setting( 'creativityarchitect_settings[borders]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);
		$wp_customize->add_control( 'creativityarchitect_settings[borders]',
			array(
				'type' => 'select',
				'label' => __( 'Borders', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[borders]',
				'section' => 'creativityarchitect_layout_effects',
				'priority' => 1
			)
		);

    // Blog img border
		$wp_customize->add_setting( 'creativityarchitect_settings[blog_img_border]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);
		$wp_customize->add_control( 'creativityarchitect_settings[blog_img_border]',
			array(
				'type' => 'select',
				'label' => __( 'Blog img border', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[blog_img_border]',
				'section' => 'creativityarchitect_layout_effects',
				'priority' => 2
			)
		);

		$wp_customize->add_setting( 'creativityarchitect_settings[creativityarchitect_border_color]',
      array(
        'default' => '#000000',
        'type' => 'option',
        'sanitize_callback' => 'creativityarchitect_sanitize_hex_color',
      )
    );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'creativityarchitect_settings[creativityarchitect_border_color]',
      array(
        'label' => __( 'Border color', 'creativityarchitect' ),
        'section' => 'creativityarchitect_layout_effects',
        'settings' => 'creativityarchitect_settings[creativityarchitect_border_color]',
        'priority' => 3
      )
      )
    );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'creativityarchitect_settings[creativityarchitect_border_color]',
      array(
        'label' => __( 'Border color', 'creativityarchitect' ),
        'section' => 'creativityarchitect_layout_effects',
        'settings' => 'creativityarchitect_settings[creativityarchitect_border_color]',
        'priority' => 3
				)
			)
		);

    // creativityarchitect effect colors
		$wp_customize->add_setting(
			'creativityarchitect_settings[creativityarchitect_color_1]', array(
				'default' => '#cccccc',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_hex_color',
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'creativityarchitect_settings[creativityarchitect_color_1]',
      array(
				'label' => __( 'Border color', 'creativityarchitect' ),
				'section' => 'creativityarchitect_layout_effects',
				'settings' => 'creativityarchitect_settings[creativityarchitect_color_1]',
				'priority' => 30
      )
      )
		);

		// Unique scrollbar
		$wp_customize->add_setting( 'creativityarchitect_settings[unique_scrollbar]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[unique_scrollbar]',
			array(
				'type' => 'select',
				'label' => __( 'Unique scrollbar', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[unique_scrollbar]',
				'section' => 'creativityarchitect_layout_effects',
				'priority' => 4
			)
		);

		// Cursor image
		$wp_customize->add_setting( 'creativityarchitect_settings[cursor_image]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);
		$wp_customize->add_control( 'creativityarchitect_settings[cursor_image]',
			array(
				'type' => 'select',
				'label' => __( 'Cursor image', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[cursor_image]',
				'section' => 'creativityarchitect_layout_effects',
				'priority' => 9
			)
		);

		$wp_customize->add_setting( 'creativityarchitect_settings[def_cursor_image]',
      array(
        'default' => '',
        'type' => 'option',
        'sanitize_callback' => 'esc_url_raw'
      )
    );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'creativityarchitect_settings[def_cursor_image]',
      array(
        'label' => __( 'Default cursor image', 'creativityarchitect' ),
        'section' => 'creativityarchitect_layout_effects',
        'priority' => 10,
        'settings' => 'creativityarchitect_settings[def_cursor_image]',
        'description' => __( 'Recommended size: 32*32px. Big image won`t work.', 'creativityarchitect' )
      )
      )
    );

		$wp_customize->add_setting( 'creativityarchitect_settings[pointer_cursor_image]',
      array(
        'default' => '',
        'type' => 'option',
        'sanitize_callback' => 'esc_url_raw'
      )
    );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'creativityarchitect_settings[pointer_cursor_image]',
      array(
        'label' => __( 'Pointer cursor image', 'creativityarchitect' ),
        'section' => 'creativityarchitect_layout_effects',
        'priority' => 11,
        'settings' => 'creativityarchitect_settings[pointer_cursor_image]',
        'description' => __( 'Recommended size: 32*32px. Big image won`t work.', 'creativityarchitect' )
      )
      )
    );

    // Blog image effect
		$wp_customize->add_setting( 'creativityarchitect_settings[img_effect]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[img_effect]',
			array(
				'type' => 'select',
				'label' => __( 'Blog image effect', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[img_effect]',
				'section' => 'creativityarchitect_blog_section',
				'priority' => 29
			)
		);

		// Preloader
		$wp_customize->add_setting( 'creativityarchitect_settings[creativityarchitect_preloader]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[creativityarchitect_preloader]',
			array(
				'type' => 'select',
				'label' => __( 'Preloader', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[creativityarchitect_preloader]',
				'section' => 'title_tagline',
				'priority' => 2
			)
		);

		// Logo pulse effect
		$wp_customize->add_setting( 'creativityarchitect_settings[logo_pulse]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[logo_pulse]',
			array(
				'type' => 'select',
				'label' => __( 'creativityarchitect logo pulse', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[logo_pulse]',
				'section' => 'title_tagline',
				'priority' => 2
			)
		);

		// Nicescroll
		$wp_customize->add_setting( 'creativityarchitect_settings[nicescroll]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[nicescroll]',
			array(
				'type' => 'select',
				'label' => __( 'Scrollbar style', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[nicescroll]',
				'section' => 'creativityarchitect_layout_container',
				'priority' => 20
			)
		);

		// Cursor
		$wp_customize->add_setting( 'creativityarchitect_settings[cursor]',
			array(
				'default' => 'enable',
				'type' => 'option',
				'sanitize_callback' => 'creativityarchitect_sanitize_choices'
			)
		);

		$wp_customize->add_control( 'creativityarchitect_settings[cursor]',
			array(
				'type' => 'select',
				'label' => __( 'Cursor image', 'creativityarchitect' ),
				'choices' => array(
					'enable' => __( 'Enable', 'creativityarchitect' ),
					'disable' => __( 'Disable', 'creativityarchitect' )
				),
				'settings' => 'creativityarchitect_settings[cursor]',
				'section' => 'creativityarchitect_layout_container',
				'priority' => 20
			)
		);



		// Add creativityarchitect Premium section
		if ( ! defined( 'creativityarchitect_PREMIUM_VERSION' ) ) {
			$wp_customize->add_section(
				new creativityarchitect_Upsell_Section( $wp_customize, 'creativityarchitect_upsell_section',
					array(
						'pro_text' => __( 'Get Premium for more!', 'creativityarchitect' ),
						'pro_url' => esc_url( creativityarchitect_theme_uri_link() ),
						'capability' => 'edit_theme_options',
						'priority' => 555,
						'type' => 'creativityarchitect-upsell-section',
					)
				)
			);
		}
	}
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function creativityarchitect_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function creativityarchitect_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
   * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
   */
function creativityarchitect_customize_preview_js() {
  	wp_enqueue_script( 'creativityarchitect-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), 'CREATIVITYARCHITECT_VERSION', true );
  }
