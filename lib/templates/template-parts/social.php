<?php
/**
 * The template for displaying social media icons
 *
 * @package THEMENAME
 */

?>
<?php if ( get_theme_mod( 'THEMENAME_facebooklink' ) || get_theme_mod( 'THEMENAME_twitterlink' ) || get_theme_mod( 'THEMENAME_pinterestlink' ) || get_theme_mod( 'THEMENAME_instagramlink' ) || get_theme_mod( 'THEMENAME_linkedinlink' ) || get_theme_mod( 'THEMENAME_youtubelink' ) || get_theme_mod( 'THEMENAME_vimeo' ) || get_theme_mod( 'THEMENAME_tumblrlink' ) || get_theme_mod( 'THEMENAME_flickrlink' ) ) : ?>
	<div class="social-icons position-absolute">
		<ul class="list-unstyled d-table mb-2">

		<?php endif; ?>
		<?php if ( get_theme_mod( 'THEMENAME_facebooklink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'THEMENAME_facebooklink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'THEMENAME_twitterlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'THEMENAME_twitterlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-twitter"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'THEMENAME_pinterestlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'THEMENAME_pinterestlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'THEMENAME_instagramlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'THEMENAME_instagramlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-instagram"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'THEMENAME_linkedinlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'THEMENAME_linkedinlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'THEMENAME_youtubelink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'THEMENAME_youtubelink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-youtube"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'THEMENAME_vimeo' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'THEMENAME_vimeo' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-vimeo-v"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'THEMENAME_tumblrlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'THEMENAME_tumblrlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-tumblr"></i></a></li>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'THEMENAME_flickrlink' ) ) : ?>
		<li><a href="<?php echo esc_url( get_theme_mod( 'THEMENAME_flickrlink' ) ); ?>" class="py-2 text-center d-block" target="_blank"><i class="fab fa-flickr"></i></a></li>
		<?php endif; ?>
		
		<?php if ( get_theme_mod( 'THEMENAME_facebooklink' ) || get_theme_mod( 'THEMENAME_twitterlink' ) || get_theme_mod( 'THEMENAME_pinterestlink' ) || get_theme_mod( 'THEMENAME_instagramlink' ) || get_theme_mod( 'THEMENAME_linkedinlink' ) || get_theme_mod( 'THEMENAME_youtubelink' ) || get_theme_mod( 'THEMENAME_vimeo' ) || get_theme_mod( 'THEMENAME_tumblrlink' ) || get_theme_mod( 'THEMENAME_flickrlink' ) ) : ?>
	</ul>
</div>
<?php endif; ?>
