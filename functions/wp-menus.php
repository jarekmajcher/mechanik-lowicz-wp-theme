<?php
if (!defined('WPINC')) {
    die;
}

class Theme_Wp_Menu {
    public function __construct() {
        add_action('init', [$this, 'register_menu']);
    }

    public function register_menu() {
        register_nav_menus([
            'footer_navigation' => 'Nawigacja w stopce'
        ]);
    }
}

new Theme_Wp_Menu();
