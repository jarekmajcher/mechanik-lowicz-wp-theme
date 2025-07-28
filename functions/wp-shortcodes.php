<?php
if (!defined('WPINC')) {
    die;
}

class Theme_Wp_Shortcodes {
    public function __construct() {
        add_shortcode('back_to_parent_page', [$this, 'back_to_parent_page']);
    }

    /**
     * Back to parent
     */
    public function back_to_parent_page($atts) {
        global $post;

        $config = shortcode_atts([
            'id' => wp_get_post_parent_id($post)
        ], $atts);

        if($config['id']) {
            return Timber::compile('shortcodes/back-to-parent-page.twig', [
                'config' => $config,
                'context' => Timber::get_context(),
                'parent' => Timber::get_post($config['id'])
            ]);
        }
        else {
            return '';
        }
    }

}

new Theme_Wp_Shortcodes();
