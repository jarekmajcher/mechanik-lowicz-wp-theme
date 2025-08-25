<?php
if (!defined('WPINC')) {
    die;
}

use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Timber\Timber;

class Theme_Wp_Gutenberg_Blocks {

    public function __construct() {
        add_action('init', [$this, 'register_theme_blocks']);
    }

    private function get_asset_filename($file) {
        $manifest = get_stylesheet_directory() . '/public/blocks/manifest.json';
        $package = new Package(new JsonManifestVersionStrategy($manifest));

        return  $package->getUrl(substr(parse_url(get_stylesheet_directory_uri(), PHP_URL_PATH), 1) . '/public/blocks/' . $file);
    }

    private function set_block_assets($slug, $path): ?array
    {
        $pathAbsolute = $_SERVER['DOCUMENT_ROOT'] . $path;

        if (!file_exists($pathAbsolute)) {
            return null;
        }

        $filename = pathinfo($path, PATHINFO_FILENAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $type = str_replace(['js', 'css'], ['script', 'style'], $extension);

        if (str_starts_with($filename, 'editor')) {
            $asset = 'editor_' . $type;
        } elseif (str_starts_with($filename, 'common')) {
            $asset = $type;
        } elseif (str_starts_with($filename, 'view') && $type === 'script') {
            $asset = 'view_' . $type;
        } else {
            return null;
        }

        if ($type === 'script') {
            wp_register_script(
                'theme-block-' . $asset,
                $path,
                ['wp-blocks', 'wp-element', 'wp-editor'],
                filemtime($pathAbsolute)
            );

            return [$asset => 'theme-block-' . $asset];
        }
        elseif ($type === 'style') {
            wp_register_style(
                'theme-block-' . $asset,
                $path,
                [],
                filemtime($pathAbsolute)
            );
            return [$asset => 'theme-block-' . $asset];
        }

        return null;
    }

    /**
     * Register theme blocks
     */
    public function register_theme_blocks() {
        $directories = glob(get_template_directory() . '/blocks/*', GLOB_ONLYDIR);

        foreach($directories as $directory) {
            $args = [];

            $slug = basename($directory);

            // Dynamic set assets
            $assets = [
                $this->get_asset_filename($slug . '/editor.js'),
                $this->get_asset_filename($slug . '/editor.css'),
                $this->get_asset_filename($slug . '/common.js'),
                $this->get_asset_filename($slug . '/common.css'),
                $this->get_asset_filename($slug . '/view.js')
            ];

            foreach ($assets as $asset) {
                $array = $this->set_block_assets($slug, $asset);

                if (null !== $array) {
                    $args = array_merge($args, $array);
                }
            }

            // Dynamic render
            if(file_exists(get_template_directory() . '/twigs/blocks/' . $slug . '.twig')) {
                $args['render_callback'] = function($attributes, $content, $block) use ($slug) {
                    $vars = [];
                    $vars['attributes'] = $attributes;
                    $vars['content'] = $content;
                    $vars['block'] = $block;

                    return Timber::compile('@blocks/' . $slug . '.twig', $vars);
                };
            }

            register_block_type($directory, $args);
        }
    }
}

new Theme_Wp_Gutenberg_Blocks();
