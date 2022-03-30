<?php
/**
 * Customizer sections.
 *
 * @package creativity_ architect
 */

/**
 * Register the section sections.
 *
 * @author WebDevStudios
 * @param object $wp_customize Instance of WP_Customize_Class.
 */
function creativity_customize_sections( $wp_customize ) {

	// Register additional scripts section.
	$wp_customize->add_section(
		'creativity_additional_scripts_section',
		[
			'title'    => esc_html__( 'Additional Scripts', 'creativity_architect' ),
			'priority' => 10,
			'panel'    => 'site-options',
		]
	);

	// Register a social links section.
	$wp_customize->add_section(
		'creativity_social_links_section',
		[
			'title'       => esc_html__( 'Social Media', 'creativity_architect' ),
			'description' => esc_html__( 'Links here power the display_social_network_links() template tag.', 'creativity_architect' ),
			'priority'    => 90,
			'panel'       => 'site-options',
		]
	);

	// Register a header section.
	$wp_customize->add_section(
		'creativity_header_section',
		[
			'title'    => esc_html__( 'Header Customizations', 'creativity_architect' ),
			'priority' => 90,
			'panel'    => 'site-options',
		]
	);

	// Register a footer section.
	$wp_customize->add_section(
		'creativity_footer_section',
		[
			'title'    => esc_html__( 'Footer Customizations', 'creativity_architect' ),
			'priority' => 90,
			'panel'    => 'site-options',
		]
	);
}
add_action( 'customize_register', 'creativity_customize_sections' );
