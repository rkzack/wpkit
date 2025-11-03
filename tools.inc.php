<?php

/**
 * Get the ID of a page by its slug.
 *
 * Retrieves the WordPress page ID corresponding to the provided slug (path).
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @param string $page_slug The slug (path) of the page.
 * @return int|null The page ID if found, or null if no page matches.
 */
function wptk_get_id_by_slug($page_slug)
{
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

/**
 * Check if a specific database table exists in the WordPress database.
 *
 * Uses the global $wpdb object to verify whether the given table
 * (including WordPress prefix) exists in the current database.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @global wpdb $wpdb The WordPress database access abstraction object.
 * @param string $table_name The name of the table (without prefix).
 * @return bool True if the table exists, false otherwise.
 */
function wptk_table_exists($table_name)
{
    global $wpdb;
    $table = $wpdb->prefix . $table_name;
    $sql = "SHOW TABLES LIKE '{$table}'";
    $result = $wpdb->get_var($sql);
    return $result === $table;
}

/**
 * Reload the current page using JavaScript.
 *
 * Outputs an inline script that triggers a page reload
 * after a 2-second delay when the DOM is ready.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @return void
 */
function wptk_reload_me()
{
    ?>
    <script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            setTimeout(function() {
                location.reload();
            }, 2000);
        });
    })(jQuery);
    </script>
    <?php
}
