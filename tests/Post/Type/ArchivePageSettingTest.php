<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\ArchivePageSetting;
use Fire\Tests\Post\TypeStub;
use Fire\Tests\TestCase;
use Mockery;
use WP_Post;
use WP_Post_Type;

use function Brain\Monkey\Functions\expect;

final class ArchivePageSettingTest extends TestCase
{
    public function testStates(): void
    {
        $this->typeObject();
        $this->getOption();

        $this->assertSame(
            ['one', 'test' => 'Tests Page'],
            (new ArchivePageSetting($this->type()))->states()(['one'], $this->post())
        );
    }

    public function testOtherPostType(): void
    {
        $this->getOption();

        $post = $this->post();
        $post->post_type = 'post';

        $this->assertSame(
            ['one'],
            (new ArchivePageSetting($this->type()))->states()(['one'], $post)
        );
    }

    public function testOtherPostId(): void
    {
        $this->getOption(2);

        $this->assertSame(
            ['one'],
            (new ArchivePageSetting($this->type()))->states()(['one'], $this->post())
        );
    }

    protected function getOption(int $value = 1): void
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

    protected function type(): TypeStub
    {
        return new TypeStub();
    }

    protected function post(): WP_Post
    {
        /** @var WP_Post $post */
        $post = Mockery::mock('WP_Post');
        $post->post_type = 'page';
        $post->ID = 1;
        return $post;
    }
}
