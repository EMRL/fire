<?php

declare(strict_types=1);

namespace Fire\Post\Type;

class Support
{
    public const ARCHIVE_PAGE = 'fire/archive-page';

    public function __construct(
        protected readonly string $type,
        protected readonly array $supports,
    ) {
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
