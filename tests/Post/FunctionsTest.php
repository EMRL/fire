<?php

declare(strict_types=1);

namespace Fire\Tests\Post;

use Fire\Post\Type\ArchivePageSetting;
use Fire\Post\Type\Support;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\expect;
use function Brain\Monkey\Functions\when;
use function Fire\Post\id;
use function Fire\Post\page_id_for_type;

final class FunctionsTest extends TestCase
{
    public function testPageIdForType(): void
    {
        $type = 'custom';
        $id = 1;

        when('is_home')->justReturn(false);

        expect('post_type_supports')
            ->once()
            ->with($type, Support::ARCHIVE_PAGE)
            ->andReturn(true);

        expect('get_option')
            ->once()
            ->with(ArchivePageSetting::optionName($type))
            ->andReturn($id);

        $this->assertSame($id, page_id_for_type($type));
    }

    public function testPageIdForTypeWithPosts(): void
    {
        $id = 1;

        when('is_home')->justReturn(false);

        expect('post_type_supports')
            ->once()
            ->with('post', Support::ARCHIVE_PAGE)
            ->andReturn(true);

        expect('get_option')
            ->once()
            ->with(ArchivePageSetting::optionName('posts'))
            ->andReturn($id);

        $this->assertSame($id, page_id_for_type('post'));
    }

    public function testPageIdForTypeIsHome(): void
    {
        $id = 1;

        when('is_home')->justReturn(true);

        expect('get_query_var')
            ->once()
            ->andReturn('');

        expect('post_type_supports')
            ->once()
            ->with('post', Support::ARCHIVE_PAGE)
            ->andReturn(true);

        expect('get_option')
            ->once()
            ->with(ArchivePageSetting::optionName('posts'))
            ->andReturn($id);

        $this->assertSame($id, page_id_for_type());
    }

    public function testPageIdForTypeIsHomeDoesNotSupport(): void
    {
        when('is_home')->justReturn(true);

        expect('get_query_var')
            ->once()
            ->andReturn('');

        expect('post_type_supports')
            ->once()
            ->with('post', Support::ARCHIVE_PAGE)
            ->andReturn(false);

        $this->assertSame(0, page_id_for_type());
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
            ->twice()
            ->andReturn(true);

        expect('get_query_var')
            ->once()
            ->andReturn('');

        expect('post_type_supports')
            ->once()
            ->with('post', Support::ARCHIVE_PAGE)
            ->andReturn(true);

        expect('get_option')
            ->once()
            ->with(ArchivePageSetting::optionName('posts'))
            ->andReturn(2);

        $this->assertSame(2, id());
    }
}
