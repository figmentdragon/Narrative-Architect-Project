<?php

add_theme_support( 'starter-content', array(
		// ...
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
			// Our Custom
			'blogdescription' => 'My Awesome Blog'
		),
    // ...
 );