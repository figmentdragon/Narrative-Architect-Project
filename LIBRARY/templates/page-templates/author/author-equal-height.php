<?php

/**
 * Category Template: Equal Height
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package theme
 */

get_header();
?>
<div id="content" class="site-content container py-5 mt-5">
  <div id="primary" class="content-area">

    <!-- Hook to add something nice -->
    <?php bs_after_primary(); ?>

    <main id="main" class="site-main">

      <!-- Author & Bio -->
      <header class="page-header mb-4 d-flex">
        <div class="flex-shrink-0 me-3">
          <?php echo get_avatar(get_the_author_meta('email'), '80', $default = '', $alt = '', array('class' => array('img-thumbnail rounded-circle'))); ?>
        </div>
        <div class="author-bio">
          <h1><?php the_author(); ?></h1>
          <?php the_author_meta('description'); ?>
        </div>
      </header>

      <div class="row">
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : the_post(); ?>

            <div class="col-md-6 col-lg-4 col-xxl-3 mb-4">

              <div class="card h-100">

                <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>

                <div class="card-body d-flex flex-column">

                  <?php theme_category_badge(); ?>

                  <h2 class="blog-post-title">
                    <a href="<?php the_permalink(); ?>">
                      <?php the_title(); ?>
                    </a>
                  </h2>

                  <?php if ('post' === get_post_type()) : ?>

                    <small class="muted-color mb-2">
                      <?php
                      theme_date();
                      theme_author();
                      theme_comments();
                      theme_edit();
                      ?>
                    </small>

                  <?php endif; ?>

                  <div class="card-text">
                    <?php the_excerpt(); ?>
                  </div>

                  <div class="mt-auto">
                    <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more »', 'theme'); ?></a>
                  </div>

                  <?php theme_tags(); ?>

                </div><!-- card-body -->

              </div><!-- card -->

            </div><!-- col -->

          <?php endwhile; ?>
        <?php endif; ?>

      </div><!-- row -->

      <!-- Pagination -->
      <div>
        <?php theme_pagination(); ?>
      </div>

    </main><!-- #main -->

  </div><!-- #primary -->
</div><!-- #content -->
<?php
get_footer();
