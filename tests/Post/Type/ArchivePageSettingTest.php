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
        $this->getOption(1);

        $this->assertSame(
            ['one', 'test' => 'Tests Page'],
            (new ArchivePageSetting('test', null))->states()(['one'], $this->post())
        );
    }

    public function testStatesLabel(): void
    {
        $this->typeObject();
        $this->getOption(1);

        $this->assertSame(
            ['one', 'test' => 'Tests Custom Page'],
            (new ArchivePageSetting(
                'test',
                function (WP_Post_Type $type): string {
                    return $type->label.' Custom';
                }
            ))->states()(['one'], $this->post())
        );
    }

    public function testStatesOtherPostType(): void
    {
        $this->getOption(1);

        $post = $this->post();
        $post->post_type = 'post';

        $this->assertSame(
            ['one'],
            (new ArchivePageSetting('test', null))->states()(['one'], $post)
        );
    }

    public function testStatesOtherPostId(): void
    {
        $this->getOption(2);

        $this->assertSame(
            ['one'],
            (new ArchivePageSetting('test', null))->states()(['one'], $this->post())
        );
    }

    public function testSlug(): void
    {
        $this->getOption(1);

        expect('get_post_field')
            ->once()
            ->with('post_name', 1)
            ->andReturn('test');

        $this->assertSame(
            ['rewrite' => ['slug' => 'test']],
            (new ArchivePageSetting('test', null))->slug()([])
        );
    }

    public function testSlugNoPage(): void
    {
        $this->getOption(0);

        $this->assertSame(
            [],
            (new ArchivePageSetting('test', null))->slug()([])
        );
    }

    public function testPermalinks(): void
    {
        $id = 1;
        $this->getOption($id);

        $new = $this->post();
        $new->post_name = 'new-slug';

        $old = $this->post();
        $old->post_name = 'old-slug';

        expect('flush_rewrite_rules')
            ->once()
            ->withNoArgs();

        (new ArchivePageSetting('test', null))->permalinks()($id, $new, $old);
    }

    public function testPermalinksNoChange(): void
    {
        $id = 1;
        $this->getOption($id);

        $new = $this->post();
        $new->post_name = 'slug';

        $old = $this->post();
        $old->post_name = 'slug';

        expect('flush_rewrite_rules')
            ->never();

        (new ArchivePageSetting('test', null))->permalinks()($id, $new, $old);
    }

    public function testPermalinksOtherPage(): void
    {
        $this->getOption(1);

        $new = $this->post();
        $old = $this->post();

        expect('flush_rewrite_rules')
            ->never();

        (new ArchivePageSetting('test', null))->permalinks()(2, $new, $old);
    }

    public function testDelete(): void
    {
        $id = 1;
        $this->getOption($id);

        expect('update_option')
            ->once()
            ->with('page_for_test', 0);

        expect('flush_rewrite_rules')
            ->once()
            ->withNoArgs();

        (new ArchivePageSetting('test', null))->delete()($id);
    }

    public function testDeleteOtherPost(): void
    {
        $this->getOption(2);

        expect('update_option')
            ->never();

        (new ArchivePageSetting('test', null))->delete()(1);
    }

    public function testArchiveTitle(): void
    {
        $this->getOption(1);

        $post = $this->post();

        when('get_post_field')
            ->alias(function ($key) use ($post) {
                return $post->$key;
            });

        $this->assertSame(
            'Tests Page',
            (new ArchivePageSetting('test', null))->archiveTitle()('Tests')
        );
    }

    public function testArchiveTitleNoPage(): void
    {
        $this->getOption(0);

        $title = 'Tests';

        $this->assertSame(
            $title,
            (new ArchivePageSetting('test', null))->archiveTitle()('Tests')
        );
    }

    protected function getOption(int $value): void
    {
        expect('get_option')
            ->once()
            ->with('page_for_test')
            ->andReturn($value);
    }

    protected function typeObject(): WP_Post_Type
    {
        /** @var WP_Post_Type $type */
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
        /** @var WP_Post $post */
        $post = Mockery::mock('WP_Post');
        $post->post_title = 'Tests Page';
        $post->post_type = 'page';
        $post->ID = 1;
        return $post;
    }
}
