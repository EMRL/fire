<?php

declare(strict_types=1);

namespace Fire\Query;

use Generator;
use IteratorAggregate;
use WP_Query;

class Iterator implements IteratorAggregate
{
    /** @var WP_Query $query */
    protected $query;

    public function __construct(WP_Query $query)
    {
        $this->query = $query;
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
