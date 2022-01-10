<?php

 add_theme_support( 'starter-content', array(
  // Content Section for Widgets
  'widgets' => array(
    // Sidebar
    'sidebar-1' => array( 
	// Widget ID
        'my_text' => array(
		// Widget $id -> set when creating a Widget Class
        	'text' , 
        	// Widget $instance -> settings 
		array(
		  'title' => 'My Title',
		  'text'  => 'My Text'
		)
	)
    )
  ),
   
  // Content Section for Posts/Pages/CPT
  'posts' => array(
	// Post Symbol -> for internal use
	'home' => array(
		'post_type' => 'page', 
		'post_title' => _x( 'Home', 'Theme starter content' ),
		'post_content' => _x( 'Welcome to your site! This is your homepage, which is what most visitors will see when they come to your site for the first time.', 'Theme starter content' ),
	),
  )
 ));