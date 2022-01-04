<?php

require_once 'class.php';

new WordPress_Custom_Status( array(
	'post_type' => array( 'post', 'page' ),
	'slug' => 'custom_status',
	'label' => _x( 'Custom Status', 'wp' ),
	'action' => 'update',
	'label_count' => _n_noop( 'Custom <span class="count">(%s)</span>', 'Custom <span class="count">(%s)</span>' ),
));
