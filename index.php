<?php
if (!defined('WPINC')) {
    die;
}

use Timber\Timber;

$context = Timber::context();
$context['posts'] = Timber::get_posts();

Timber::render('@rwd/archive/post.twig', $context);
