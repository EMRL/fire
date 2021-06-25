<?php

declare(strict_types=1);

namespace Fire\Post\Type;

class Support
{
    protected string $type;

    protected array $supports;

    public function __construct(string $type, array $supports)
    {
        $this->type = $type;
        $this->supports = $supports;
    }

    public function __invoke(): void
    {
        foreach ($this->supports as $feature => $args) {
            if (is_array($args)) {
                add_post_type_support($this->type, $feature, $args);
            } else {
                add_post_type_support($this->type, $args);
            }
        }
    }

    public function remove(): void
    {
        foreach ($this->supports as $feature) {
            remove_post_type_support($this->type, $feature);
        }
    }
}
