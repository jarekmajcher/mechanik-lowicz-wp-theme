<?php
if (!defined('WPINC')) {
    die;
}

use Timber\Timber;

$slug = str_replace('acf/', '', $block['name']);
$fields = get_field($slug);
$context = Timber::context();

$vars = ['context' => $context, 'block' => $block, 'fields' => $fields];
$vars = apply_filters('acf_blocks_vars_' . $slug, $vars);

echo Timber::compile('@rwd/acf-blocks/' . $slug . '.twig', $vars);
