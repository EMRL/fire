<?php

declare(strict_types=1);

namespace Fire\Tests\Admin;

use Fire\Admin\RemoveDashboardWidgets;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\expect;

final class RemoveDashboardWidgetsTest extends TestCase
{
    public function testActionsAdded(): void
    {
        $instance = (new RemoveDashboardWidgets())->register();
        $this->assertTrue(has_action('wp_dashboard_setup', [$instance, 'remove']));
    }

    public function testRemoveIsCalled(): void
    {
        expect('remove_meta_box')
            ->once()
            ->with('a', 'dashboard', 'normal');

        expect('remove_meta_box')
            ->once()
            ->with('a', 'dashboard', 'side');

        (new RemoveDashboardWidgets('a'))->register()->remove();
    }
}
