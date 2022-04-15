<?php

declare(strict_types=1);

namespace Fire\Query;

use Generator;
use IteratorAggregate;
use WP_Query;

class Iterator implements IteratorAggregate
{
    public function __construct(
        protected readonly WP_Query $query,
    ) {
    }

    public function getIterator(): Generator
    {
        try {
            while ($this->query->have_posts()) {
                $this->query->the_post();
                yield $this->query->post;
            }
        } finally {
            $this->query->rewind_posts();
            wp_reset_postdata();
        }
    }
}
