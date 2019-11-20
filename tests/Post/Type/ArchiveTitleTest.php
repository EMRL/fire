<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\ArchiveTitle;
use Fire\Tests\TestCase;

use function Fire\Core\filter_value;

final class ArchiveTitleTest extends TestCase
{
    public function testAddsFilters(): void
    {
        $instance = (new ArchiveTitle('', filter_value('')))->register();
        $this->assertTrue(has_filter('post_type_archive_title', [$instance, 'run']));
    }

    public function testArchiveTitle(): void
    {
        $type = 'post';

        $fn = function (string $title): string {
            return $title.'-Test';
        };

        $this->assertSame(
            'Something-Test',
            (new ArchiveTitle($type, $fn))->run('Something', $type)
        );
    }

    public function testDoesNotModifyOtherTypes(): void
    {
        $value = 'Something';

        $this->assertSame(
            $value,
            (new ArchiveTitle('post', filter_value('Test')))->run($value, 'other')
        );
    }
}
