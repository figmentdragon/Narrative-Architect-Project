<?php
/**
* Template Name: Archive
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*
* The template for displaying 404 pages (not found)
*
* @link https://codex.wordpress.org/Creating_an_Error_404_Page
*
*/

get_header();
?>

<div class="container clearfix no_sidebar">
	<div id="primary" class="content-area">
		<section class="error-404 not-found">
			<article id="post-404">
				<header class="entry-header">

					<h1 class="entry-title">
						<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'creativity' ); ?>
					</h1>
					<h2>
						<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Return home?', 'creativity' ); ?></a>
					</h2>
				</header><!-- .page-header -->

			<div class="error-404-msg">400<span>Error</span></div>
		</article><!-- /article -->
		</section><!-- .error-404 -->

	</div>
</div>

<?php get_footer(); ?>
