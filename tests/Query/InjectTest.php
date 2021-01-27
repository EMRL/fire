<?php

declare(strict_types=1);

namespace Fire\Tests\Query;

use Fire\Query\Inject;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\when;

final class InjectTest extends TestCase
{
    public function testActionsAdded(): void
    {
        when('is_admin')->justReturn(false);
        $instance = (new Inject([]))->register();
        $this->assertIsInt(has_action('parse_query', [$instance, 'parse']));
    }

    public function testActionsNotAddedWhenAdmin(): void
    {
        when('is_admin')->justReturn(true);
        $instance = (new Inject([]))->register();
        $this->assertFalse(has_action('parse_query', [$instance, 'parse']));
    }

    public function testQuerySet(): void
    {
        $query = $this->wpQuery();

        $query->shouldReceive('set')
            ->once()
            ->with('a', 'A');

        $query->shouldReceive('set')
            ->once()
            ->with('b', 'B');

        (new Inject(['a' => 'A', 'b' => 'B']))->parse($query);
    }
}
