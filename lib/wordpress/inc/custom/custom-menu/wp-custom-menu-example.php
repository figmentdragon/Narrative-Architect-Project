<?php

/**
 * Include that in a theme or plugin
 * Be sure to have the right path to the file
 */
require_once 'wp_custom_menu.php';

$customWPMenu = new WordPressMenu( array(
			'slug' => 'wpmenu',
			'title' => 'WP Menu',
			'desc' => 'Settings for theme custom WordPress Menu',
			'icon' => 'dashicons-welcome-widgets-menus',
			'position' => 99,
		));

$customWPMenu->add_field(array(
	'name' => 'text',
	'title' => 'Text Input',
	'desc' => 'Input Description',
	));

$customWPMenu->add_field(array(
	'name' => 'checkbox',
	'title' => 'Checkbox Example',
	'desc' => 'Check it to wake it',
	'type' => 'checkbox'));

// Creating tab with our custom wordpress menu
$customTab = new WordPressMenuTab( 
	array(
		'slug' => 'example_tab', 
		'title' => 'Example Tab' ), 
	$customWPMenu );

$customTab->add_field(array(
	'name' => 'select',
	'title' => 'Select Example',
	'type' => 'select',
	'options' => array(
		'one' => 'Option one',
		'two' => 'Option two' ) ) );

// Creating second menu
$customWPSubMenu = new WordPressSubMenu( array(
			'slug' => 'wpsubmenu',
			'title' => 'WP SubMenu',
			'desc' => 'Settings for custom WordPress SubMenu',
		),
		$customWPMenu);