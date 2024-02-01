<?php

declare(strict_types=1);

namespace Fire\Query;

use Generator;
use IteratorAggregate;
use WP_Query;

class PostQuery extends WP_Query implements IteratorAggregate
{
    public function getIterator(): Generator
    {
        try {
            while ($this->have_posts()) {
                $this->the_post();
                yield $this->post;
            }
        } finally {
            $this->rewind_posts();
            wp_reset_postdata();
        }
    }
}
