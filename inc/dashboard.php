<?php
/**
 * Builds our admin page.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'creativityarchitect_create_menu' ) ) {
	add_action( 'admin_menu', 'creativityarchitect_create_menu' );
	/**
	 * Adds our "creativityarchitect" dashboard menu item
	 *
	 */
	function creativityarchitect_create_menu() {
		$creativityarchitect_page = add_theme_page( 'creativityarchitect', 'creativityarchitect', apply_filters( 'creativityarchitect_dashboard_page_capability', 'edit_theme_options' ), 'creativityarchitect-options', 'creativityarchitect_settings_page' );
		add_action( "admin_print_styles-$creativityarchitect_page", 'creativityarchitect_options_styles' );
	}
}

if ( ! function_exists( 'creativityarchitect_options_styles' ) ) {
	/**
	 * Adds any necessary scripts to the creativityarchitect dashboard page
	 *
	 */
	function creativityarchitect_options_styles() {
		wp_enqueue_style( 'creativityarchitect-options', get_template_directory_uri() . '/css/admin/admin-style.css', array(), creativityarchitect_VERSION );
	}
}

if ( ! function_exists( 'creativityarchitect_settings_page' ) ) {
	/**
	 * Builds the content of our creativityarchitect dashboard page
	 *
	 */
	function creativityarchitect_settings_page() {
		?>
		<div class="wrap">
			<div class="metabox-holder">
				<div class="creativityarchitect-masthead clearfix">
					<div class="creativityarchitect-container">
						<div class="creativityarchitect-title">
							<a href="<?php echo esc_url(creativityarchitect_theme_uri_link()); ?>" target="_blank"><?php esc_html_e( 'creativityarchitect', 'creativityarchitect' ); ?></a> <span class="creativityarchitect-version"><?php echo esc_html( creativityarchitect_VERSION ); ?></span>
						</div>
						<div class="creativityarchitect-masthead-links">
							<?php if ( ! defined( 'creativityarchitect_PREMIUM_VERSION' ) ) : ?>
								<a class="creativityarchitect-masthead-links-bold" href="<?php echo esc_url(creativityarchitect_theme_uri_link()); ?>" target="_blank"><?php esc_html_e( 'Premium', 'creativityarchitect' );?></a>
							<?php endif; ?>
							<a href="<?php echo esc_url(creativityarchitect_WPKOI_AUTHOR_URL); ?>" target="_blank"><?php esc_html_e( 'WPKoi', 'creativityarchitect' ); ?></a>
                            <a href="<?php echo esc_url(creativityarchitect_DOCUMENTATION); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'creativityarchitect' ); ?></a>
						</div>
					</div>
				</div>

				<?php
				/**
				 * creativityarchitect_dashboard_after_header hook.
				 *
				 */
				 do_action( 'creativityarchitect_dashboard_after_header' );
				 ?>

				<div class="creativityarchitect-container">
					<div class="postbox-container clearfix" style="float: none;">
						<div class="grid-container grid-parent">

							<?php
							/**
							 * creativityarchitect_dashboard_inside_container hook.
							 *
							 */
							 do_action( 'creativityarchitect_dashboard_inside_container' );
							 ?>

							<div class="form-metabox grid-70" style="padding-left: 0;">
								<h2 style="height:0;margin:0;"><!-- admin notices below this element --></h2>
								<form method="post" action="options.php">
									<?php settings_fields( 'creativityarchitect-settings-group' ); ?>
									<?php do_settings_sections( 'creativityarchitect-settings-group' ); ?>
									<div class="customize-button hide-on-desktop">
										<?php
										printf( '<a id="creativityarchitect_customize_button" class="button button-primary" href="%1$s">%2$s</a>',
											esc_url( admin_url( 'customize.php' ) ),
											esc_html__( 'Customize', 'creativityarchitect' )
										);
										?>
									</div>

									<?php
									/**
									 * creativityarchitect_inside_options_form hook.
									 *
									 */
									 do_action( 'creativityarchitect_inside_options_form' );
									 ?>
								</form>

								<?php
								$modules = array(
									'Backgrounds' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Blog' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Colors' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Copyright' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Disable Elements' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Demo Import' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Hooks' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Import / Export' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Menu Plus' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Page Header' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Secondary Nav' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Spacing' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Typography' => array(
											'url' => creativityarchitect_theme_uri_link(),
									),
									'Elementor Addon' => array(
											'url' => creativityarchitect_theme_uri_link(),
									)
								);

								if ( ! defined( 'creativityarchitect_PREMIUM_VERSION' ) ) : ?>
									<div class="postbox creativityarchitect-metabox">
										<h3 class="hndle"><?php esc_html_e( 'Premium Modules', 'creativityarchitect' ); ?></h3>
										<div class="inside" style="margin:0;padding:0;">
											<div class="premium-addons">
												<?php foreach( $modules as $module => $info ) { ?>
												<div class="add-on activated creativityarchitect-clear addon-container grid-parent">
													<div class="addon-name column-addon-name" style="">
														<a href="<?php echo esc_url( $info[ 'url' ] ); ?>" target="_blank"><?php echo esc_html( $module ); ?></a>
													</div>
													<div class="addon-action addon-addon-action" style="text-align:right;">
														<a href="<?php echo esc_url( $info[ 'url' ] ); ?>" target="_blank"><?php esc_html_e( 'More info', 'creativityarchitect' ); ?></a>
													</div>
												</div>
												<div class="creativityarchitect-clear"></div>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php
								endif;

								/**
								 * creativityarchitect_options_items hook.
								 *
								 */
								do_action( 'creativityarchitect_options_items' );
								?>
							</div>

							<div class="creativityarchitect-right-sidebar grid-30" style="padding-right: 0;">
								<div class="customize-button hide-on-mobile">
									<?php
									printf( '<a id="creativityarchitect_customize_button" class="button button-primary" href="%1$s">%2$s</a>',
										esc_url( admin_url( 'customize.php' ) ),
										esc_html__( 'Customize', 'creativityarchitect' )
									);
									?>
								</div>

								<?php
								/**
								 * creativityarchitect_admin_right_panel hook.
								 *
								 */
								 do_action( 'creativityarchitect_admin_right_panel' );

								  ?>
                                
                                <div class="wpkoi-doc">
                                	<h3><?php esc_html_e( 'creativityarchitect documentation', 'creativityarchitect' ); ?></h3>
                                	<p><?php esc_html_e( 'If You`ve stuck, the documentation may help on WPKoi.com', 'creativityarchitect' ); ?></p>
                                    <a href="<?php echo esc_url(creativityarchitect_DOCUMENTATION); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'creativityarchitect documentation', 'creativityarchitect' ); ?></a>
                                </div>
                                
                                <div class="wpkoi-social">
                                	<h3><?php esc_html_e( 'WPKoi on Facebook', 'creativityarchitect' ); ?></h3>
                                	<p><?php esc_html_e( 'If You want to get useful info about WordPress and the theme, follow WPKoi on Facebook.', 'creativityarchitect' ); ?></p>
                                    <a href="<?php echo esc_url(creativityarchitect_WPKOI_SOCIAL_URL); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Go to Facebook', 'creativityarchitect' ); ?></a>
                                </div>
                                
                                <div class="wpkoi-review">
                                	<h3><?php esc_html_e( 'Help with You review', 'creativityarchitect' ); ?></h3>
                                	<p><?php esc_html_e( 'If You like creativityarchitect theme, show it to the world with Your review. Your feedback helps a lot.', 'creativityarchitect' ); ?></p>
                                    <a href="<?php echo esc_url(creativityarchitect_WORDPRESS_REVIEW); ?>" class="wpkoi-admin-button" target="_blank"><?php esc_html_e( 'Add my review', 'creativityarchitect' ); ?></a>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'creativityarchitect_admin_errors' ) ) {
	add_action( 'admin_notices', 'creativityarchitect_admin_errors' );
	/**
	 * Add our admin notices
	 *
	 */
	function creativityarchitect_admin_errors() {
		$screen = get_current_screen();

		if ( 'appearance_page_creativityarchitect-options' !== $screen->base ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) && 'true' == $_GET['settings-updated'] ) {
			 add_settings_error( 'creativityarchitect-notices', 'true', esc_html__( 'Settings saved.', 'creativityarchitect' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'imported' == $_GET['status'] ) {
			 add_settings_error( 'creativityarchitect-notices', 'imported', esc_html__( 'Import successful.', 'creativityarchitect' ), 'updated' );
		}

		if ( isset( $_GET['status'] ) && 'reset' == $_GET['status'] ) {
			 add_settings_error( 'creativityarchitect-notices', 'reset', esc_html__( 'Settings removed.', 'creativityarchitect' ), 'updated' );
		}

		settings_errors( 'creativityarchitect-notices' );
	}
}
