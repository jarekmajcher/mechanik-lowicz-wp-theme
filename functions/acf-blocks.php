<?php
if (!defined('WPINC')) {
    die;
}

class Theme_Acf_Blocks {
    public function __construct() {
        add_action('init', [$this, 'register_acf_blocks']);
    }

    /**
     * Register ACF Blocks
     */
    public function register_acf_blocks() {
        $directories = glob(get_template_directory() . '/acf-blocks/*' , GLOB_ONLYDIR);

        foreach($directories as $directory) {
            register_block_type($directory);
        }
    }
}

new Theme_Acf_Blocks();
