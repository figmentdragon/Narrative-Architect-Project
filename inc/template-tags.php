<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package creativity_ architect
 */

 /**
  * Prints HTML with date information for the current post.
  *
  * @author WebDevStudios
  *
  * @param array $args Configuration args.
  */
 function creativity_post_date( $args = [] ) {

 	// Set defaults.
 	$defaults = [
 		'date_text'   => esc_html__( 'Posted on', 'creativity_architect' ),
 		'date_format' => get_option( 'date_format' ),
 	];

 	// Parse args.
 	$args = wp_parse_args( $args, $defaults );
 	?>
 	<span class="posted-on">
 		<?php echo esc_html( $args['date_text'] . ' ' ); ?>
 		<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_time( $args['date_format'] ) ); ?></time></a>
 	</span>
 	<?php
 }

 /**
  * Prints HTML with author information for the current post.
  *
  * @author WebDevStudios
  *
  * @param array $args Configuration args.
  */
 function creativity_post_author( $args = [] ) {

 	// Set defaults.
 	$defaults = [
 		'author_text' => esc_html__( 'by', 'creativity_architect' ),
 	];

 	// Parse args.
 	$args = wp_parse_args( $args, $defaults );

 	?>
 	<span class="post-author">
 		<?php echo esc_html( $args['author_text'] . ' ' ); ?>
 		<span class="author vcard">
 			<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
 		</span>
 	</span>

 	<?php
 }

if ( ! function_exists( 'creativity_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function creativity_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( '%s', 'post date', 'creativity' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'creativity_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function creativity_posted_by() {
		printf(
			'<li class="byline"><span class="postauthor">%1$s </span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></li>',
			esc_html__( 'by', 'creativity' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
endif;

/**
 * Displays the date and author of a post summary
 */
if ( ! function_exists( 'creativity_entry_meta' ) ) :

	function creativity_entry_meta() {

		echo '<ul class="post-details">' ;

			if ( false == esc_attr(get_theme_mod( 'creativity_show_summary_author', false ) ) ) {
				creativity_posted_by();
			}
			if ( false == esc_attr(get_theme_mod( 'creativity_show_summary_date', false ) ) ) {
				creativity_posted_on();
			}
			if ( false == esc_attr(get_theme_mod( 'creativity_show_summary_comments', false ) ) ) {
				creativity_comment_count();
			}
			if ( false == esc_attr(get_theme_mod( 'creativity_show_edit', false ) ) ) {
				creativity_edit_link();
			}

		echo '</ul>';
	}
endif;

/**
 * Displays the date and author of a full post
 */
if ( ! function_exists( 'creativity_single_entry_meta' ) ) :
function creativity_single_entry_meta() {

		echo '<ul class="post-details">' ;

			if ( false == esc_attr(get_theme_mod( 'creativity_show_single_author', false ) ) ) {
				creativity_posted_by();
			}
			if ( false == esc_attr(get_theme_mod( 'creativity_show_single_date', false ) ) ) {
				creativity_posted_on();
			}
			if ( false == esc_attr(get_theme_mod( 'creativity_show_single_comments', false ) ) ) {
				creativity_comment_count();
			}
			if ( false == esc_attr(get_theme_mod( 'creativity_show_edit', false ) ) ) {
				creativity_edit_link();
			}

		echo '</ul>';
	}
endif;

/**
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @author WebDevStudios
 */
function creativity_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_attr__( ', ', 'creativity_architect' ) );
		if ( $categories_list && creativity_categorized_blog() ) {

			/* translators: the post category */
			printf( '<span class="cat-links">' . esc_attr__( 'Posted in %1$s', 'creativity_architect' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_attr__( ', ', 'creativity_architect' ) );
		if ( $tags_list ) {

			/* translators: the post tags */
			printf( '<span class="tags-links">' . esc_attr__( 'Tagged %1$s', 'creativity_architect' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_attr__( 'Leave a comment', 'creativity_architect' ), esc_attr__( '1 Comment', 'creativity_architect' ), esc_attr__( '% Comments', 'creativity_architect' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'creativity_architect' ),
			wp_kses_post( get_the_title( '<span class="screen-reader-text">"', '"</span>', false ) )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

if ( ! function_exists( 'creativity_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function creativity_post_thumbnail() {

		if ( is_singular() ) :
			?>

<figure class="post-thumbnail">
    <?php the_post_thumbnail(); ?>
</figure><!-- .post-thumbnail -->

<?php
		else :
			$post_thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
			?>

<figure class="post-thumbnail">

    <a class="wp-post-image-link" href="<?php the_permalink(); ?>" rel="bookmark">

        <?php
				// Set the post thumbnail based on the blog layout and active cropped thumbnail setting
				$creativity_blog_layout = get_theme_mod( 'creativity_blog_layout', 'default' );
				switch ( esc_attr($creativity_blog_layout ) ) {

				case "large":
					// large thumbnail
					the_post_thumbnail( 'creativity-large', array(
						'alt' => the_title_attribute(
							array( 'echo' => false )
						),
					)
				);
				break;

				default:
					the_post_thumbnail( 'post-thumbnails', array(
						'alt' => the_title_attribute(
							array( 'echo' => false )
						),
					)
				);
				}
				?>
    </a>

</figure>

<?php
		endif; // End is_singular().
	}
endif;

if (! function_exists('creativity_author_outside_loop')):
	function creativity_author_outside_loop(){
		global $post;
		$author_id=$post->post_author;
		esc_html_e('&nbsp; by &nbsp;', 'creativity'). the_author_meta( 'user_nicename', $author_id );
	}
endif;

if ( ! function_exists( 'creativity_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function creativity_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<li class="comments-link">';
			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'creativity' ), get_the_title() ) );

			echo '</li>';
		}
	}
endif;

if ( ! function_exists( 'creativity_edit_link' ) ) :
	function creativity_edit_link() {
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit<span class="screen-reader-text">%s</span>', 'creativity' ),
				get_the_title()
			),
			'<li class="edit-link">',
			'</li>'
		);
	}

endif;

if ( ! function_exists( 'creativity_sticky_entry_post' ) ) :
	// Returns the sticky label
	function creativity_sticky_entry_post() {
				if ( is_sticky() && ! is_paged() ) {
					echo '<div class="featured-label">', esc_html_e('Featured', 'creativity'), '</div>';
				}
	}
endif;

if ( ! function_exists( 'creativity_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function creativity_post_thumbnail() {

		if ( is_singular() ) :
			?>

<figure class="post-thumbnail">
    <?php the_post_thumbnail(); ?>
</figure><!-- .post-thumbnail -->

<?php
		else :
			$post_thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
			?>

<figure class="post-thumbnail">

    <a class="wp-post-image-link" href="<?php the_permalink(); ?>" rel="bookmark">

        <?php
				// Set the post thumbnail based on the blog layout and active cropped thumbnail setting
				$creativity_blog_layout = get_theme_mod( 'creativity_blog_layout', 'default' );
				switch ( esc_attr($creativity_blog_layout ) ) {

				case "large":
					// large thumbnail
					the_post_thumbnail( 'creativity-large', array(
						'alt' => the_title_attribute(
							array( 'echo' => false )
						),
					)
				);
				break;

				default:
					the_post_thumbnail( 'post-thumbnails', array(
						'alt' => the_title_attribute(
							array( 'echo' => false )
						),
					)
				);
				}
				?>
    </a>

</figure>

<?php
		endif; // End is_singular().
	}
endif;

// Get the full category list for a post
if ( ! function_exists( 'creativity_categories' ) ) :
function creativity_categories() {
	echo '<p id="post-categories">', esc_html_e( 'Categories: ', 'creativity' ) .  the_category(' &bull; ') .'</p>';
	}
endif;

/**
 * Displays the post tags on single post view
 */
if ( ! function_exists( 'creativity_entry_tags' ) ) :
	function creativity_entry_tags() {
	 echo get_the_tag_list( sprintf( // WPCS: XSS OK.
	 /* translators: %s: tag item */
	 '<span>%s: ', __( 'Tags: ', 'creativity' ) ), ' &bull; ', '</span>' );
	}
endif;

/**
 * Custom comment output
 */
if ( !function_exists( 'creativity_comment' ) ) {

	function creativity_comment( $comment, $args, $depth ) {  ?>

<li <?php comment_class(); ?> id="comment-
    <?php comment_ID() ?>">
    <article class="clearfix media" itemprop="comment" itemscope="itemscope" itemtype="http://schema.org/UserComments">
        <?php echo get_avatar( $comment, 90 ); ?>
        <div class="media-body">
            <div class="comment-author">
                <p class="vcard" itemprop="creator" itemscope="itemscope" itemtype="http://schema.org/Person">
                    <cite class="fn" itemprop="name">
                        <?php comment_author_link(); ?></cite>
                    <time itemprop="commentTime" datetime="<?php comment_time( 'c' ); ?>">
                        <?php echo get_comment_date(); ?>
                    </time>
                </p>
            </div>

            <div class="comment-content" itemprop="commentText">
                <?php comment_text() ?>
                <?php if ( $comment->comment_approved == '0' ) : ?>
                <p><em class="awaiting">
                        <?php esc_html_e( 'Your comment is awaiting moderation.', 'creativity' ) ?></em></p>
                <?php endif; ?>
            </div>
            <div class="comment-reply">
                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
                <?php edit_comment_link( __( 'Edit', 'creativity'), ' &middot; ', '' ) ?>
            </div>
        </div>
    </article>
</li>

<?php }
}

/**
 * Displays pagination on the blog and archive pages
 */
if ( ! function_exists( 'creativity_blog_navigation' ) ) :

	function creativity_blog_navigation() {

		the_posts_pagination( array(
			'mid_size'  => 2,
			'prev_text' => '<span class="nav-arrow">&laquo</span><span class="screen-reader-text">' . esc_html_x( 'Previous Posts', 'pagination', 'creativity' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . esc_html_x( 'Next Posts', 'pagination', 'creativity' ) . '</span><span class="nav-arrow">&raquo;</span>',
		) );
	}
endif;

/**
 * Displays Single Post Navigation
 */
if ( ! function_exists( 'creativity_post_navigation' ) ) :

	function creativity_post_navigation() {

			the_post_navigation( array(
				'prev_text' => '<span class="nav-link-text">' . esc_html_x( 'Previous Post', 'post navigation', 'creativity' ) . '</span><h5 class="nav-entry-title">%title</h5>',
				'next_text' => '<span class="nav-link-text">' . esc_html_x( 'Next Post', 'post navigation', 'creativity' ) . '</span><h5 class="nav-entry-title">%title</h5>',
			) );
	}
endif;

/**
 * Displays Multi-page Navigation
 */
if ( ! function_exists( 'creativity_multipage_navigation' ) ) :

	function creativity_multipage_navigation() {
		wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'creativity' ),
		'after'  => '</div>',
		'link_before' => '<span class="page-wrap">',
		'link_after' => '</span>',
		) );
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Display SVG Markup.
 *
 * @author WebDevStudios
 *
 * @param array $args The parameters needed to get the SVG.
 */
function creativity_display_svg( $args = [] ) {
	$kses_defaults = wp_kses_allowed_html( 'post' );

	$svg_args = [
		'svg'   => [
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true, // <= Must be lower case!
			'color'           => true,
			'stroke-width'    => true,
		],
		'g'     => [ 'color' => true ],
		'title' => [
			'title' => true,
			'id'    => true,
		],
		'path'  => [
			'd'     => true,
			'color' => true,
		],
		'use'   => [
			'xlink:href' => true,
		],
	];

	$allowed_tags = array_merge(
		$kses_defaults,
		$svg_args
	);

	echo wp_kses(
		creativity_get_svg( $args ),
		$allowed_tags
	);
}

/**
 * Trim the title length.
 *
 * @author WebDevStudios
 *
 * @param array $args Parameters include length and more.
 *
 * @return string The title.
 */
function creativity_get_the_title( $args = [] ) {
	// Set defaults.
	$defaults = [
		'length' => 12,
		'more'   => '...',
	];

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Trim the title.
	return wp_kses_post( wp_trim_words( get_the_title( get_the_ID() ), $args['length'], $args['more'] ) );
}

/**
 * Limit the excerpt length.
 *
 * @author WebDevStudios
 *
 * @param array $args Parameters include length and more.
 *
 * @return string The excerpt.
 */
function creativity_get_the_excerpt( $args = [] ) {

	// Set defaults.
	$defaults = [
		'length' => 20,
		'more'   => '...',
		'post'   => '',
	];

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Trim the excerpt.
	return wp_trim_words( get_the_excerpt( $args['post'] ), absint( $args['length'] ), esc_html( $args['more'] ) );
}

/**
 * Echo the copyright text saved in the Customizer.
 *
 * @author WebDevStudios
 */
function creativity_display_copyright_text() {
	// Grab our customizer settings.
	$copyright_text = get_theme_mod( 'creativity_copyright_text' );

	if ( $copyright_text ) {
		echo creativity_get_the_content( do_shortcode( $copyright_text ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
	}
}

/**
 * Display the social links saved in the customizer.
 *
 * @author WebDevStudios
 */
function creativity_display_social_network_links() {
	// Create an array of our social links for ease of setup.
	// Change the order of the networks in this array to change the output order.
	$social_networks = [
		'facebook',
		'instagram',
		'linkedin',
		'twitter',
	];

	?>
	<ul class="flex social-icons menu">
		<?php
		// Loop through our network array.
		foreach ( $social_networks as $network ) :

			// Look for the social network's URL.
			$network_url = get_theme_mod( 'creativity' . $network . '_link' );

			// Only display the list item if a URL is set.
			if ( ! empty( $network_url ) ) :
				?>
				<li class="social-icon <?php echo esc_attr( $network ); ?> mr-2">
					<a href="<?php echo esc_url( $network_url ); ?>">
						<?php
						creativity_display_svg(
							[
								'icon'   => $network . '-square',
								'width'  => '24',
								'height' => '24',
							]
						);
						?>
						<span class="screen-reader-text">
						<?php
						/* translators: the social network name */
						printf( esc_attr__( 'Link to %s', 'creativity_architect' ), ucwords( esc_html( $network ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK.
						?>
						</span>
					</a>
				</li><!-- .social-icon -->
				<?php
			endif;
		endforeach;
		?>
	</ul><!-- .social-icons -->
	<?php
}

/**
 * Displays numeric pagination on archive pages.
 *
 * @author WebDevStudios
 *
 * @param array    $args  Array of params to customize output.
 * @param WP_Query $query The Query object; only passed if a custom WP_Query is used.
 */
function creativity_display_numeric_pagination( $args = [], $query = null ) {
	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}

	// Make the pagination work on custom query loops.
	$total_pages = isset( $query->max_num_pages ) ? $query->max_num_pages : 1;

	// Set defaults.
	$defaults = [
		'prev_text' => '&laquo;',
		'next_text' => '&raquo;',
		'mid_size'  => 4,
		'total'     => $total_pages,
	];

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	if ( null === paginate_links( $args ) ) {
		return;
	}
	?>

	<nav class="container pagination-container" aria-label="<?php esc_attr_e( 'numeric pagination', 'creativity_architect' ); ?>">
		<?php echo paginate_links( $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK. ?>
	</nav>

	<?php
}

/**
 * Displays the mobile menu with off-canvas background layer.
 *
 * @author WebDevStudios
 *
 * @return string An empty string if no menus are found at all.
 */
function creativity_display_mobile_menu() {
	// Bail if no mobile or primary menus are set.
	if ( ! has_nav_menu( 'mobile' ) && ! has_nav_menu( 'primary' ) ) {
		return '';
	}

	// Set a default menu location.
	$menu_location = 'primary';

	// If we have a mobile menu explicitly set, use it.
	if ( has_nav_menu( 'mobile' ) ) {
		$menu_location = 'mobile';
	}
	?>
	<div class="off-canvas-screen"></div>
	<nav class="off-canvas-container" aria-label="<?php esc_attr_e( 'Mobile Menu', 'creativity_architect' ); ?>" aria-hidden="true" tabindex="-1">
		<?php
		// Mobile menu args.
		$mobile_args = [
			'theme_location'  => $menu_location,
			'container'       => 'div',
			'container_class' => 'off-canvas-content',
			'container_id'    => '',
			'menu_id'         => 'site-mobile-menu',
			'menu_class'      => 'mobile-menu',
			'fallback_cb'     => false,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		];

		// Display the mobile menu.
		wp_nav_menu( $mobile_args );
		?>
	</nav>
	<?php
}

/**
 * Display the comments if the count is more than 0.
 *
 * @author WebDevStudios
 */
function creativity_display_comments() {
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}
