<?php
if (!defined('WPINC')) {
    die;
}

use Timber\Timber;

$context = Timber::context();
$context['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;;
$context['posts'] = Timber::get_posts();

Timber::render('@rwd/archive/post.twig', $context);
