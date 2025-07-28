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
            'header_navigation' => 'Nawigacja w nagłówku',
            'footer_navigation' => 'Nawigacja w stopce',
            'mobile_navigation' => 'Nawigacja mobilna',
        ]);
    }
}

new Theme_Wp_Menu();
