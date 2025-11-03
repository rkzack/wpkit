<?php

/**
 * Disable xmlrpc and some text on login page
 */
add_filter('xmlrpc_enabled', '__return_false' );
add_filter('login_headertext', '__return_empty_string');


/**
 * Disable all RSS feeds by removing the default feed actions
 */
function wptk_disable_all_rss_feeds() 
{
    remove_action('do_feed', 'do_feed_rss', 10);
    remove_action('do_feed_rss2', 'do_feed_rss2', 10);
    remove_action('do_feed_atom', 'do_feed_atom', 10);
    remove_action('do_feed_rss2_comments', 'do_feed_rss2_comments', 10);
    remove_action('do_feed_atom_comments', 'do_feed_atom_comments', 10);

    add_action('do_feed',               'wptk_custom_disable_rss_message', 1);
    add_action('do_feed_rss',           'wptk_custom_disable_rss_message', 1);
    add_action('do_feed_rss2',          'wptk_custom_disable_rss_message', 1);
    add_action('do_feed_atom',          'wptk_custom_disable_rss_message', 1);
    add_action('do_feed_rss2_comments', 'wptk_custom_disable_rss_message', 1);
    add_action('do_feed_atom_comments', 'wptk_custom_disable_rss_message', 1);
}


/**
 * Custom message displayed when attempting to access any RSS feed.
 */
function wptk_custom_disable_rss_message()
{
    wp_die('Not in this eternity.', 'Disabled', array('response' => 403));
}

/**
 * Remove RSS feed meta tags from the <head> section.
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
 * Hook into WordPress to disable feeds and remove RSS-related meta tags.
 */
function wptk_disable_rss_and_meta()
{
    wptk_disable_all_rss_feeds();
    wptk_remove_rss_feed_meta_tags();
}
add_action('init', 'wptk_disable_rss_and_meta');


//
// Sanitize some input
//
function wptk_saferinput($input)
{
    $input = trim($input ?? '');
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}


/**
 * Get the remote user's IP address and browser information.
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


//
// Change the logo URL on the login page
//
function wptk_loginlogo_url($url)
{
        return '';
}
add_filter('login_headerurl','wptk_loginlogo_url');
