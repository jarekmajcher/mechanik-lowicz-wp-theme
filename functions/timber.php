<?php
if (!defined('WPINC')) {
    die;
}

use Timber\Timber;

class Theme_Timber {
    public function __construct() {
        add_filter('timber/context', [$this, 'add_to_context']);
        add_action('timber/locations', [$this, 'set_locations']);
    }

    /**
     * Vars
     */
    public function add_to_context($context){
        $context['WP_DEBUG'] = defined('WP_DEBUG') ? WP_DEBUG : false;
        $context['COOKIE_ACCEPT'] = COOKIE_ACCEPT;

        $context['ICL_LANGUAGE_CODE'] = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'pl';
        $context['LANGUAGES'] = apply_filters('wpml_active_languages', '', '');

        // Menus
        $menus = get_registered_nav_menus();
        $context['menu'] = array();
        foreach($menus as $menuLocation => $menuDescription) {
            $context['menu'][$menuLocation] = Timber::get_menu($menuLocation);
        }

        // Sidebars
        $sidebars = $GLOBALS['wp_registered_sidebars'];
        $context['sidebar'] = array();
        foreach ($sidebars as $sidebar) {
            $context['sidebar'][$sidebar['id']] = Timber::get_widgets($sidebar['id']);
        }

        // Options
        $context['options'] = array(
            'social' => get_field('social', 'option'),
            'keys' => get_field('keys', 'option'),
        );

        return $context;
    }

    /**
     * Templates
     */
    public function set_locations($paths) {
        $paths['rwd'] = [
            get_stylesheet_directory() . '/twigs/rwd',
            get_stylesheet_directory() . '/public/rwd'
        ];

        $paths['admin'] = [
            get_stylesheet_directory() . '/twigs/admin',
            get_stylesheet_directory() . '/public/admin'
        ];

        return $paths;
    }
}

new Theme_Timber();
