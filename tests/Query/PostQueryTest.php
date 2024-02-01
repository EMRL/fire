<?php

declare(strict_types=1);

namespace Fire\Tests\Query;

use Fire\Query\PostQuery;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\when;

final class PostQueryTest extends TestCase
{
    public function testIterator(): void
    {
        when('wp_reset_postdata')->alias(function () {
            return PostQuery::setGlobalPost(1);
        });

        $query = new PostQuery(['second', 'third']);

        $this->assertTrue(is_iterable($query), 'Is iterable');

        $posts = [];

        foreach ($query as $index => $post) {
            $posts[] = $post;

            if ($index === 0) {
                $this->assertSame(0, PostQuery::globalPost(), 'Global is set each pass');
            }
        }

        $this->assertSame(['second', 'third'], $posts, 'Makes value available during iteration');
        $this->assertSame(1, PostQuery::globalPost(), 'Global variable is reset');
        $this->assertSame(-1, $query->current(), 'Query is rewound');
    }
}
