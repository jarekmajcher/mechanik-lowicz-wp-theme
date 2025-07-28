<?php
if (!defined('WPINC')) {
    die;
}

class Theme_Acf_Gutenberg {
    public function __construct() {
        add_action('init', [$this, 'register_acf_blocks']);
    }

    /**
     * Register ACF Blocks
     */
    public function register_acf_blocks() {
        $directories = glob(get_template_directory() . '/blocks/acf-*' , GLOB_ONLYDIR);

        foreach($directories as $directory) {
            register_block_type($directory);
        }
    }

}

new Theme_Acf_Gutenberg();
