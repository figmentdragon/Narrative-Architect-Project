<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package creativity_architect
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<div id="wrapper-sidebar">
  <aside id="secondary" class="widget-area">
    <div id="wrapper-nav">
      <nav id="site-navigation" class="main-navigation">
        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'creativityarchitect' ); ?></button>
        <?php wp_nav_menu(
          array(
            'theme_location' => 'menu-1',
            'menu_id'        => 'primary-menu',
          )
        ); ?>
      </nav><!-- #site-navigation -->
    </div><!--wrapper-nav-->
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
  </aside><!-- #secondary -->
</div>
