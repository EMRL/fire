<?php

declare(strict_types=1);

namespace Fire\Tests\Query;

use Fire\Query\ResolveAs404;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\when;

final class ResolveAs404Test extends TestCase
{
    public function testActionsAdded(): void
    {
        $instance = (new ResolveAs404())->register();
        $this->assertTrue(has_action('parse_query', [$instance, 'parse']));
    }

    public function testResolves(): void
    {
        when('status_header')->justReturn();

        $query = $this->wpQuery();
        $query->shouldReceive('is_main_query')->andReturn(true);
        $query->shouldReceive('init', 'parse_query', 'set_404');

        $resolve = new ResolveAs404(
            function (): bool { return false; },
            function (): bool { return true; }
        );

        $resolve->parse($query);
        $this->assertTrue($resolve->is404());
    }

    public function testReturnIfNotMainQuery(): void
    {
        $query = $this->wpQuery();
        $query->shouldReceive('is_main_query')->andReturn(false);

        $called = false;

        $test = function () use (&$called): void {
            $called = true;
        };

        (new ResolveAs404($test))->parse($query);
        $this->assertFalse($called);
    }

    public function testDoesNotResolve(): void
    {
        $query = $this->wpQuery();
        $query->shouldReceive('is_main_query')->andReturn(true);

        $resolve = new ResolveAs404(
            function (): bool { return false; },
            function (): int { return 0; }
        );

        $resolve->parse($query);
        $this->assertFalse($resolve->is404());
    }
}
