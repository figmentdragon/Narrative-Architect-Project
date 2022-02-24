<?php
/**
 * The template for displaying featured content
 *
 * @package THEMENAME
 */

$enable_content = get_theme_mod( 'THEMENAME_featured_content_option', 'disabled' );

if ( ! THEMENAME_check_section( $enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}

$THEMENAME_title = get_option( 'featured_content_title', esc_html__( 'Contents', 'THEMENAME' ) );
$sub_title    = get_option( 'featured_content_content' );


if( !$THEMENAME_title && !$sub_title ) {
	$classes[] = 'no-section-heading';
}
?>

<div id="featured-content-section" class="section featured-content layout-three">
	<div class="wrapper">
		<?php if ( $THEMENAME_title || $sub_title ) : ?>
			<div class="section-heading-wrapper featured-section-headline">
				<?php if ( $THEMENAME_title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo wp_kses_post( $THEMENAME_title ); ?></h2>
					</div><!-- .section-title-wrapper -->
				<?php endif; ?>

				<?php if ( $sub_title ) : ?>
					<div class="section-description">
						<p><?php echo wp_kses_post( $sub_title ); ?></p>
					</div><!-- .section-description-wrapper -->
				<?php endif; ?>
			</div><!-- .section-heading-wrap -->
		<?php endif; ?>

		<div class="section-content-wrapper featured-content-wrapper layout-three">
			<?php get_template_part( 'template-parts/featured-content/post-types-featured' ); ?>
		</div><!-- .section-content-wrap -->
	</div><!-- .wrapper -->
</div><!-- #featured-content-section -->
