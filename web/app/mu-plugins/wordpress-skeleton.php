<?php
/*
Plugin Name:  Wordpress Skeleton
Plugin URI:   https://skyfoundry.agency
Description:  Provides defaults for Wordpress Skeleton instances
Version:      1.0.0
Author:       Sky Foundry
Author URI:   https://skyfoundry.agency
License:      MIT License
*/

/**
 * Option overrides
 */
add_filter('option_permalink_structure', function ($option) {
    return "/%postname%/";
});

/**
 * Set the default theme
 */
function wordpress_skeleton_default_theme () {
    return WP_DEFAULT_THEME;
}

add_filter('stylesheet', 'wordpress_skeleton_default_theme');
add_filter('template', 'wordpress_skeleton_default_theme');

/**
 * Development only overrides
 */
if (defined('WP_ENV') && WP_ENV !== 'production') {
    /**
     * SMTP settings override
     */
    if (defined('SKELETON_OVERRIDE_SMTP') && SKELETON_OVERRIDE_SMTP == true) {
        // Override the SMTP settings when running in development
        add_filter('option_swpsmtp_options', function ($option) {
            $option['smtp_settings']['host'] = 'mailhog';
            $option['smtp_settings']['port'] = '1025';
            $option['smtp_settings']['autentication'] = 'no';
            
            return $option;
        });
    }
}

/**
 * Disable shit
 */
add_action('init', function () {
    /**
     * Remove fucking emojis
     */
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');	
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');	
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', function ($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        } else {
            return array();
        }
    });
});

// Disable "Post via email"
add_filter('enable_post_by_email_configuration', '__return_false', 100);

/**
 * Disable "Theme" and "Customise" in the sidebar menu
 */
add_action('admin_init', function () {
    global $submenu;
    
    unset($submenu['themes.php'][5]);
    unset($submenu['themes.php'][6]);
});