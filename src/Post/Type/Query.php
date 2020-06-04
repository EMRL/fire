<?php

declare(strict_types=1);

namespace Fire\Post\Type;

use WP_Query;

class Query
{
    /** @var array<string,mixed> */
    protected array $data;

    /**
     * @param array<string,mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __invoke(WP_Query $query): void
    {
        foreach ($this->data as $key => $value) {
            $query->set($key, $value);
        }
    }
}
