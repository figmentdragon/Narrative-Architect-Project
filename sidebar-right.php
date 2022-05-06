<?php
/**
 * The right sidebar containing the main widget area.
 *
 * @package creativity
 */

if ( ! is_active_sidebar( 'creativity-sidebar-right' ) ) {
    return;
}
?>
<?php
	$woo_page = creativity_is_realy_woocommerce_page();
?>
<?php if( creativity_get_sidebar_layout() == "right_sidebar" || $woo_page ) : ?>
    <div id="secondary" class="widget-area">
        <?php dynamic_sidebar( 'creativity-sidebar-right' ); ?>
    </div><!-- #secondary -->
<?php endif; 