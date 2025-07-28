<?php
if (!defined('WPINC')) {
    die;
}

class Theme_Wp_Cpt {
    public function __construct() {
        add_action('init', [$this, 'create_post_types']);
    }

    public function create_post_types() {
    }
}

new Theme_Wp_Cpt();
