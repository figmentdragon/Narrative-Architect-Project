<?php
/**
 * Custom scaffolding Library functions.
 *
 * File for custom scaffolding Library functionality.
 *
 * @package creativity architect
 */

/**
 * Build a scaffolding section.
 *
 * @author Greg Rickaby, Carrie Forde
 *
 * @param array $args The scaffolding defaults.
 */


/**
 * Declare HTML tags allowed for scaffolding.
 *
 * @author Carrie Forde
 *
 * @return array The allowed tags and attributes.
 */
function scaffolding_allowed_html() {
	// Add additional HTML tags to the wp_kses() allowed html filter.
	return array_merge(
		wp_kses_allowed_html( 'post' ),
		[
			'svg'    => [
				'aria-hidden' => true,
				'class'       => true,
				'id'          => true,
				'role'        => true,
				'title'       => true,
				'fill'        => true,
				'height'      => true,
				'width'       => true,
				'use'         => true,
				'path'        => true,
			],
			'use'    => [
				'xlink:href' => true,
			],
			'title'  => [
				'id' => true,
			],
			'desc'   => [
				'id' => true,
			],
			'select' => [
				'class' => true,
			],
			'option' => [
				'option'   => true,
				'value'    => true,
				'selected' => true,
				'disabled' => true,
			],
			'input'  => [
				'type'        => true,
				'name'        => true,
				'value'       => true,
				'placeholder' => true,
				'class'       => true,
			],
			'iframe' => [
				'src'             => [],
				'height'          => [],
				'width'           => [],
				'frameborder'     => [],
				'allowfullscreen' => [],
			],
		]
	);
}

/**
 * Build a global scaffolding element.
 *
 * @author Carrie Forde
 *
 * @param array $args The array of colors or fonts.
 */

/**
 * Hook the theme's scaffolding template parts into the scaffolding template.
 *
 * @author Carrie Forde
 */
function hook_theme_scaffolding() {
	$template_dir = 'template-parts/scaffolding/scaffolding';

	get_template_part( $template_dir, 'globals' );
	get_template_part( $template_dir, 'typography' );
	get_template_part( $template_dir, 'media' );
	get_template_part( $template_dir, 'icons' );
	get_template_part( $template_dir, 'buttons' );
	get_template_part( $template_dir, 'forms' );
	get_template_part( $template_dir, 'elements' );
}

add_action( 'scaffolding_content', 'hook_theme_scaffolding' );
