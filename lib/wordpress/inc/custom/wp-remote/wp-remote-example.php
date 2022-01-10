<?php

require_once 'classes.php';

add_action( 'init', 'my_remote_get' );
function my_remote_get() {
	$remote_request = new WordPressRemoteJSON( 'https://leanpub.com/wpb3/coupons.json', array( 'body' => array("coupon_code" => "coupon-code-123456" ) ), "post" );
	$remote_request->run();
	var_dump( $remote_request->is_success() );

	$remote_request = new WordPressRemoteJSON( 'https://leanpub.com/wpb3.json' );
	$remote_request->run();
	var_dump( $remote_request->is_success() );
}