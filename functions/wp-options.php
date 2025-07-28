<?php
if (!defined('WPINC')) {
    die;
}

use Jm\WpHelper\Helper;
use Jm\WpHelper\Wordpress;
use Jm\WpHelper\Timber;

class Theme_Wp_Options {
    public function __construct() {
        add_action('admin_init', [$this, 'admin_menu_separator']);
        add_action('admin_menu', [$this, 'admin_menu_items']);
        add_action('init', [$this, 'disable_wp_emojicons']);
        add_filter('upload_mimes', [$this, 'custom_mime_types']);

        /**
         * Main settings
         */
        show_admin_bar(false);
        add_theme_support('post-thumbnails');
        add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
        add_filter('wp_terms_checklist_args',[$this, 'stop_reordering_my_categories']);
    }

    /**
     * Menu separator
     */
    public function admin_menu_separator() {
        Helper\Wordpress::add_admin_menu_separator(40);
    }

    /**
     * Blocks
     */
    public function admin_menu_items()
    {
        add_menu_page(
            'Bloki',
            'Bloki',
            'edit_posts',
            'edit.php?post_type=wp_block',
            '',
            'dashicons-schedule',
            20
        );
    }

    /**
     * Disable emoji
     */
    public function disable_wp_emojicons() {
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
    }

    /**
     * Stop moving selected category on top
     */
    function stop_reordering_my_categories($args) {
        $args['checked_ontop'] = false;
        return $args;
    }

    /**
     * Upload settings
     */
    function custom_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['wav'] = '';
        return $mimes;
    }
}

new Theme_Wp_Options();







