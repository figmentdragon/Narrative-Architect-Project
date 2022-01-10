<?php

require_once 'wp_custom_columns.php';

function render_user_by_id( $post_id, $column_key) {
	$user_id = get_post_meta( $post_id, $column_key, true );
	$userdata = get_userdata( $user_id );
	echo $userdata->user_login;
}

$columns = new WordPressColumns ( array(

		array(
			'column_key' => '_edit_last',
			'column_title' => __( 'Last Edited', 'yourtextdomain' ),
			'column_display' => 'render_user_by_id'
			),
	));

$columns->add_columns();