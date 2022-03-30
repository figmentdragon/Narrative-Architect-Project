<?php
/**
 * Customizer Separator Control settings for this theme.
 *
 * @package WordPress
 * @subpackage TheCreativityArchitect
 * @since TheCreativityArchitect 1.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	if ( ! class_exists( 'Separator_Control' ) ) {
		/**
		 * Separator Control.
		 *
		 * @since TheCreativityArchitect 1.0
		 */
		class Separator_Control extends WP_Customize_Control {
			/**
			 * Render the hr.
			 *
			 * @since TheCreativityArchitect 1.0
			 */
			public function render_content() {
				echo '<hr/>';
			}

		}
	}
}
