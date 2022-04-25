<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package _tk
 */

if ( ! function_exists( 'creativityarchitect_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function creativityarchitect_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', '_tk' ); ?></h1>
		<ul class="pager">

		<?php if ( is_single() ) : // navigation links for single posts ?>

			<?php previous_post_link( '<li class="nav-previous previous">%link</li>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', '_tk' ) . '</span> %title' ); ?>
			<?php next_post_link( '<li class="nav-next next">%link</li>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', '_tk' ) . '</span>' ); ?>

		<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

			<?php if ( get_next_posts_link() ) : ?>
			<li class="nav-previous previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', '_tk' ) ); ?></li>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<li class="nav-next next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', '_tk' ) ); ?></li>
			<?php endif; ?>

		<?php endif; ?>

		</ul>
	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // creativityarchitect_content_nav

if ( ! function_exists( 'creativityarchitect_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function creativityarchitect_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media' ); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', '_tk' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', '_tk' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body media">
			<a class="pull-left" href="#">
				<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</a>

			<div class="media-body">
				<div class="media-body-wrap panel panel-default">

					<div class="panel-heading">
						<h5 class="media-heading"><?php printf( __( '%s <span class="says">says:</span>', '_tk' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></h5>
						<div class="comment-meta">
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<time datetime="<?php comment_time( 'c' ); ?>">
									<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', '_tk' ), get_comment_date(), get_comment_time() ); ?>
								</time>
							</a>
							<?php edit_comment_link( __( '<span style="margin-left: 5px;" class="glyphicon glyphicon-edit"></span> Edit', '_tk' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					</div>

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', '_tk' ); ?></p>
					<?php endif; ?>

					<div class="comment-content panel-body">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->

					<?php comment_reply_link(
						array_merge(
							$args, array(
								'add_below' => 'div-comment',
								'depth' 	=> $depth,
								'max_depth' => $args['max_depth'],
								'before' 	=> '<footer class="reply comment-reply panel-footer">',
								'after' 	=> '</footer><!-- .reply -->'
							)
						)
					); ?>

				</div>
			</div><!-- .media-body -->

		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for creativityarchitect_comment()

if ( ! function_exists( 'creativityarchitect_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 */
function creativityarchitect_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'creativityarchitect_attachment_size', array( 1200, 1200 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the
	 * URL of the next adjacent image in a gallery, or the first image (if
	 * we're looking at the last image in a gallery), or, in a gallery of one,
	 * just the link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'creativityarchitect_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function creativityarchitect_posted_on() {
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
			esc_html_x( 'Posted on %s', 'post date', 'creativityarchitect' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'creativityarchitect_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function creativityarchitect_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'creativityarchitect' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'creativityarchitect_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function creativityarchitect_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'creativityarchitect' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'creativityarchitect' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'creativityarchitect' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'creativityarchitect' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'creativityarchitect' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'creativityarchitect' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'creativityarchitect_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function creativityarchitect_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

/**
 * Returns true if a blog has more than 1 category
 */
function creativityarchitect_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so creativityarchitect_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so creativityarchitect_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in creativityarchitect_categorized_blog
 */
function creativityarchitect_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'creativityarchitect_category_transient_flusher' );
add_action( 'save_post',     'creativityarchitect_category_transient_flusher' );


// _tk Bootstrap pagination function
// original: http://fellowtuts.com/wordpress/bootstrap-3-pagination-in-wordpress/
/**
 *
 * @global int $paged
 * @global type $wp_query
 * @param int $pages
 * @param type $range
 */
function creativityarchitect_pagination() {
    global $paged, $wp_query;

    if (empty($paged)) {
        $paged = 1;
    }

    $pages = $wp_query->max_num_pages;
    if (!$pages) {
        $pages = 1;
    }

    if (1 != $pages):

        $input_width = strlen((string)$pages) + 3;
?>
<div class="text-center">
    <nav>
        <ul class="pagination">
            <li class="disabled hidden-xs">
                <span>
                    <span aria-hidden="true"><?php _e('Page', '_tk'); ?> <?php echo $paged; ?> <?php _e('of', '_tk'); ?> <?php echo $pages; ?></span>
                </span>
            </li>
            <li><a href="<?php echo get_pagenum_link(1); ?>" aria-label="First">&laquo;<span class="hidden-xs"> <?php _e('First', '_tk'); ?></span></a></li>

            <?php if ($paged == 1): ?>
            <li class="disabled"><span>&lsaquo;<span class="hidden-xs aria-hidden"> <?php _e('Previous', '_tk'); ?></span></span></li>
            <?php else: ?>
                <li><a href="<?php echo get_pagenum_link($paged-1); ?>" aria-label="Previous">&lsaquo;<span class="hidden-xs"> <?php _e('Previous', '_tk'); ?></span></a></li>
            <?php endif; ?>

            <?php $start_page = min(max($paged - 2, 1), max($pages - 4, 1)); ?>
            <?php $end_page   = min(max($paged + 2, 5), $pages); ?>

            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <?php if ($paged == $i): ?>
                    <li class="active"><span><?php echo $i; ?><span class="sr-only">(current)</span></span></li>
                <?php else: ?>
                    <li><a href="<?php echo get_pagenum_link($i); ?>"><?php echo $i; ?></a></li>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($paged == $pages): ?>
                <li class="disabled"><span><span class="hidden-xs aria-hidden"><?php _e('Next', '_tk'); ?> </span>&rsaquo;</span></li>
            <?php else: ?>
                <li><a href="<?php echo get_pagenum_link($paged+1); ?>" aria-label="Next"><span class="hidden-xs"><?php _e('Next', '_tk'); ?> </span>&rsaquo;</a></li>
            <?php endif; ?>

            <li><a href="<?php echo get_pagenum_link($pages); ?>" aria-label='Last'><span class='hidden-xs'><?php _e('Last', '_tk'); ?> </span>&raquo;</a></li>
            <li>
                <form method="get" id="tk-pagination" class="tk-page-nav">
                    <div class="input-group">
                        <input oninput="if(!jQuery(this)[0].checkValidity()) {jQuery('#tk-pagination').find(':submit').click();};" type="number" name="paged" min="1" max="<?php echo $pages; ?>" value="<?php echo $paged; ?>" class="form-control text-right" style="width: <?php echo $input_width; ?>em;">
                        <span class="input-group-btn">
                            <input type="submit" value="<?php _e('Go to', '_tk'); ?>" class="btn btn-success">
                        </span>
                      </div>
                </form>
            </li>
        </ul>
    </nav>
</div>
<?php
    endif;
}

/**
 * creativityarchitect_link_pages()
 * Creates bootstraped pagination for paginated posts
 *
 */
function creativityarchitect_link_pages() {
    global $numpages, $page, $post;

    if (1 != $numpages):
        $input_width = strlen((string)$numpages) + 3;
?>
<div class="text-center">
    <nav>
        <ul class="pagination">
            <li class="disabled hidden-xs">
                <span>
                    <span aria-hidden="true"><?php _e('Page', '_tk'); ?> <?php echo $page; ?> <?php _e('of', '_tk'); ?> <?php echo $numpages; ?></span>
                </span>
            </li>
            <li><?php echo creativityarchitect_link_page(1, 'First'); ?>&laquo;<span class="hidden-xs"> <?php _e('First', '_tk'); ?></span></a></li>
            <?php if ($page == 1): ?>
                <li class="disabled"><span>&lsaquo;<span class="hidden-xs aria-hidden"> <?php _e('Previous', '_tk'); ?></span></span></li>
            <?php else: ?>
                <li><?php echo creativityarchitect_link_page($page - 1, 'Previous'); ?>&lsaquo;<span class="hidden-xs"> <?php _e('Previous', '_tk'); ?></span></a></li>
            <?php endif; ?>

            <?php $start_page = min(max($page - 2, 1), max($numpages - 4, 1)); ?>
            <?php $end_page   = min(max($page + 2, 5), $numpages); ?>

            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <?php if ($page == $i): ?>
                    <li class="active">
                        <span><?php echo $i; ?><span class="sr-only">(current)</span></span>
                    </li>
                <?php else: ?>
                    <li><?php echo creativityarchitect_link_page($i) . $i . '</a>'; ?></li>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page == $numpages): ?>
                <li class="disabled"><span><span class="hidden-xs aria-hidden"><?php _e('Next', '_tk'); ?> </span>&rsaquo;</span></li>
            <?php else: ?>
                <li><?php echo creativityarchitect_link_page($page + 1, 'Next'); ?><span class="hidden-xs"><?php _e('Next', '_tk'); ?> </span>&rsaquo;</a></li>
            <?php endif; ?>
            <li><?php echo creativityarchitect_link_page($numpages, 'Last'); ?><span class="hidden-xs"><?php _e('Last', '_tk'); ?> </span>&raquo;</a></li>
            <li>
                <form action="<?php echo get_permalink($post->ID); ?>" method="get" class="tk-page-nav" id="tk-paging-<?php echo $post->ID; ?>">
                    <div class="input-group">
                        <input oninput="if(!jQuery(this)[0].checkValidity()) {jQuery('#tk-paging-<?php echo $post->ID; ?>').find(':submit').click();};" type="number" name="page" min="1" max="<?php echo $numpages; ?>" value="<?php echo $page; ?>" class="form-control text-right" style="width: <?php echo $input_width; ?>em;">
                        <span class="input-group-btn">
                            <input type="submit" value="<?php _e('Go to', '_tk'); ?>" class="btn btn-success">
                        </span>
                      </div>
                </form>
            </li>
        </ul>
    </nav>
</div>
<?php
    endif;
}

/**
 * creativityarchitect_link_page
 *
 * Customized _wp_link_page from wp-includes/post_template.php
 *
 * @global WP_Rewrite $wp_rewrite
 * @global int $page
 * @global int $numpages
 * @param int $i
 * @param string $aria_label
 * @param string $class
 * @return string
 */
function creativityarchitect_link_page($i, $aria_label = '', $class = '') {
    global $wp_rewrite, $page, $numpages;
    $post       = get_post();
    $query_args = array();

    if (1 == $i) {
        $url = get_permalink();
    } else {
        if ('' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')))
            $url = add_query_arg('page', $i, get_permalink());
        elseif ('page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID)
            $url = trailingslashit(get_permalink()) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
        else
            $url = trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
    }

    if (is_preview()) {

        if (( 'draft' !== $post->post_status ) && isset($_GET['preview_id'], $_GET['preview_nonce'])) {
            $query_args['preview_id']    = wp_unslash($_GET['preview_id']);
            $query_args['preview_nonce'] = wp_unslash($_GET['preview_nonce']);
        }

        $url = get_preview_post_link($post, $query_args, $url);
    }

    if ($class != '') {
        $class = ' class="' . $class . '"';
    }
    if ($aria_label != '') {
        $aria_label = ' aria-label="' . $aria_label . '"';
    }
    return '<a href="' . esc_url($url) . '"' . $aria_label . $class . '>';
}

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
