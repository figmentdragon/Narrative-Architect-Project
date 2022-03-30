<?php
/**
 * Customize API: TheCreativityArchitectCustomize_Notice_Control class
 *
 * @package WordPress
 * @subpackage TheCreativityArchitect
 * @since TheCreativityArchitect 1.0
 */

/**
 * Customize Notice Control class.
 *
 * @since TheCreativityArchitect 1.0
 *
 * @see WP_Customize_Control
 */
class Customize_Notice_Control extends WP_Customize_Control {
	/**
	 * The control type.
	 *
	 * @since TheCreativityArchitect 1.0
	 *
	 * @var string
	 */
	public $type = 'TheCreativityArchitect-notice';

	/**
	 * Renders the control content.
	 *
	 * This simply prints the notice we need.
	 *
	 * @since TheCreativityArchitect 1.0
	 *
	 * @return void
	 */
	public function render_content() {
		?>
		<div class="notice notice-warning">
			<p><?php esc_html_e( 'To access the Dark Mode settings, select a light background color.', 'TheCreativityArchitect' ); ?></p>
			<p><a href="<?php echo esc_url( __( 'https://wordpress.org/support/article/TheCreativityArchitect/#dark-mode-support', 'TheCreativityArchitect' ) ); ?>">
				<?php esc_html_e( 'Learn more about Dark Mode.', 'TheCreativityArchitect' ); ?>
			</a></p>
		</div>
		<?php
	}
}
