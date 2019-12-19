<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

use WP_Term;

class Hooks
{
    public function register(): self
    {
        add_filter('register_taxonomy_args', [$this, 'registerTaxonomyArgs'], 10, 3);
        add_filter('term_link', [$this, 'termLink'], 10, 3);
        return $this;
    }

    public function registerTaxonomyArgs(array $args, string $taxonomy, array $types): array
    {
        return apply_filters("fire/register_taxonomy_args/$taxonomy", $args, $types);
    }

    public function termLink(string $url, WP_Term $term, string $taxonomy): string
    {
        return apply_filters("fire/term_link/$taxonomy", $url, $term);
    }
}
