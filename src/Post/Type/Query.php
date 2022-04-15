<?php

declare(strict_types=1);

namespace Fire\Post\Type;

use WP_Query;

class Query
{
    public function __construct(
        protected readonly array $data,
    ) {
    }

    public function __invoke(WP_Query $query): void
    {
        foreach ($this->data as $key => $value) {
            $query->set($key, $value);
        }
    }
}
