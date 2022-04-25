<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package creativity
 */
?>
</main>
<?php if(!is_page_template('home.php')){ ?>
    <div class="site-info">
        &copy; <?php echo esc_html(date('Y'))." "; bloginfo('name'); ?> | <?php esc_html_e('WordPress Theme','creativity'); ?> : <a href="<?php echo esc_url('https://accesspressthemes.com/wordpress-themes/scroll-me/'); ?>" title="AccessPress Themes" target="_blank"><?php esc_html_e('creativity','creativity'); ?></a>
    </div><!-- .site-info -->
<?php } ?>
</div><!-- #content -->

<footer id="colophon" class="site-footer">
    <div class="container">
        <div class="toogle-wrap">
            <div id="toggle" >
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>
        </div>

        <nav id="site-navigation" class="main-navigation clearfix">
            <?php wp_nav_menu(array('theme_location' => 'primary', 'container' => NULL, 'menu_class'=>'clearfix', 'fallback_cb' => false, 'walker' => new creativity_Menu_Attibute_Walker() )); ?>
        </nav><!-- #site-navigation -->
    </div>
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
