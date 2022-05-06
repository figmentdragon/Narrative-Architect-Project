<?php
/**
* Template Name: Page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*
* The template for displaying all pages.
*
* @link https://codex.wordpress.org/Creating_an_Error_404_Page
*
*/
get_header(); ?>

	<div class="container clearfix">
		<div id="primary" class="content-area">
			<!-- section -->
			<section>
							<h1><?php the_title(); ?></h1>
			<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_content(); ?>
				<?php comments_template( '', true ); // Remove if you don't want comments. ?>

				<br class="clear">
				<?php edit_post_link(); ?>

			</article>
			<!-- /article -->


				<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<article>

					<h2><?php esc_html_e( 'Sorry, nothing to display.', 'creativity' ); ?></h2>

				</article>
			<?php endwhile; // End of the loop. ?>
		</section>
		</div><!-- #primary -->

		<?php get_sidebar('left'); ?>
		<?php get_sidebar('right'); ?>
	</div>

<?php get_footer();
