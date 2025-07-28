<?php
if (!defined('WPINC')) {
    die;
}

class Theme_Wp_Sidebars {
    public function __construct() {
        add_action('init', [$this, 'create_sidebars']);
    }

    /**
     * Create sidebars
     */
    public function create_sidebars() {
        register_sidebar([
            'name' => '[Stopka] info 1',
            'id' => 'footer_info_1',
            'class' => '',
            'description' => '[Stopka] info 1',
            'before_widget' => '<div class="footer__widget footer__widget--info1">',
            'after_widget' => '</div>',
            'before_title' => '<h6 class="footer__header">',
            'after_title' => '</h6>',
        ]);

        register_sidebar([
            'name' => '[Stopka] info 2',
            'id' => 'footer_info_2',
            'class' => '',
            'description' => '[Stopka] info 2',
            'before_widget' => '<div class="footer__widget footer__widget--info2">',
            'after_widget' => '</div>',
            'before_title' => '<h6 class="footer__header">',
            'after_title' => '</h6>',
        ]);
    }
}

new Theme_Wp_Sidebars();
