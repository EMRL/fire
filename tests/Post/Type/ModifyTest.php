<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\Modify;
use Fire\Tests\TestCase;

use function Fire\Core\filter_replace;
use function Fire\Core\filter_value;

final class ModifyTest extends TestCase
{
    public function testAddsFilters(): void
    {
        $instance = (new Modify('', filter_value([])))->register();
        $this->assertTrue(has_filter('register_post_type_args', [$instance, 'run']));
    }

    public function testModify(): void
    {
        $type = 'post';

        $fn = function (array $args): array {
            $args['label'] .= 'Resource';
            return $args;
        };

        $this->assertSame(
            ['label' => 'PostResource'],
            (new Modify($type, $fn))->run(['label' => 'Post'], $type)
        );
    }

    public function testDoesNotModifyOtherTypes(): void
    {
        $config = ['label' => 'Post'];

        $this->assertSame(
            $config,
            (new Modify('post', filter_replace(['label' => 'Resource'])))->run($config, 'other')
        );
    }
}
