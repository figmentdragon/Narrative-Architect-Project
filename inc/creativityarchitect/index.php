<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package creativity_architect
 */

get_header();
?>

  <main id="primary" class="site-main">
    <div class="wrapper-title">
      <?php $creativityarchitect_description = get_bloginfo( 'description', 'display' ); ?>
    <?php if ( is_front_page() && is_home() ) : ?>
      <h4 class="site-description"><a href="<?php the_permalink(); ?>">
        <?php echo $creativityarchitect_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a></h4>
      <?php else: ?>
        <h2 class="page-title"><?php the_title(); ?></a></h2>
      <?php endif; ?>
    </div>

    <?php if ( have_posts() ) : ?>

        <article>
          <?php while ( have_posts() ) : the_post(); ?>
              <h4><a href="<?php the_permalink(); ?>"><?php single_post_title('Current post: ', TRUE); ?></a></h4>
            <?php the_content(); ?>
          <?php endwhile ?>
        </article>
      <?php endif; ?>

	</main><!-- #main -->
<?php
get_sidebar();
get_footer();
