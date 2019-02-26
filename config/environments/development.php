<?php
/**
 * Configuration overrides for WP_ENV === 'development'
 */

use Roots\WPConfig\Config;

Config::define('SAVEQUERIES', true);
Config::define('WP_DEBUG', true);
Config::define('WP_DEBUG_DISPLAY', true);
Config::define('SCRIPT_DEBUG', true);
Config::define('SKELETON_OVERRIDE_SMTP', true);
/**
 * WP Stateless https://github.com/wpCloud/wp-stateless/wiki/Constants
 */
Config::define('WP_STATELESS_MEDIA_HIDE_SETTINGS_PANEL', false);

if (file_exists('../../.private/service-account.json')) {
    Config::define('WP_STATELESS_MEDIA_BUCKET', 'wordpress-starter-kit');
    Config::define('WP_STATELESS_MEDIA_KEY_FILE_PATH', '../../.private/service-account.json');
}

ini_set('display_errors', 1);
