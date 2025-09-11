<?php

/*
 * Plugin Name: Application Passwords for more things
 */

function application_password_extras($original_value) {
	// Allow Application Password access to admin-ajax.php
	if ( is_admin() && wp_doing_ajax() ){
		return true;
	}

	// Allow access to post/page previews
	if ( isset( $_GET['p'] ) || isset( $_GET['page_id'] ) ) {
		return true;
	}

	return $original_value;
}

add_filter( 'application_password_is_api_request', 'application_password_extras' );

// Add an endpoint to advertise support. This could also be setting that's only registered
// for the REST API, but having a way to know upfront whether this will work or not is 
// really helpful for the application UI.
function application_password_extra_capabilities() {
	return [
		'admin-ajax',
		'post-previews'
	];
}

add_action( 'rest_api_init', function() {
	register_rest_route( 'application-password-extras/v1', 'capabilities', [
		'methods'  				=> WP_REST_Server::READABLE,
		'callback' 				=> 'application_password_extra_capabilities',
		'permission_callback' 	=> 'is_user_logged_in',
	] );
});


