<?php
if (!defined('WPINC')) {
    die;
}

use Timber\Timber;

$context = Timber::context();
$context['title'] = __('404 - strona nie istnieje', 'mechanik-lowicz');

Timber::render('@rwd/404.twig', $context);
