<?php

declare(strict_types=1);

namespace Fire\Tests\Term\Taxonomy;

use Fire\Term\Category;
use Fire\Term\Taxonomy\ArchiveTitle;
use Fire\Tests\TestCase;
use stdClass;

use function Brain\Monkey\Functions\when;
use function Fire\Core\filter_value;

final class ArchiveTitleTest extends TestCase
{
    public function testAddsFilters(): void
    {
        $instance = (new ArchiveTitle('', filter_value('')))->register();
        $this->assertTrue(has_filter('single_term_title', [$instance, 'run']));

        $instance = (new ArchiveTitle(Category::TAXONOMY, filter_value('')))->register();
        $this->assertTrue(has_filter('single_cat_title', [$instance, 'run']));
    }

    public function testArchiveTitle(): void
    {
        when('get_queried_object')->justReturn((object) ['taxonomy' => 'cat']);

        $fn = function (string $title): string {
            return $title.'-Test';
        };

        $this->assertSame(
            'Something-Test',
            (new ArchiveTitle('cat', $fn))->run('Something')
        );
    }

    public function testDoesNotModifyOtherTypes(): void
    {
        when('get_queried_object')->justReturn((object) ['taxonomy' => 'other']);

        $value = 'Something';

        $this->assertSame(
            $value,
            (new ArchiveTitle('cat', filter_value('Test')))->run($value)
        );
    }
}
