<?php
if (!defined('WPINC')) {
    die;
}

/**
 * Vars
 */
define('COOKIE_ACCEPT', !isset($_COOKIE['cookie_accept']) ? false : true);


/**
 * Requires
 */
require_once(get_stylesheet_directory() . '/vendor/autoload.php');
foreach (glob(get_stylesheet_directory() . '/functions/*.php') as $filename) {
    require_once($filename);
}

/**
 * Require forms
 */
foreach (glob(get_stylesheet_directory() . '/functions/forms/*.php') as $filename) {
    require_once($filename);
}

/**
 * INIT
 */
new Jm\WpHelper\Wordpress\AdminNotices();
new Jm\WpHelper\Wordpress\ScriptsStyles();
new Jm\WpHelper\Wordpress\Shortcodes();
new Jm\WpHelper\Wordpress\Smtp();
new Jm\WpHelper\Timber\Filters();
new Jm\WpHelper\Timber\Functions();
new Jm\WpHelper\Timber\Tests();
