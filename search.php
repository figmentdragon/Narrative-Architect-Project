<?php
/**
* Template Name: Search
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*
 * The template for displaying search results pages.
*
* @link https://codex.wordpress.org/Creating_an_Error_404_Page
*
*/
get_header(); ?>

	<div class="container clearfix">
		<div id="primary" class="content-area">
			<!-- section -->
			<section>
					<header class="page-header">

					<h1><span><?php echo sprintf( __( '%s Search Results for ', 'creativity' ), $wp_query->found_posts ); echo get_search_query(); ?></span></h1>
					</header><!-- .page-header -->
					<?php if ( have_posts() ) : ?>
						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );
							?>
						<?php endwhile; ?>

						<?php the_posts_navigation(); ?>


					<?php else : ?>

						<?php get_template_part( 'template-parts/content', 'none' ); ?>

					<?php endif; ?>
			<?php get_template_part( 'pagination' ); ?>
		</section>
		</div><!-- #primary -->

	</div>

<?php get_footer();
