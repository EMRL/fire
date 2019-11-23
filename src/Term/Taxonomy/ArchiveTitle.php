<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

use Fire\Term\Category;
use Fire\Term\Tag;

class ArchiveTitle extends Hook
{
    public function register(): Hook
    {
        $term = [
            Category::TAXONOMY => 'cat',
            Tag::TAXONOMY => 'tag',
        ][$this->taxonomy] ?? 'term';

        add_filter(sprintf('single_%s_title', $term), [$this, 'run']);
        return $this;
    }

    public function run(string $title): string
    {
        $term = get_queried_object();

        if (isset($term->taxonomy) && $this->isTaxonomy($term->taxonomy)) {
            $title = $this->fn($title);
        }

        return $title;
    }
}
