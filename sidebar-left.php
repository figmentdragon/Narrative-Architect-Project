<?php
/**
 * The Left sidebar containing the main widget area.
 *
 * @package creativity
 */

if ( ! is_active_sidebar( 'creativity-sidebar-left' ) ) {
    return;
}
?>

<?php if( creativity_get_sidebar_layout() == "left_sidebar" ) : ?>
    <div id="secondary" class="widget-area">
        <?php dynamic_sidebar( 'creativity-sidebar-left' ); ?>
    </div><!-- #secondary -->
<?php endif; 