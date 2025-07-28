<?php
if (!defined('WPINC')) {
	die;
}

class Theme_Wp_Taxonomy {
    public function __construct() {
        add_action('init', [$this, 'create_custom_taxonomies'], 0);
    }

    /**
     * Create custom taxonomies
     */
    public function create_custom_taxonomies() {
    }
}

new Theme_Wp_Taxonomy();
