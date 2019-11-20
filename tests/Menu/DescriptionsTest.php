<?php

declare(strict_types=1);

namespace Fire\Tests\Menu;

use Fire\Menu\Descriptions;
use Fire\Tests\TestCase;
use Mockery;
use WP_Post;

use function Brain\Monkey\Functions\when;

final class DescriptionsTest extends TestCase
{
    protected $args = [
        'before' => '',
        'link_before' => '',
        'link_after' => '',
        'after' => '',
    ];

    public function testFiltersAdded(): void
    {
        $instance = (new Descriptions())->register();
        $this->assertTrue(has_filter('wp_nav_menu_args', [$instance, 'args']));
        $this->assertTrue(has_filter('nav_menu_item_args', [$instance, 'item']));
    }

    public function testArgs(): void
    {
        $this->assertSame(
            [
                'before' => '',
                'link_before' => '',
                'link_after' => '',
                'after' => '',
                '__before' => '',
                '__link_before' => '',
                '__link_after' => '',
                '__after' => '',
                'descriptions' => '<div>%s</div>',
            ],
            (new Descriptions())->args($this->args)
        );
    }

    public function testItem(): void
    {
        when('do_shortcode')->returnArg(1);

        $instance = new Descriptions();

        $args = (object) $instance->args([
            'before' => '',
            'after' => '%s',
        ] + $this->args);

        $item = $this->item();
        $item->description = 'This is description';

        $this->assertSame(
            '<div>This is description</div>',
            $instance->item($args, $item)->after,
            'Sets description'
        );

        $this->assertSame(
            '',
            $instance->item($args, $item)->before,
            'Arguments without placeholder remain'
        );

        $item = $this->item();
        $item->description = '';

        $this->assertSame(
            '',
            $instance->item($args, $item)->after,
            'Items without description remain empty'
        );

        $args = (object) $instance->args([
            'before' => '',
            'after' => 'After',
        ] + $this->args);

        $this->assertSame(
            'After',
            $instance->item($args, $item)->after,
            'Multiple menus continue to work'
        );
    }

    protected function item()
    {
        /** @var WP_Post $item */
        $item = Mockery::mock('WP_Post');
        return $item;
    }
}
