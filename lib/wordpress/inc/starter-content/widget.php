<?php

add_theme_support( 'starter-content', array(
		'widgets' => array(
			'sidebar-1' => array(
        'text_world' => array(
          'text',
          array(
            'title' => 'Hello World',
            'text'  => 'Hello Widget',
            )
          ),
				'text_business_info',
				'search',
				'text_about',
			),
      // ...
);