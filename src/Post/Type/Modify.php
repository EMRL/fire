<?php

declare(strict_types=1);

namespace Fire\Post\Type;

class Modify extends Hook
{
    public function register(): Hook
    {
        add_filter('register_post_type_args', [$this, 'run'], 10, 2);
        return $this;
    }

    public function run(array $args, string $type): array
    {
        if ($this->isType($type)) {
            $args = $this->fn($args);
        }

        return $args;
    }
}
