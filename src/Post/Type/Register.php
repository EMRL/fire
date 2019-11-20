<?php

declare(strict_types=1);

namespace Fire\Post\Type;

class Register extends Hook
{
    public function register(): Hook
    {
        add_action('init', [$this, 'run']);
        return $this;
    }

    public function run(): void
    {
        register_post_type($this->type, $this->fn());
    }
}
