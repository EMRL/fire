<?php

declare(strict_types=1);

namespace Fire\Tests\Post;

use Fire\Post\Type\ArchivePageSetting;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\expect;
use function Fire\Post\id;
use function Fire\Post\page_id_for_type;

final class FunctionsTest extends TestCase
{
    public function testPageIdForType(): void
    {
        $type = 'custom';
        $id = 1;

        expect('get_option')
            ->once()
            ->with(ArchivePageSetting::optionName($type))
            ->andReturn($id);

        $this->assertSame(
            $id,
            page_id_for_type($type)
        );
    }

    public function testPageIdForTypeWithPosts(): void
    {
        $id = 1;

        expect('get_option')
            ->once()
            ->with(ArchivePageSetting::optionName('posts'))
            ->andReturn($id);

        $this->assertSame(
            $id,
            page_id_for_type('post')
        );
    }

    public function testId(): void
    {
        $id = 1;

        expect('get_the_ID')
            ->once()
            ->andReturn($id);

        expect('is_home')
            ->once()
            ->andReturn(false);

        expect('is_post_type_archive')
            ->once()
            ->andReturn(false);

        $this->assertSame($id, id());
    }

    public function testIdIsHome(): void
    {
        expect('get_the_ID')
            ->once()
            ->andReturn(1);

        expect('is_home')
            ->once()
            ->andReturn(true);

        expect('get_post_type')
            ->once()
            ->andReturn('post');

        expect('get_option')
            ->once()
            ->with(ArchivePageSetting::optionName('posts'))
            ->andReturn(2);

        $this->assertSame(2, id());
    }
}
