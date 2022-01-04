<?php

add_theme_support( 'starter-content', array(
		 
    // Twenty Seventeen
		'nav_menus' => array(
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'page_home',
					'page_about',
					'page_blog',
					'page_contact',
          
          // Our Custom Services page
					'page_service' => array(
						'type' => 'post_type',
						'object' => 'page',
						'object_id' => '{{services}}',
					),
				),
			),
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	) );