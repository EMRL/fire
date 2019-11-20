<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

class Modify extends Hook
{
    public function register(): Hook
    {
        add_filter('register_taxonomy_args', [$this, 'run'], 10, 3);
        return $this;
    }

    /**
     * @param array<string,mixed> $args
     * @param string[] $types
     */
    public function run(array $args, string $taxonomy, array $types): array
    {
        if ($this->isTaxonomy($taxonomy)) {
            $args = $this->fn($args, $types);
        }

        return $args;
    }
}
