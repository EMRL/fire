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
        $this->assertTrue(has_action('wp', [$instance, 'parse']));
    }

    public function testResolves(): void
    {
        when('status_header')->justReturn();

        $query = $this->wpQuery();
        $query->shouldReceive('init', 'parse_query', 'set_404');
        $GLOBALS['wp_query'] = $query;

        $resolve = new ResolveAs404(
            fn (): bool => false,
            fn (): bool => true,
        );

        $resolve->parse();
        $this->assertTrue($resolve->is404());
        $this->assertFalse(has_action('parse_query', [$resolve, 'parse']));
    }

    public function testDoesNotResolve(): void
    {
        $resolve = new ResolveAs404(
            fn (): bool => false,
            fn (): int => 0,
        );

        $resolve->parse();
        $this->assertFalse($resolve->is404());
    }
}
