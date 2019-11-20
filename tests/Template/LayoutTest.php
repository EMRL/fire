<?php

declare(strict_types=1);

namespace Fire\Tests\Template;

use Fire\Template\Layout;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\when;

final class LayoutTest extends TestCase
{
    public function testAddsFilters(): void
    {
        $instance = (new Layout())->register();
        $this->assertTrue(has_filter('template_include', [$instance, 'include']));
    }

    public function testDefaultLayoutReturned(): void
    {
        $layout = (new Layout('layout.php'))
            ->setLayoutFor('page.php', 'layout.page.php');

        $this->assertSame(
            ['layout.php'],
            $layout->layoutsForTemplate('/var/www/index.php'),
            'Default layout is returned for template'
        );
    }

    public function testCurrentTemplate(): void
    {
        $layout = new Layout();
        $layout->layoutsForTemplate('/var/www/index.php');

        $this->assertSame(
            'index.php',
            $layout->current(),
            'Current template is returned'
        );
    }

    public function testOtherLayout(): void
    {
        $layout = (new Layout('layout.php'))
            ->setLayoutFor('page.php', 'layout.page.php')
            ->setLayoutFor('archive.php', 'layout.archive.php');

        $this->assertSame(
            ['layout.page.php', 'layout.php'],
            $layout->layoutsForTemplate('/var/www/page.php'),
            'Other layout is returned for template'
        );
    }

    public function testContentReturned(): void
    {
        when('locate_template')->alias(function (array $arr): void {
            echo $arr[0];
        });

        $layout = new Layout();
        $layout->layoutsForTemplate('/var/www/index.php');

        $this->assertSame(
            'index.php',
            (string) $layout
        );
    }
}
