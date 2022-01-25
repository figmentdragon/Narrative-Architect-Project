<?php
/**
 * Customize API: WP_Customize_Color_Control class
 *
 * @package WordPress
 * @subpackage architecture
 * @since architecture 1.0
 */

/**
 * Customize Color Control class.
 *
 * @since architecture 1.0
 *
 * @see WP_Customize_Control
 */
class architecture_Customize_Color_Control extends WP_Customize_Color_Control {
	/**
	 * The control type.
	 *
	 * @since architecture 1.0
	 *
	 * @var string
	 */
	public $type = 'architecture-color';

	/**
	 * Colorpicker palette
	 *
	 * @since architecture 1.0
	 *
	 * @var array
	 */
	public $palette;

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since architecture 1.0
	 *
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		// Enqueue the script.
		wp_enqueue_script(
			'architecture-control-color',
			get_theme_file_uri( 'theme/man/assets/scripts/js/palette-colorpicker.js' ),
			array( 'customize-controls', 'jquery', 'customize-base', 'wp-color-picker' ),
			wp_get_theme()->get( 'Version' ),
			false
		);
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since architecture 1.0
	 *
	 * @uses WP_Customize_Control::to_json()
	 *
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$this->json['palette'] = $this->palette;
	}
}
