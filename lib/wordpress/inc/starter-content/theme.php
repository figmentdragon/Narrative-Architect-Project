<?php

add_theme_support( 'starter-content', array(
  // ...
  'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
    
      // Custom setting
			'page_layout' => 'one-column'
		),
  // ...
);