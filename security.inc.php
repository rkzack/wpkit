<?php

/**
 * Disable XML-RPC and remove the default login header text.
 *
 * This disables XML-RPC functionality for security reasons and
 * removes the WordPress logo title text on the login screen.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 */
add_filter('xmlrpc_enabled', '__return_false');
add_filter('login_headertext', '__return_empty_string');


/**
 * Disable all RSS and Atom feeds.
 *
 * Removes all default feed actions and replaces them with a custom
 * message for any attempt to access a feed endpoint.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @return void
 */
function wptk_disable_all_rss_feeds() 
{
    // Remove all default feed handlers
    remove_action('do_feed', 'do_feed_rss', 10);
    remove_action('do_feed_rss2', 'do_feed_rss2', 10);
    remove_action('do_feed_atom', 'do_feed_atom', 10);
    remove_action('do_feed_rss2_comments', 'do_feed_rss2_comments', 10);
    remove_action('do_feed_atom_comments', 'do_feed_atom_comments', 10);

    // Replace them with the custom "disabled" message
    add_action('do_feed',               'wptk_custom_disable_rss_message', 1);
    add_action('do_feed_rss',           'wptk_custom_disable_rss_message', 1);
    add_action('do_feed_rss2',          'wptk_custom_disable_rss_message', 1);
    add_action('do_feed_atom',          'wptk_custom_disable_rss_message', 1);
    add_action('do_feed_rss2_comments', 'wptk_custom_disable_rss_message', 1);
    add_action('do_feed_atom_comments', 'wptk_custom_disable_rss_message', 1);
}


/**
 * Display a custom message when attempting to access disabled feeds.
 *
 * Called when a user or bot requests an RSS/Atom feed URL.
 * Returns an HTTP 403 Forbidden response with a custom message.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @return void
 */
function wptk_custom_disable_rss_message()
{
    wp_die('Not available.', 'Disabled', array('response' => 403) );
}


/**
 * Remove all RSS feed and related meta tags from the <head> section.
 *
 * Cleans up the WordPress head output by removing links related to
 * RSS, RSD (Really Simple Discovery), and other unneeded metadata.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @return void
 */
function wptk_remove_rss_feed_meta_tags()
{
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'prev_link');
    remove_action('wp_head', 'next_link');
}


/**
 * Disable all RSS feeds and remove related meta tags during initialization.
 *
 * Runs early in the WordPress lifecycle to ensure feeds and their
 * corresponding meta tags are disabled before rendering the front end.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @return void
 */
function wptk_disable_rss_and_meta()
{
    wptk_disable_all_rss_feeds();
    wptk_remove_rss_feed_meta_tags();
}
add_action('init', 'wptk_disable_rss_and_meta');


/**
 * Sanitize a given input string.
 *
 * Trims whitespace, strips slashes, and converts special characters
 * to HTML entities to help prevent XSS or malformed input issues.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @param string|null $input The raw input value to sanitize.
 * @return string The sanitized string.
 */
function wptk_saferinput($input)
{
    $input = trim($input ?? '');
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}


/**
 * Retrieve the remote user's IP address and browser information.
 *
 * Detects the user's IP address, accounting for proxy headers, and
 * collects the browser user agent string for logging or security purposes.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @return array {
 *     Associative array containing the user's connection details.
 *
 *     @type string $ip      The detected IP address of the user.
 *     @type string $browser The user's browser user agent string.
 * }
 */
function wptk_get_user_ip_and_browser() 
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    }
    $browser_info = $_SERVER['HTTP_USER_AGENT'] ?? '';
    return ['ip' => $ip, 'browser' => $browser_info];
}


/**
 * Change the logo URL on the WordPress login page.
 *
 * Replaces the default login logo link (which normally points to WordPress.org)
 * with an empty string, effectively disabling the link.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @param string $url The default URL for the login logo.
 * @return string The modified (empty) URL.
 */
function wptk_loginlogo_url($url)
{
        return '';
}
add_filter('login_headerurl','wptk_loginlogo_url');
