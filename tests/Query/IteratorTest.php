<?php

declare(strict_types=1);

namespace Fire\Tests\Query;

use Fire\Query\Iterator;
use Fire\Tests\TestCase;
use WP_Query;

use function Brain\Monkey\Functions\when;

final class IteratorTest extends TestCase
{
    public function testIterator(): void
    {
        when('wp_reset_postdata')->alias(function () {
            return WP_Query::setGlobalPost(1);
        });

        $query = new WP_Query(['second', 'third']);
        $iterator = new Iterator($query);

        $this->assertTrue(is_iterable($iterator), 'Is iterable');

        $posts = [];
        foreach ($iterator as $index => $post) {
            $posts[] = $post;

            if ($index === 0) {
                $this->assertSame(0, WP_Query::globalPost(), 'Global is set each pass');
            }
        }

        $this->assertSame(['second', 'third'], $posts, 'Makes value available during iteration');
        $this->assertSame(1, WP_Query::globalPost(), 'Global variable is reset');
        $this->assertSame(-1, $query->current(), 'Query is rewound');
    }
}
