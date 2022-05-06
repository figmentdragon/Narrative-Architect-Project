<?php
/**
* Template Name: Single
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*
 * The template for displaying all single posts.
*
* @link https://codex.wordpress.org/Creating_an_Error_404_Page
*
*/

get_header(); ?>

	<div class="container clearfix">
		<div id="primary" class="content-area">
			<!-- section -->
			<section>

			<?php if ( have_posts() ) : while (have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'single' ); ?>
				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<!-- post thumbnail -->
					<?php if ( has_post_thumbnail() ) : // Check if Thumbnail exists. ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail(); // Fullsize image for the single post. ?>
						</a>
					<?php endif; ?>
					<!-- /post thumbnail -->

					<!-- post title -->
					<h1>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</h1>
					<!-- /post title -->

					<!-- post details -->
					<span class="date">
						<time datetime="<?php the_time( 'Y-m-d' ); ?> <?php the_time( 'H:i' ); ?>">
							<?php the_date(); ?> <?php the_time(); ?>
						</time>
					</span>
					<span class="author"><?php esc_html_e( 'Published by', 'creativity' ); ?> <?php the_author_posts_link(); ?></span>
					<span class="comments"><?php if ( comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'creativity' ), __( '1 Comment', 'creativity' ), __( '% Comments', 'creativity' ) ); ?></span>
					<!-- /post details -->

					<?php the_content(); // Dynamic Content. ?>

					<?php the_tags( __( 'Tags: ', 'creativity' ), ', ', '<br>' ); // Separated by commas with a line break at the end. ?>

					<p><?php esc_html_e( 'Categorised in: ', 'creativity' ); the_category( ', ' ); // Separated by commas. ?></p>

					<p><?php esc_html_e( 'This post was written by ', 'creativity' ); the_author(); ?></p>

					<?php edit_post_link(); // Always handy to have Edit Post Links available. ?>

					<?php comments_template(); ?>

				</article>
				<!-- /article -->

				<?php endwhile; ?>

				<?php else : ?>

				<!-- article -->
				<article>

					<h1><?php esc_html_e( 'Sorry, nothing to display.', 'creativity' ); ?></h1>

				</article>
				<!-- /article -->

				<?php endif; ?>

				</section>

				<?php creativity_post_navigation(); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</div><!-- #primary -->

		<?php get_sidebar('left'); ?>
		<?php get_sidebar('right'); ?>
	</div>

<?php get_footer();
