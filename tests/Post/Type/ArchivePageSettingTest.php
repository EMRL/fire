<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\ArchivePageSetting;
use Fire\Tests\TestCase;
use Mockery;
use WP_Post;
use WP_Post_Type;

use function Brain\Monkey\Functions\expect;
use function Brain\Monkey\Functions\when;

final class ArchivePageSettingTest extends TestCase
{
    public function testStates(): void
    {
        $this->typeObject();
        $this->getPageOption(1);

        $this->assertSame(
            ['one', 'test' => 'Tests Page'],
            $this->setting()->states()(['one'], $this->post()),
        );
    }

    public function testStatesLabel(): void
    {
        $this->typeObject();
        $this->getPageOption(1);

        $this->assertSame(
            ['one', 'test' => 'Tests Custom Page'],
            (new ArchivePageSetting(
                'test',
                fn (WP_Post_Type $type): string => $type->label.' Custom',
            ))->states()(['one'], $this->post()),
        );
    }

    public function testStatesOtherPostType(): void
    {
        $this->getPageOption(1);

        $post = $this->post();
        $post->post_type = 'post';

        $this->assertSame(
            ['one'],
            $this->setting()->states()(['one'], $post),
        );
    }

    public function testStatesOtherPostId(): void
    {
        $this->getPageOption(2);

        $this->assertSame(
            ['one'],
            $this->setting()->states()(['one'], $this->post()),
        );
    }

    public function testSlug(): void
    {
        $this->getPageOption(1);

        when('post_type_supports')->justReturn(true);

        expect('get_post_field')
            ->once()
            ->with('post_name', 1)
            ->andReturn('test');

        $this->assertSame(
            ['rewrite' => ['slug' => 'test']],
            $this->setting()->slug()([]),
        );
    }

    public function testSlugNoPage(): void
    {
        $this->getPageOption(0);

        when('post_type_supports')->justReturn(true);

        $this->assertSame(
            [],
            $this->setting()->slug()([]),
        );
    }

    public function testPermalinks(): void
    {
        $id = 1;
        $this->getPageOption($id);

        when('post_type_supports')->justReturn(true);

        $new = $this->post();
        $new->post_name = 'new-slug';

        $old = $this->post();
        $old->post_name = 'old-slug';

        expect('update_option')
            ->once()
            ->with('fire_flush_rewrite', 1);

        $this->setting()->permalinks()($id, $new, $old);
    }

    public function testPermalinksNoChange(): void
    {
        $id = 1;
        $this->getPageOption($id);

        when('post_type_supports')->justReturn(true);

        $new = $this->post();
        $new->post_name = 'slug';

        $old = $this->post();
        $old->post_name = 'slug';

        expect('update_option')
            ->never();

        $this->setting()->permalinks()($id, $new, $old);
    }

    public function testPermalinksOtherPage(): void
    {
        $this->getPageOption(1);

        when('post_type_supports')->justReturn(true);

        $new = $this->post();
        $old = $this->post();

        expect('update_option')
            ->never();

        $this->setting()->permalinks()(2, $new, $old);
    }

    public function testDelete(): void
    {
        $id = 1;
        $this->getPageOption($id);

        when('post_type_supports')->justReturn(true);

        expect('update_option')
            ->once()
            ->with('page_for_test', 0);

        expect('update_option')
            ->once()
            ->with('fire_flush_rewrite', 1);

        $this->setting()->delete()($id);
    }

    public function testDeleteOtherPost(): void
    {
        $this->getPageOption(2);

        when('post_type_supports')->justReturn(true);

        expect('update_option')
            ->never();

        $this->setting()->delete()(1);
    }

    public function testArchiveTitle(): void
    {
        $this->getPageOption(1);

        when('post_type_supports')->justReturn(true);

        $post = $this->post();

        when('get_post_field')
            ->alias(fn ($key) => $post->$key);

        $this->assertSame(
            'Tests Page',
            $this->setting()->archiveTitle()('Tests'),
        );
    }

    public function testArchiveTitleNoPage(): void
    {
        $this->getPageOption(0);

        when('post_type_supports')->justReturn(true);

        $title = 'Tests';

        $this->assertSame(
            $title,
            $this->setting()->archiveTitle()('Tests'),
        );
    }

    public function testFlush(): void
    {
        expect('get_option')
            ->once()
            ->with('fire_flush_rewrite')
            ->andReturn('1');

        expect('flush_rewrite_rules')
            ->once()
            ->withNoArgs();

        expect('update_option')
            ->once()
            ->with('fire_flush_rewrite', 0);

        $this->setting()->flush()();
    }

    public function testFlushNotNeeded(): void
    {
        expect('get_option')
            ->once()
            ->with('fire_flush_rewrite')
            ->andReturn('0');

        $this->setting()->flush()();
    }

    protected function setting(): ArchivePageSetting
    {
        return new ArchivePageSetting('test', null);
    }

    protected function getPageOption(int $value): void
    {
        expect('get_option')
            ->once()
            ->with('page_for_test')
            ->andReturn($value);
    }

    protected function typeObject(): WP_Post_Type
    {
        /** @var WP_Post_Type */
        $type = Mockery::mock('WP_Post_Type');
        $type->label = 'Tests';

        expect('get_post_type_object')
            ->once()
            ->with('test')
            ->andReturn($type);

        return $type;
    }

    protected function post(): WP_Post
    {
        /** @var WP_Post */
        $post = Mockery::mock('WP_Post');
        $post->post_title = 'Tests Page';
        $post->post_type = 'page';
        $post->ID = 1;
        return $post;
    }
}
