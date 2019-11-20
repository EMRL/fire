<?php

declare(strict_types=1);

namespace Fire\Tests\Term\Taxonomy;

use Fire\Term\Taxonomy\Modify;
use Fire\Tests\TestCase;

use function Fire\Core\filter_replace;
use function Fire\Core\filter_value;

final class ModifyTest extends TestCase
{
    public function testAddsFilters(): void
    {
        $instance = (new Modify('', filter_value([])))->register();
        $this->assertTrue(has_filter('register_taxonomy_args', [$instance, 'run']));
    }

    public function testModify(): void
    {
        $taxonomy = 'cat';

        $fn = function (array $args, array $types): array {
            $args['label'] .= 'Category,'.(implode(',', $types));
            return $args;
        };

        $this->assertSame(
            ['label' => 'TagCategory,post,page'],
            (new Modify($taxonomy, $fn))->run(['label' => 'Tag'], $taxonomy, ['post', 'page'])
        );
    }

    public function testDoesNotModifyOtherTypes(): void
    {
        $config = ['label' => 'Tag'];

        $this->assertSame(
            $config,
            (new Modify('cat', filter_replace(['label' => 'Resource'])))->run($config, 'tag', ['post'])
        );
    }
}
