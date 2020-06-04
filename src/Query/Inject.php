<?php

declare(strict_types=1);

namespace Fire\Query;

use WP_Query;

class Inject
{
    /** @var array<string,mixed> $values */
    protected array $values;

    /**
     * @param array<string,mixed> $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
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
