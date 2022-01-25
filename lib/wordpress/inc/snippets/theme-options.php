<?php

/**
 * Theme Options
 * Available in WP Backend through Design > Customize
 *
 * use get_theme_mod('option_name') to retrieve options
 *
 */

namespace Roots\Sage\Init;

function architecture_customize_register($wp_customize)
{
  /**
   * Project Settings
   */

  // first declare settings
  $wp_customize->add_setting(
    'architecture_projects_page_id',
    [
      'default'   => 0,
      'transport' => 'refresh',
    ]
  );

  $wp_customize->add_setting(
    'architecture_social_fb_url',
    [
      'default'   => 0,
      'transport' => 'refresh',
    ]
  );

  $wp_customize->add_setting(
    'architecture_social_xing_url',
    [
      'default'   => 0,
      'transport' => 'refresh',
    ]
  );

  $wp_customize->add_setting(
    'architecture_social_linkedin_url',
    [
      'default'   => 0,
      'transport' => 'refresh',
    ]
  );

  // declare sections
  $wp_customize->add_section(
    'architecture_projects_section',
    [
      'title'    => __('Projects', 'architecture'),
      'priority' => 30,
    ]
  );

  $wp_customize->add_section(
    'architecture_social_section',
    [
      'title'    => __('Social Media', 'architecture'),
      'priority' => 30,
    ]
  );

  // add control elements to sections
  $wp_customize->add_control(
    new \WP_Customize_Control(
      $wp_customize,
      'architecture_projects_page_id',
      [
        'label'    => __('Side "Project":', 'architecture'),
        'section'  => 'architecture_projects_section',
        'settings' => 'architecture_projects_page_id',
        'type'     => 'dropdown-pages',
      ]
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Control(
      $wp_customize,
      'architecture_social_fb_url',
      [
        'label'    => __('URL Facebook', 'architecture'),
        'section'  => 'architecture_social_section',
        'settings' => 'architecture_social_fb_url',
        'type'     => 'text',
      ]
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Control(
      $wp_customize,
      'architecture_social_xing_url',
      [
        'label'    => __('URL XING', 'architecture'),
        'section'  => 'architecture_social_section',
        'settings' => 'architecture_social_xing_url',
        'type'     => 'text',
      ]
    )
  );

  $wp_customize->add_control(
    new \WP_Customize_Control(
      $wp_customize,
      'architecture_social_linkedin_url',
      [
        'label'    => __('URL LinkedIn', 'architecture'),
        'section'  => 'architecture_social_section',
        'settings' => 'architecture_social_linkedin_url',
        'type'     => 'text',
      ]
    )
  );
}

add_action('customize_register', __NAMESPACE__.'\\architecture_customize_register');
