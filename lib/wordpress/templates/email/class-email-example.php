<?php

require_once 'class.php';

function ibenic_email_template_submenu() {
	 add_submenu_page(
	        'options-general.php',
	        'Email Templates',
	        'Email Templates',
	        'manage_options',
	        'email-templates',
	        'ibenic_email_template_submenu_cb' );
}
add_action( 'admin_menu', 'ibenic_email_template_submenu' );

function ibenic_email_template_submenu_cb() {
	?>
	<div class="wrap">
		<h2><?php _e( 'Email Templates', 'your_textdomain'); ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'email-templates' );	//pass slug name of page, also referred
                                        //to in Settings API as option group name
			do_settings_sections( 'email-templates' ); 	//pass slug name of page
			submit_button();
			?>
		</form>
	</div>
	<?php
}

function ibenic_email_template_settings() {
 	// Add the section to reading settings so we can add our
 	// fields to it
 	add_settings_section(
		'email_templates_section',
		'Dynamic Email Templates',
		'ibenic_email_templates_section',
		'email-templates'
	);
 	
 	// Add the field with the names and function to use for our new
 	// settings, put it in our new section
 	add_settings_field(
		'email_template_user',
		'User Registered',
		'email_template_user_cb',
		'email-templates',
		'email_templates_section'
	);
 	
 	// Register our setting so that $_POST handling is done for us and
 	// our callback function just has to echo the <input>
 	register_setting( 'email-templates', 'email_template_user' );
 } // eg_settings_api_init()
 
 add_action( 'admin_init', 'ibenic_email_template_settings' );

 function ibenic_email_templates_section() {
 	echo '';
 }

 function email_template_user_cb() {
 	$content = get_option('email_template_user');
 	wp_editor( $content, 'email_template_user' );
 }

 function ibenic_email_template_on_register( $user_id ) {

    $user_info = get_userdata( $user_id );
    
    $dynamicData = array(
    	'username' => $user_info->user_login,
    	'useremail' => $user_info->user_email);

    $emails = get_option( 'admin_email' );

    $subject = 'New User Registered:  ' . $user_info->user_login;

    $template = 'email_template_user';

    new WordPressEmail( $emails, $subject, $dynamicData, $template );

}