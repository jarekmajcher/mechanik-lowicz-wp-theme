<?php
if (!defined('WPINC')) {
    die;
}

class Theme_Wp_Images {
    public function __construct() {
        add_action('init', [$this, 'add_image_sizes']);
    }

    public function add_image_sizes() {
        add_image_size('admin', 300, 300);
        add_image_size('micro', 100, 200);
        add_image_size('mini', 160, 320);
        add_image_size('half', 600, 1200);
    }
}

new Theme_Wp_Images();
