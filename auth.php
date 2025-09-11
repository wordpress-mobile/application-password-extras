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

add_filter('application_password_is_api_request', 'application_password_extras', 100);
