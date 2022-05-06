<?php
/**
* Template Name: Front Page
*
* @package Creativity
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*
*/

get_header(); ?>

<div id="fullpage-wrapper" class="scrollme-home">
	<div class="homewrapper">


		<?php if ( has_header_image() ) : ?>
			<img class="headerimg" src="<?php header_image(); ?>" />
		<?php endif ?>
	</div>
</div>
<?php get_footer(); ?>
