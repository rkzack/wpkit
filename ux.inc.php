<?php

/**
 * Change some wording conditionally on the login_errors page
 */
add_filter('login_errors', function ($error) {
    if (strpos($error, 'Your password reset link appears to be invalid') !== false) {
        return '<strong>For security, please enter your email address to request a password reset link.</strong>';
    }
    return $error;
});


/**
 * Generate HTML <option> tags for U.S. states with optional preselection.
 *
 * @param string $selected The state abbreviation to mark as selected (e.g., 'CA').
 * @return string HTML <option> list with optional selected attribute.
 */
function wptk_get_state_options($selected = '')
{
        $states = [ '' => 'Select State',
                'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas',
                'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware',
                'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho',
                'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas',
                'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
                'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi',
                'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada',
                'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York',
                'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
                'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
                'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah',
                'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia',
                'WI' => 'Wisconsin', 'WY' => 'Wyoming', 'DC' => 'District of Columbia',
                'AS' => 'American Samoa', 'GU' => 'Guam', 'MP' => 'Northern Mariana Islands',
                'PR' => 'Puerto Rico', 'VI' => 'U.S. Virgin Islands', 'UM' => 'U.S. Minor Outlying Islands',
                'FM' => 'Federated States of Micronesia', 'MH' => 'Marshall Islands', 'PW' => 'Palau',
        ];

        $options = '';
        foreach ($states as $abbr => $name) {
                $isSelected = ($abbr === $selected) ? ' selected' : '';
                $options .= "<option value=\"$abbr\"$isSelected>$name</option>";
        }

        return $options;
}


/**
 * Remove default dashboard widgets for all users.
 *
 * This function removes several default WordPress dashboard widgets
 * (such as Quick Draft, Activity, and Site Health) for all users,
 * regardless of their role. It also disables the Welcome Panel.
 *
 * @since 1.0.0
 * @package WP.Toolkit
 *
 * @global array $wp_meta_boxes The array of dashboard meta boxes.
 * @return void
 */
function wptk_remove_dashboard_widgets() 
{
    global $wp_meta_boxes;

    // Remove specific default dashboard widgets
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
    remove_action('welcome_panel', 'wp_welcome_panel');
}
add_action('wp_dashboard_setup', 'wptk_remove_dashboard_widgets',99999 );
