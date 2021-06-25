<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\Hooks;
use Fire\Tests\TestCase;
use Mockery;
use WP_Post;

use function Brain\Monkey\Actions\expectDone;
use function Brain\Monkey\Filters\expectApplied;

final class HooksTest extends TestCase
{
    public function testRegisterAddsHooks(): void
    {
        $instance = $this->hooks()->register();
        $this->assertIsInt(has_filter('register_post_type_args', [$instance, 'registerPostTypeArgs']));
        $this->assertIsInt(has_filter('enter_title_here', [$instance, 'enterTitleHere']));
        $this->assertIsInt(has_filter('post_type_archive_title', [$instance, 'postTypeArchiveTitle']));
        $this->assertIsInt(has_filter('post_type_link', [$instance, 'postTypeLink']));
        $this->assertIsInt(has_action('pre_get_posts', [$instance, 'preGetPosts']));
    }

    public function testRegisterPostTypeArgs(): void
    {
        $args = [];

        expectApplied('fire/register_post_type_args/post')
            ->once()
            ->with($args);

        $this->hooks()->registerPostTypeArgs($args, 'post');
    }

    public function testEnterTitleHere(): void
    {
        $placeholder = 'Placeholder';
        $post = $this->post();

        expectApplied('fire/enter_title_here/post')
            ->once()
            ->with($placeholder, $post);

        $this->hooks()->enterTitleHere($placeholder, $post);
    }

    public function testPostTypeArchiveTitle(): void
    {
        $title = 'Title';

        expectApplied('fire/post_type_archive_title/post')
            ->once()
            ->with($title);

        $this->hooks()->postTypeArchiveTitle($title, 'post');
    }

    public function testPostTypeLink(): void
    {
        $url = 'url';
        $post = $this->post();

        expectApplied('fire/post_type_link/post')
            ->once()
            ->with($url, $post);

        $this->hooks()->postTypeLink($url, $post);
    }

    public function testPreGetPosts(): void
    {
        $query = $this->wpQuery();

        $query->shouldReceive('get')
            ->once()
            ->with('post_type')
            ->andReturn('post');

        $query->shouldReceive('is_main_query')
            ->once()
            ->andReturn(true);

        expectDone('fire/pre_get_posts/post')
            ->once()
            ->with($query);

        expectDone('fire/pre_get_posts/post/main')
            ->once()
            ->with($query);

        $this->hooks()->preGetPosts($query);
    }

    public function testPreGetPostsNotMainQuery(): void
    {
        $query = $this->wpQuery();

        $query->shouldReceive('get')
            ->once()
            ->with('post_type')
            ->andReturn('post');

        $query->shouldReceive('is_main_query')
            ->once()
            ->andReturn(false);

        $this->hooks()->preGetPosts($query);

        $this->assertSame(0, did_action('fire/pre_get_posts/post/main'));
    }

    public function testPreGetPostsNoPostType(): void
    {
        $query = $this->wpQuery();

        $query->shouldReceive('get')
            ->once()
            ->with('post_type')
            ->andReturn('');

        $this->hooks()->preGetPosts($query);

        $this->assertSame(0, did_action('fire/pre_get_posts/'));
    }

    protected function hooks(): Hooks
    {
        return new Hooks();
    }

    protected function post(): WP_Post
    {
        /** @var WP_Post $post */
        $post = Mockery::mock('WP_Post');
        $post->post_type = 'post';
        return $post;
    }
}
