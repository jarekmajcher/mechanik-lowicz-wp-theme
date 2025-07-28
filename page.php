<?php
if (!defined('WPINC')) {
    die;
}

use Timber\Timber;

$context = Timber::context();
$context['post'] = Timber::get_post();
$context['fields'] = get_fields();

Timber::render('@rwd/single/page.twig', $context);
