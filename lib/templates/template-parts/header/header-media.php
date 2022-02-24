<?php
/**
 * Display Header Media
 *
 * @package THEMENAME
 */

if ( 'disable' === get_theme_mod( 'THEMENAME_header_media_option', 'entire-site' ) ) {
	return;
}

$header_image = THEMENAME_featured_overall_image();

if ( 'disable' !== $header_image || $enable_slider ) {
	if ( 'disable' !== $header_image ) {
		$classes[] = 'has-header-media';
	}

	$classes[] = 'absolute-header';
}

$header_media_text = has_header_media_text();

if ( ( ( is_header_video_active() && has_header_video() ) || 'disable' !== $header_image ) ) :
?>
<div class="custom-header header-media">
	<div class="wrapper">
		<div class="custom-header-media">
			<?php
			if ( is_header_video_active() && has_header_video() ) {
				the_custom_header_markup();
			} elseif ( 'disable' !== $header_image ) {
				echo '<div id="wp-custom-header" class="wp-custom-header"><img src="' . esc_url( $header_image ) . '"/></div>	';
			}
			?>
			<?php THEMENAME_header_media_text(); ?>

			<?php if ( get_theme_mod( 'THEMENAME_header_media_scroll_down', 1 ) ) : ?>
					<div class="scroll-down">
						<span><?php esc_html_e( 'Scroll', 'THEMENAME' ); ?></span>
						<?php echo THEMENAME_get_svg( array( 'icon' => 'angle-down' ) ); ?>
					</div><!-- .scroll-down -->
			<?php endif; ?>

		</div>
	</div><!-- .wrapper -->
	<div class="custom-header-overlay"></div><!-- .custom-header-overlay -->
</div><!-- .custom-header -->
<?php endif; ?>
