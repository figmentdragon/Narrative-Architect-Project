<?php
/**
 * Footer elements.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'creativityarchitect_construct_footer' ) ) {
	add_action( 'creativityarchitect_footer', 'creativityarchitect_construct_footer' );
	/**
	 * Build our footer.
	 *
	 */
	function creativityarchitect_construct_footer() {
		?>
		<footer class="site-info" itemtype="https://schema.org/WPFooter" itemscope="itemscope">
			<div class="inside-site-info <?php if ( 'full-width' !== creativityarchitect_get_setting( 'footer_inner_width' ) ) : ?>grid-container grid-parent<?php endif; ?>">
				<?php
				/**
				 * creativityarchitect_before_copyright hook.
				 *
				 *
				 * @hooked creativityarchitect_footer_bar - 15
				 */
				do_action( 'creativityarchitect_before_copyright' );
				?>
				<div class="copyright-bar">
					<?php
					/**
					 * creativityarchitect_credits hook.
					 *
					 *
					 * @hooked creativityarchitect_add_footer_info - 10
					 */
					do_action( 'creativityarchitect_credits' );
					?>
				</div>
			</div>
		</footer><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists( 'creativityarchitect_footer_bar' ) ) {
	add_action( 'creativityarchitect_before_copyright', 'creativityarchitect_footer_bar', 15 );
	/**
	 * Build our footer bar
	 *
	 */
	function creativityarchitect_footer_bar() {
		if ( ! is_active_sidebar( 'footer-bar' ) ) {
			return;
		}
		?>
		<div class="footer-bar">
			<?php dynamic_sidebar( 'footer-bar' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'creativityarchitect_add_footer_info' ) ) {
	add_action( 'creativityarchitect_credits', 'creativityarchitect_add_footer_info' );
	/**
	 * Add the copyright to the footer
	 *
	 */
	function creativityarchitect_add_footer_info() {
		echo '<span class="copyright">&copy; ' . esc_html( date( 'Y' ) ) . ' ' . esc_html( get_bloginfo( 'name' ) ) . '</span> &bull; ' . esc_html__( 'Powered by', 'creativityarchitect' ) . ' <a href="' . esc_url( creativityarchitect_theme_uri_link() ) . '" itemprop="url">' . esc_html__( 'WPKoi', 'creativityarchitect' ) . '</a>';
	}
}

/**
 * Build our individual footer widgets.
 * Displays a sample widget if no widget is found in the area.
 *
 *
 * @param int $widget_width The width class of our widget.
 * @param int $widget The ID of our widget.
 */
function creativityarchitect_do_footer_widget( $widget_width, $widget ) {
	$widget_width = apply_filters( "creativityarchitect_footer_widget_{$widget}_width", $widget_width );
	$tablet_widget_width = apply_filters( "creativityarchitect_footer_widget_{$widget}_tablet_width", '50' );
	?>
	<div class="footer-widget-<?php echo absint( $widget ); ?> grid-parent grid-<?php echo absint( $widget_width ); ?> tablet-grid-<?php echo absint( $tablet_widget_width ); ?> mobile-grid-100">
		<?php if ( ! dynamic_sidebar( 'footer-' . absint( $widget ) ) ) :
	        $current_user = wp_get_current_user();
	        if (user_can( $current_user, 'administrator' )) { ?>
			<aside class="widget inner-padding widget_text">
				<h4 class="widget-title"><?php esc_html_e( 'Footer Widget', 'creativityarchitect' );?></h4>
				<div class="textwidget">
					<p>
						<?php esc_html_e( 'Replace this widget content by going to ', 'creativityarchitect' ); ?><a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><strong><?php esc_html_e('Appearance / Widgets', 'creativityarchitect' ); ?></strong></a><?php esc_html_e( ' and dragging widgets into this widget area.', 'creativityarchitect' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'To remove or choose the number of footer widgets, go to ', 'creativityarchitect' ); ?><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><strong><?php esc_html_e('Appearance / Customize / Layout / Footer Widgets', 'creativityarchitect' ); ?></strong></a><?php esc_html_e( '.', 'creativityarchitect' ); ?>
					</p>
				</div>
			</aside>
		<?php } endif; ?>
	</div>
	<?php
}

if ( ! function_exists( 'creativityarchitect_construct_footer_widgets' ) ) {
	add_action( 'creativityarchitect_footer', 'creativityarchitect_construct_footer_widgets', 5 );
	/**
	 * Build our footer widgets.
	 *
	 */
	function creativityarchitect_construct_footer_widgets() {
		// Get how many widgets to show.
		$widgets = creativityarchitect_get_footer_widgets();

		if ( ! empty( $widgets ) && 0 !== $widgets ) :

			// Set up the widget width.
			$widget_width = '';
			if ( $widgets == 1 ) {
				$widget_width = '100';
			}

			if ( $widgets == 2 ) {
				$widget_width = '50';
			}

			if ( $widgets == 3 ) {
				$widget_width = '33';
			}

			if ( $widgets == 4 ) {
				$widget_width = '25';
			}

			if ( $widgets == 5 ) {
				$widget_width = '20';
			}
			?>
			<div id="footer-widgets" class="site footer-widgets">
				<div <?php creativityarchitect_inside_footer_class(); ?>>
					<div class="inside-footer-widgets">
						<?php
						if ( $widgets >= 1 ) {
							creativityarchitect_do_footer_widget( $widget_width, 1 );
						}

						if ( $widgets >= 2 ) {
							creativityarchitect_do_footer_widget( $widget_width, 2 );
						}

						if ( $widgets >= 3 ) {
							creativityarchitect_do_footer_widget( $widget_width, 3 );
						}

						if ( $widgets >= 4 ) {
							creativityarchitect_do_footer_widget( $widget_width, 4 );
						}

						if ( $widgets >= 5 ) {
							creativityarchitect_do_footer_widget( $widget_width, 5 );
						}
						?>
					</div>
				</div>
			</div>
		<?php
		endif;

		/**
		 * creativityarchitect_after_footer_widgets hook.
		 *
		 */
		do_action( 'creativityarchitect_after_footer_widgets' );
	}
}

if ( ! function_exists( 'creativityarchitect_back_to_top' ) ) {
	add_action( 'creativityarchitect_after_footer', 'creativityarchitect_back_to_top', 2 );
	/**
	 * Build the back to top button
	 *
	 */
	function creativityarchitect_back_to_top() {
		$creativityarchitect_settings = wp_parse_args(
			get_option( 'creativityarchitect_settings', array() ),
			creativityarchitect_get_defaults()
		);

		if ( 'enable' !== $creativityarchitect_settings[ 'back_to_top' ] ) {
			return;
		}

		echo '<a title="' . esc_attr__( 'Scroll back to top', 'creativityarchitect' ) . '" rel="nofollow" href="#" class="creativityarchitect-back-to-top" style="opacity:0;visibility:hidden;" data-scroll-speed="' . absint( apply_filters( 'creativityarchitect_back_to_top_scroll_speed', 400 ) ) . '" data-start-scroll="' . absint( apply_filters( 'creativityarchitect_back_to_top_start_scroll', 300 ) ) . '">
				<span class="screen-reader-text">' . esc_html__( 'Scroll back to top', 'creativityarchitect' ) . '</span>
			</a>';
	}
}

add_action( 'creativityarchitect_after_footer', 'creativityarchitect_side_padding_footer', 5 );
/**
 * Add holder div if sidebar padding is enabled
 *
 */
function creativityarchitect_side_padding_footer() { 
	$creativityarchitect_settings = wp_parse_args(
		get_option( 'creativityarchitect_spacing_settings', array() ),
		creativityarchitect_spacing_get_defaults()
	);
	
	$fixed_side_content   =  creativityarchitect_get_setting( 'fixed_side_content' ); 
	$socials_display_side =  creativityarchitect_get_setting( 'socials_display_side' ); 
	
	if ( ( $creativityarchitect_settings[ 'side_top' ] != 0 ) || ( $creativityarchitect_settings[ 'side_right' ] != 0 ) || ( $creativityarchitect_settings[ 'side_bottom' ] != 0 ) || ( $creativityarchitect_settings[ 'side_left' ] != 0 ) ) { ?>
    	<div class="creativityarchitect-side-left-cover"></div>
    	<div class="creativityarchitect-side-right-cover"></div>
	</div>
	<?php } 
	if ( ( $fixed_side_content != '' ) || ( $socials_display_side == true ) ) { ?>
    <div class="creativityarchitect-side-left-content">
        <?php if ( $socials_display_side == true ) { ?>
        <div class="creativityarchitect-side-left-socials">
        <?php do_action( 'creativityarchitect_social_bar_action' ); ?>
        </div>
        <?php } ?>
        <?php if ( $fixed_side_content != '' ) { ?>
    	<div class="creativityarchitect-side-left-text">
        <?php echo wp_kses_post( $fixed_side_content ); ?>
        </div>
        <?php } ?>
    </div>
    <?php
	}
}
