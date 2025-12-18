<?php

/*
Plugin Name: WP.Toolkit
Plugin URI:  https://wordpress.org
Description: WP Tools and Security Kit
Author: Richard Zack
Version: 1.0.2
Author URI: https://wordpress.org
*/

defined('ABSPATH') || exit;

require_once __DIR__ . '/security.inc.php';
require_once __DIR__ . '/seo.inc.php';
require_once __DIR__ . '/tools.inc.php';
require_once __DIR__ . '/ux.inc.php';

/**
 * Dependents can: add_action('wptk/ready', fn() => { ... });
 */
add_action('plugins_loaded', function () {
    do_action('wptk/ready');
});


// Activation logic
function wptk_on_activate() 
{
	if (!get_option('wptk_installed'))
	{
		error_log('WP.Toolkit activated on ' . date('Y-m-d H:i:s'));
		update_option('wptk_installed', time());
	
		if (function_exists('wptk_activation_steps')) 
		{
			wptk_activation_steps();
       	 	}
	}
}
register_activation_hook(__FILE__, 'wptk_on_activate');


// Activation function
function wptk_activation_steps()
{
	// Delete the Hello Dolly plugin
	if (file_exists(WP_PLUGIN_DIR . '/hello.php')) 
		delete_plugins(array('hello.php'));

	// Delete the "Hello World" post, the "Sample Page" and "Privacy Page", and the first comment
	wp_delete_post(1,1);
	wp_delete_post(2,1);
	wp_delete_post(3,1);
	wp_delete_comment(1,1);

	// Set some basic security and configuration settings
	update_option('default_ping_status','closed');
	update_option('default_pingback_flag',0);
	update_option('comment_max_links',1);
	update_option('blog_public',0);
}


