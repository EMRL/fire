<?php

declare(strict_types=1);

namespace Fire\Post\Type;

use WP_Post;
use WP_Query;

class Hooks
{
    public function register(): self
    {
        add_filter('register_post_type_args', [$this, 'registerPostTypeArgs'], 10, 2);
        add_filter('enter_title_here', [$this, 'enterTitleHere'], 10, 2);
        add_filter('post_type_archive_title', [$this, 'postTypeArchiveTitle'], 10, 2);
        add_filter('post_type_link', [$this, 'postTypeLink'], 10, 2);
        add_action('pre_get_posts', [$this, 'preGetPosts']);
        return $this;
    }

    public function registerPostTypeArgs(array $args, string $type): array
    {
        return apply_filters("fire/register_post_type_args/$type", $args);
    }

    public function enterTitleHere(string $placeholder, WP_Post $post): string
    {
        return apply_filters("fire/enter_title_here/{$post->post_type}", $placeholder, $post);
    }

    public function postTypeArchiveTitle(string $title, string $type): string
    {
        return apply_filters("fire/post_type_archive_title/$type", $title);
    }

    public function postTypeLink(string $url, WP_Post $post): string
    {
        return apply_filters("fire/post_type_link/{$post->post_type}", $url, $post);
    }

    public function preGetPosts(WP_Query $query): void
    {
        if ($query->is_main_query() && $types = (array) $query->get('post_type')) {
            foreach (array_filter($types) as $type) {
                do_action("fire/pre_get_posts/$type", $query);
            }
        }
    }
}
