<?php

declare(strict_types=1);

namespace Fire\Post\Type;

use WP_Post;

class TitlePlaceholder extends Hook
{
    public function register(): Hook
    {
        add_filter('enter_title_here', [$this, 'run'], 10, 2);
        return $this;
    }

    public function run(string $placeholder, WP_Post $post): string
    {
        if ($this->isType($post->post_type)) {
            $placeholder = $this->fn($placeholder, $post);
        }

        return $placeholder;
    }
}
