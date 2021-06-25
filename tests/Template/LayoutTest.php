<?php

declare(strict_types=1);

namespace Fire\Tests\Template;

use Fire\Template\Layout;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\when;

final class LayoutTest extends TestCase
{
    protected const TEMPLATE_PATH = '/var/www';

    public function testAddsFilters(): void
    {
        $instance = (new Layout())->register();
        $this->assertNotFalse(has_filter('template_include', [$instance, 'include']));
    }

    public function testPriority(): void
    {
        $priority = 50;

        $instance = (new Layout())
            ->setPriority($priority)
            ->register();

        $this->assertSame($priority, has_filter('template_include', [$instance, 'include']));
    }

    public function testDefaultLayoutReturned(): void
    {
        $this->functions();

        $layout = (new Layout('layout.php'))
            ->setLayoutFor('page.php', 'layout.page.php');

        $this->assertSame(
            ['layout.php'],
            $layout->layoutsForTemplate(static::TEMPLATE_PATH.'/index.php'),
            'Default layout is returned for template',
        );
    }

    public function testCurrentTemplate(): void
    {
        $this->functions();

        $layout = new Layout();
        $layout->layoutsForTemplate(static::TEMPLATE_PATH.'/index.php');

        $this->assertSame(
            static::TEMPLATE_PATH.'/index.php',
            $layout->current(),
            'Current template is returned',
        );
    }

    public function testTemplateOutsideTheme(): void
    {
        $this->functions();

        $file = '/var/outside/theme.php';
        $layout = new Layout();
        $layout->layoutsForTemplate($file);

        $this->assertSame(
            $file,
            $layout->current(),
        );
    }

    public function testOtherLayout(): void
    {
        $this->functions();

        $outside = '/var/outside/theme.php';

        $layout = (new Layout('layout.php'))
            ->setLayoutFor('page.php', 'layout.page.php')
            ->setLayoutFor('archive.php', 'layout.archive.php')
            ->setLayoutFor($outside, 'layout.outside.php');

        $this->assertSame(
            ['layout.page.php', 'layout.php'],
            $layout->layoutsForTemplate(static::TEMPLATE_PATH.'/page.php'),
            'Other layout is returned for template',
        );

        $this->assertSame(
            ['layout.outside.php', 'layout.php'],
            $layout->layoutsForTemplate($outside),
            'Other layout is returned for template outside theme',
        );
    }

    public function testContentReturned(): void
    {
        $this->functions();

        when('load_template')->alias(function (string $file): void {
            echo $file;
        });

        $layout = new Layout();
        $layout->layoutsForTemplate(static::TEMPLATE_PATH.'/index.php');

        $this->assertSame(
            static::TEMPLATE_PATH.'/index.php',
            (string) $layout,
        );
    }

    protected function functions(): void
    {
        when('get_theme_file_path')->justReturn(static::TEMPLATE_PATH);
    }
}
