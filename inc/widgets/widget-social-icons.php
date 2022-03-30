<?php
/************************************************/
## About me custom widget.
/************************************************/
class socialicon_widget extends WP_Widget {

	public function __construct() {
		parent::__construct('social', /* Unique widget ID */
			esc_html__('THEMENAE - Social Media URL', 'TheCreativityArchitect'), /* Widget title display in widget area. */
			array( 'description' => esc_html__( 'Social media URL widget.', 'TheCreativityArchitect' ), ) /* Widget description */
		);
	}

	/**********************************************/
	## Creating widget front-end
	## This is where the action happens
	/*********************************************/
	public function widget( $args, $instance ) {

		$title = isset($instance['title']) ? esc_html($instance['title']) : '' ;
		$button_style = isset($instance['button_style']) ? esc_html($instance['button_style']) : '';
		$fb_link      = isset($instance['fb_url']) ? esc_url($instance['fb_url']) : '';
		$twitter_link = isset($instance['twitter_url']) ? esc_url($instance['twitter_url']) : '';
		$insta_link   = isset($instance['instagram_url']) ? esc_url($instance['instagram_url']) : '';
		$github_link   = isset($instance['github_url']) ? esc_url($instance['github_url']) : '';
		$linked_link  = isset($instance['linkedin_url']) ? esc_url($instance['linkedin_url']) : '';
		$ytube_link   = isset($instance['youtube_url']) ? esc_url($instance['youtube_url']) : '';
		$pint_link    = isset($instance['pinterest_url']) ? esc_url($instance['pinterest_url']) : '';
		$drib_link    = isset($instance['dribble_url']) ? esc_url($instance['dribble_url']) : '';

		/* This is where you run the code and display the output */
		$social_link_output ='<nav class="social-navigation '.$button_style.'"><ul>';

		if($fb_link):
			$social_link_output .='<li><a href="'.$fb_link.'"><span class="fa fa-facebook"></span></a></li>';

		endif;

		if($twitter_link):
			$social_link_output .='<li><a href="'.$twitter_link.'"><span class="fa fa-twitter"></span></a></li>';

		endif;

		if($insta_link):
			$social_link_output .='<li><a href="'.$insta_link.'"><span class="fa fa-instagram"></span></a></li>';

		endif;

		if($github_link):
			$social_link_output .='<li><a href="'.$github_link.'"><span class="fa fa-github"></span></a></li>';

		endif;

		if($linked_link):
			$social_link_output .='<li><a href="'.$linked_link.'"><span class="fa fa-linkedin"></span></a></li>';

		endif;

		if($ytube_link):
			$social_link_output .='<li><a href="'.$ytube_link.'"><span class="fa fa-youtube"></span></a></li>';

		endif;

		if($pint_link):
			$social_link_output .='<li><a href="'.$pint_link.'"><span class="fa fa-pinterest-p"></span></a></li>';
		endif;

		if($drib_link):
			$social_link_output .='<li><a href="'.$drib_link.'"><span class="fa fa-dribbble"></span></a></li>';

		endif;

		$social_link_output .= '</ul></nav>';


		echo $args['before_widget']; /* before and after widget arguments are defined by themes */
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];

		echo $social_link_output;
		echo $args['after_widget'];
	}

	/****************************************/
	## Widget Backend
	/****************************************/

	public function form( $instance ) {

		$title               = isset($instance['title']) ? esc_attr($instance['title']) : '' ;
		$button_style        = isset($instance['button_style']) ? esc_attr($instance['button_style']) : '';
		$fb_link      = isset($instance['fb_url']) ? esc_url($instance['fb_url']) : '';
		$twitter_link = isset($instance['twitter_url']) ? esc_url($instance['twitter_url']) : '';
		$insta_link   = isset($instance['instagram_url']) ? esc_url($instance['instagram_url']) : '';
		$github_link   = isset($instance['github_url']) ? esc_url($instance['github_url']) : '';
		$linked_link  = isset($instance['linkedin_url']) ? esc_url($instance['linkedin_url']) : '';
		$ytube_link   = isset($instance['youtube_url']) ? esc_url($instance['youtube_url']) : '';
		$pint_link    = isset($instance['pinterest_url']) ? esc_url($instance['pinterest_url']) : '';
		$drib_link    = isset($instance['dribble_url']) ? esc_url($instance['dribble_url']) : '';

	?>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'TheCreativityArchitect' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'button_style' )); ?>">
			<?php esc_html_e( 'Social Button Style', 'TheCreativityArchitect' ); ?>
		</label>
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'button_style')); ?>" name="<?php echo esc_attr($this->get_field_name( 'button_style')); ?>" style="width:100%;">
			<option value="<?php echo esc_attr('default-colors')?>" <?php selected( $button_style, 'default-colors' );?>><?php esc_html_e( 'Default Color', 'TheCreativityArchitect' ) ?></option>
			<option value="<?php echo esc_attr('theme-colors')?>" <?php  selected( $button_style, 'theme-colors' ); ?>><?php esc_html_e( 'Theme Color', 'TheCreativityArchitect' ) ?></option>
			<option value="<?php echo esc_attr('original-colors')?>" <?php selected( $button_style, 'original-colors' );  ?>><?php esc_html_e( 'Icon Original Color', 'TheCreativityArchitect' ) ?></option>
		</select>
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'fb_url' )); ?>"><?php esc_html_e( 'Facebook URL', 'TheCreativityArchitect' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'fb_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'fb_url')); ?>" type="text" value="<?php echo $fb_link; ?>" />
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('twitter_url')); ?>"><?php esc_html_e('Twitter URL', 'TheCreativityArchitect' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'twitter_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'twitter_url' )); ?>" type="text" value="<?php echo $twitter_link; ?>" />
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('instagram_url')); ?>"><?php esc_html_e( 'Instagram URL', 'TheCreativityArchitect' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'instagram_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'instagram_url')); ?>" type="text" value="<?php echo $insta_link; ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'linkedin_url')); ?>"><?php esc_html_e( 'Linkedin URL', 'TheCreativityArchitect' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'linkedin_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'linkedin_url')); ?>" type="text" value="<?php echo $linked_link; ?>" />
	</p>


	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'github_url' )); ?>"><?php esc_html_e( 'GitHub URL', 'TheCreativityArchitect' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'github_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'github_url')); ?>" type="text" value="<?php echo $github_link; ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'youtube_url' )); ?>"><?php esc_html_e( 'YouTube URL', 'TheCreativityArchitect' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'youtube_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'youtube_url' )); ?>" type="text" value="<?php echo $ytube_link; ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'pinterest_url' )); ?>"><?php esc_html_e( 'Pinterest URL', 'TheCreativityArchitect' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pinterest_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'pinterest_url' )); ?>" type="text" value="<?php echo $pint_link; ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'dribble_url' )); ?>"><?php esc_html_e('Dribble URL', 'TheCreativityArchitect' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'dribble_url')); ?>" name="<?php echo esc_attr($this->get_field_name( 'dribble_url')); ?>" type="text" value="<?php echo $drib_link ; ?>" />
	</p>


	<?php

	}

	/**********************************************************/
	## Updating widget replacing old instances with new.
	/**********************************************************/

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? esc_html( $new_instance['title'] ) : '';

		$instance['button_style'] = ( ! empty( $new_instance['button_style'] ) ) ? esc_html( $new_instance['button_style'] ) : '';

		$instance['fb_url'] = ( ! empty( $new_instance['fb_url'] ) ) ? esc_url( $new_instance['fb_url'] ) : '';

		$instance['twitter_url'] = ( ! empty( $new_instance['twitter_url'] ) ) ? esc_url( $new_instance['twitter_url'] ) : '';

		$instance['github_url'] = ( ! empty( $new_instance['github_url'] ) ) ? esc_url( $new_instance['github_url'] ) : '';

		$instance['instagram_url'] = ( ! empty( $new_instance['instagram_url'] ) ) ? esc_url( $new_instance['instagram_url'] ) : '';

		$instance['linkedin_url'] = ( ! empty( $new_instance['linkedin_url'] ) ) ? esc_url( $new_instance['linkedin_url'] ) : '';

		$instance['youtube_url'] = ( ! empty( $new_instance['youtube_url'] ) ) ? esc_url( $new_instance['youtube_url'] ) : '';

		$instance['pinterest_url'] = ( ! empty( $new_instance['pinterest_url'] ) ) ? esc_url( $new_instance['pinterest_url'] ) : '';

		$instance['dribble_url'] = ( ! empty( $new_instance['dribble_url'] ) ) ? esc_url( $new_instance['dribble_url'] ) : '';

		return $instance;
	}
} /* class end */

// Register and load the widget
register_widget( 'socialicon_widget' );


?>
