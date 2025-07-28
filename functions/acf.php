<?php
if (!defined('WPINC')) {
    die;
}

use Jm\WpHelper\Helper;
use Jm\WpHelper\Wordpress;
use Jm\WpHelper\Timber;

class Theme_Acf {
    public function __construct() {
        add_filter('acf/load_value/type=text', [$this, 'acf_remove_orphan'], 10, 3);
        add_filter('acf/load_value/type=textarea', [$this, 'acf_remove_orphan'], 10, 3);
        add_filter('acf/load_value/type=wysiwyg', [$this, 'acf_remove_orphan'], 10, 3);
    }

    public function acf_remove_orphan($value, $post_id, $field) {
        if(!is_admin()) {
            return Helper\Php::remove_orphan($value);
        }
        else {
            return $value;
        }
    }
}
new Theme_Acf();