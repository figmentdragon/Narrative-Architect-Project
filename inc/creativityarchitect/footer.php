<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package creativity_architect
 */
?>
</div><!--#wrapper-->

<div id="wrapper-footer">
	<footer id="colophon" class="site-footer container-fluid">
		<small class="site-info">
      <?php do_action( ' creativityarchitect_copyright' ); ?>
		</small><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!--#wrapper-footer-->

<?php wp_footer(); ?>

</body>
</html>
