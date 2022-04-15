<?php

declare(strict_types=1);

namespace Fire\Query;

use WP_Query;

class Inject
{
    public function __construct(
        protected readonly array $values,
    ) {
    }

    public function register(): self
    {
        if (is_admin()) {
            return $this;
        }

        add_action('parse_query', [$this, 'parse']);
        return $this;
    }

    public function parse(WP_Query $query): void
    {
        foreach ($this->values as $key => $value) {
            $query->set($key, $value);
        }
    }
}
