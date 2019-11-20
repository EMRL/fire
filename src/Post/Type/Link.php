<?php

declare(strict_types=1);

namespace Fire\Post\Type;

use WP_Post;

class Link extends Hook
{
    public function register(): Hook
    {
        add_filter('post_type_link', [$this, 'run'], 10, 2);
        return $this;
    }

    public function run(string $url, WP_Post $post): string
    {
        if ($this->isType($post->post_type)) {
            $url = $this->fn($url, $post);
        }

        return $url;
    }
}
