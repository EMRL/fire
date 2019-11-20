<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

use WP_Term;

class Link extends Hook
{
    public function register(): Hook
    {
        add_filter('term_link', [$this, 'run'], 10, 3);
        return $this;
    }

    public function run(string $url, WP_Term $term, string $taxonomy): string
    {
        if ($this->isTaxonomy($taxonomy)) {
            $url = $this->fn($url, $term);
        }

        return $url;
    }
}
