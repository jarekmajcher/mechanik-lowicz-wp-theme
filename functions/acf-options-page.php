<?php
if (!defined('WPINC')) {
    die;
}

class Theme_Acf_Options_Page {
    public function __construct() {
        add_action('init', [$this, 'add_options_page']);
    }

    public function add_options_page() {
        if(function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title' => 'Opcje',
                'menu_title' => 'Opcje',
                'menu_slug' => 'options',
                'capability' => 'edit_posts',
                'position' => 80,
                'redirect' => false,
                'icon_url' => 'dashicons-smiley'
            ));
        }
    }
}

new Theme_Acf_Options_Page();
