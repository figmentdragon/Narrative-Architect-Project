<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package creativity_architect
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" />

  <title>
  	<?php bloginfo('name'); ?> |
  	<?php is_front_page() ? bloginfo('description') : wp_title(''); ?>
  </title>

	<link rel="profile" href="https://gmpg.org/xfn/11">
  <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
  	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
  <?php endif; ?>
  <script src="https://kit.fontawesome.com/a52bc36f18.js" crossorigin="anonymous"></script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'creativityarchitect' ); ?></a>

  <div id="wrapper-header">

	   <header id="masthead" class="site-header">

       <hgroup>
         <div class="site-branding">
           <?php the_custom_logo(); if ( is_front_page() && is_home() ) : ?>
             <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
           <?php else : ?>
             <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
           <?php endif; ?>
         </div>                                                                                                                 <!-- .site-branding -->
       </hgroup>
     </header>                                                                                                                  <!-- #masthead -->
  </div>
    <div id="wrapper" class="site">
