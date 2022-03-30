<?php
/**
 * Extra functions for this theme.
 *
 * @package THEMENAE
 */

function page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
		return $args;
	}
}

if ( ! is_admin() ) {
	function new_excerpt_length( $length ) {
		return 70;
	}
	function read_more_custom_excerpt( $text ) {
		if ( strpos( $text, '[&hellip;]' ) ) {
				$excerpt = str_replace( '[&hellip;]', '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'lite' ) . '</a>', $text );
		} else {
			$excerpt = $text . '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'THEMENAE' ) . '</a>';
		}
		return $excerpt;
	}
  function excerpt_read_more_link( $more ) {
    if ( !is_admin() ) {
      global $post;
      return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'TheCreativityArchitect' ), '<span class="screen-reader-text">  ' . esc_html ( get_the_title() ) . '</span>' ) . '</a>';
    }
  }
  function read_more_link() {
    if ( !is_admin() ) {
      return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'TheCreativityArchitect' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
    }
  }
}

function nav_description( $item_output, $item, $depth, $args ) {
	if ( ! empty( $item->description ) ) {
		$item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
	}
	return $item_output;
}

function admin_style() {
	echo '<style>
	.notice {position: relative;}
	a.notice-dismiss {text-decoration:none;}
	</style>';
}

function queryvars( $qvars ) {
	$qvars[] = 'tk'; // token key for editing previously made stuff
	$qvars[] = 'wid'; // post id for editing
	$qvars[] = 'random'; // random flag
	$qvars[] = 'elink'; // edit link flag
	$qvars[] =  'ispre'; // another preview flag

	return $qvars;
}

function rewrite_rules() {
	// for sending to random item
   add_rewrite_rule('random/?$', 'index.php?random=1','top');

   // for edit link requests
   add_rewrite_rule( '^get-edit-link/([^/]+)/?',  'index.php?elink=1&wid=$matches[1]','top');

}

function save_post_random_check( $post_id ) {
    // verify post is not a revision and that the post slug is "random"

    $new_post = get_post( $post_id );
    if ( ! wp_is_post_revision( $post_id ) and  $new_post->post_name == 'random' ) {
        // unhook this function to prevent infinite looping
        remove_action( 'save_post', 'save_post_random_check' );

        // update the post slug
        wp_update_post( array(
            'ID' => $post_id,
            'post_name' => 'randomly' // do your thing here
        ));

        // re-hook this function
        add_action( 'save_post', 'save_post_random_check' );

    }
}

function comment_notification_recipients( $emails, $comment_id ) {
  $comment = get_comment( $comment_id );
  if ( ok_to_notify( $comment ) ) {
    $emails[] = get_post_meta(  $comment->comment_post_ID, 'wEmail', 1 );
  }
  return ( $emails );
}

function comment_notification_text( $notify_message, $comment_id ){
    // get the current comment
    $comment = get_comment( $comment_id );

    // change notification only for recipient who is the author of this an item (e.g. skip for admins)
    if ( ok_to_notify( $comment ) ) {
    	// get post data
    	$post = get_post( $comment->comment_post_ID );

		// don't modify trackbacks or pingbacks
		if ( '' == $comment->comment_type ){
			// build the new message text
			$notify_message  = sprintf( __( 'New comment on  "%s" published at "%s"' ), $post->post_title, get_bloginfo( 'name' ) ) . "\r\n\r\n----------------------------------------\r\n";
			$notify_message .= sprintf( __('Author : %1$s'), $comment->comment_author ) . "\r\n";
			$notify_message .= sprintf( __('E-mail : %s'), $comment->comment_author_email ) . "\r\n";
			$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
			$notify_message .= sprintf( __('Comment Link: %s'), get_comment_link( $comment_id ) ) . "\r\n\r\n----------------------------------------\r\n";
			$notify_message .= __('Comment: ') . "\r\n" . $comment->comment_content . "\r\n\r\n----------------------------------------\r\n\r\n";

			$notify_message .= __('See all comments: ') . "\r\n";
			$notify_message .= get_permalink($comment->comment_post_ID) . "#comments\r\n\r\n";

		}
	}

	// return the notification text
    return $notify_message;
}

function ok_to_notify( $comment ) {
	// check if theme options are set to use comments and that the post associated with comment has the notify flag activated
	return ( sort_option('allow_comments') and get_post_meta( $comment->comment_post_ID, 'wCommentNotify', 1 ) );
}
