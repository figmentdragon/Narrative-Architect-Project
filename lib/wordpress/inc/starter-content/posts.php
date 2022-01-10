<?php

add_theme_support( 'starter-content', array(
		 // ...
    // Twenty Seventeen
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
      // Custom added page Services
			'services' => array(
				'post_type' => 'page',
				'post_title' => 'Services',
				'post_content' => 'About services'
			),
		),
  // ...
 );