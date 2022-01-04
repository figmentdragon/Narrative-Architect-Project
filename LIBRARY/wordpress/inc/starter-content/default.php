<?php

$core_content = array(
		'widgets' => array(
			'text_business_info' => array( 'text', array(
				'title' => _x( 'Find Us', 'Theme starter content' ),
				'text' => join( '', array(
					'<p><strong>' . _x( 'Address', 'Theme starter content' ) . '</strong><br />',
					_x( '123 Main Street', 'Theme starter content' ) . '<br />' . _x( 'New York, NY 10001', 'Theme starter content' ) . '</p>',
					'<p><strong>' . _x( 'Hours', 'Theme starter content' ) . '</strong><br />',
					_x( 'Monday&mdash;Friday: 9:00AM&ndash;5:00PM', 'Theme starter content' ) . '<br />' . _x( 'Saturday &amp; Sunday: 11:00AM&ndash;3:00PM', 'Theme starter content' ) . '</p>'
				) ),
			) ),
			'text_about' => array( 'text', array(
				'title' => _x( 'About This Site', 'Theme starter content' ),
				'text' => _x( 'This may be a good place to introduce yourself and your site or include some credits.', 'Theme starter content' ),
			) ),
			'archives' => array( 'archives', array(
				'title' => _x( 'Archives', 'Theme starter content' ),
			) ),
			'calendar' => array( 'calendar', array(
				'title' => _x( 'Calendar', 'Theme starter content' ),
			) ),
			'categories' => array( 'categories', array(
				'title' => _x( 'Categories', 'Theme starter content' ),
			) ),
			'meta' => array( 'meta', array(
				'title' => _x( 'Meta', 'Theme starter content' ),
			) ),
			'recent-comments' => array( 'recent-comments', array(
				'title' => _x( 'Recent Comments', 'Theme starter content' ),
			) ),
			'recent-posts' => array( 'recent-posts', array(
				'title' => _x( 'Recent Posts', 'Theme starter content' ),
			) ),
			'search' => array( 'search', array(
				'title' => _x( 'Search', 'Theme starter content' ),
			) ),
		),
		'nav_menus' => array(
			'page_home' => array(
				'type' => 'post_type',
				'object' => 'page',
				'object_id' => '{{home}}',
			),
			'page_about' => array(
				'type' => 'post_type',
				'object' => 'page',
				'object_id' => '{{about}}',
			),
			'page_blog' => array(
				'type' => 'post_type',
				'object' => 'page',
				'object_id' => '{{blog}}',
			),
			'page_news' => array(
				'type' => 'post_type',
				'object' => 'page',
				'object_id' => '{{news}}',
			),
			'page_contact' => array(
				'type' => 'post_type',
				'object' => 'page',
				'object_id' => '{{contact}}',
			),

			'link_email' => array(
				'title' => _x( 'Email', 'Theme starter content' ),
				'url' => 'mailto:wordpress@example.com',
			),
			'link_facebook' => array(
				'title' => _x( 'Facebook', 'Theme starter content' ),
				'url' => 'https://www.facebook.com/wordpress',
			),
			'link_foursquare' => array(
				'title' => _x( 'Foursquare', 'Theme starter content' ),
				'url' => 'https://foursquare.com/',
			),
			'link_github' => array(
				'title' => _x( 'GitHub', 'Theme starter content' ),
				'url' => 'https://github.com/wordpress/',
			),
			'link_instagram' => array(
				'title' => _x( 'Instagram', 'Theme starter content' ),
				'url' => 'https://www.instagram.com/explore/tags/wordcamp/',
			),
			'link_linkedin' => array(
				'title' => _x( 'LinkedIn', 'Theme starter content' ),
				'url' => 'https://www.linkedin.com/company/1089783',
			),
			'link_pinterest' => array(
				'title' => _x( 'Pinterest', 'Theme starter content' ),
				'url' => 'https://www.pinterest.com/',
			),
			'link_twitter' => array(
				'title' => _x( 'Twitter', 'Theme starter content' ),
				'url' => 'https://twitter.com/wordpress',
			),
			'link_yelp' => array(
				'title' => _x( 'Yelp', 'Theme starter content' ),
				'url' => 'https://www.yelp.com',
			),
			'link_youtube' => array(
				'title' => _x( 'YouTube', 'Theme starter content' ),
				'url' => 'https://www.youtube.com/channel/UCdof4Ju7amm1chz1gi1T2ZA',
			),
		),
		'posts' => array(
			'home' => array(
				'post_type' => 'page',
				'post_title' => _x( 'Home', 'Theme starter content' ),
				'post_content' => _x( 'Welcome to your site! This is your homepage, which is what most visitors will see when they come to your site for the first time.', 'Theme starter content' ),
			),
			'about' => array(
				'post_type' => 'page',
				'post_title' => _x( 'About', 'Theme starter content' ),
				'post_content' => _x( 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.', 'Theme starter content' ),
			),
			'contact' => array(
				'post_type' => 'page',
				'post_title' => _x( 'Contact', 'Theme starter content' ),
				'post_content' => _x( 'This is a page with some basic contact information, such as an address and phone number. You might also try a plugin to add a contact form.', 'Theme starter content' ),
			),
			'blog' => array(
				'post_type' => 'page',
				'post_title' => _x( 'Blog', 'Theme starter content' ),
			),
			'news' => array(
				'post_type' => 'page',
				'post_title' => _x( 'News', 'Theme starter content' ),
			),

			'homepage-section' => array(
				'post_type' => 'page',
				'post_title' => _x( 'A homepage section', 'Theme starter content' ),
				'post_content' => _x( 'This is an example of a homepage section. Homepage sections can be any page other than the homepage itself, including the page that shows your latest blog posts.', 'Theme starter content' ),
			),
		),
	);