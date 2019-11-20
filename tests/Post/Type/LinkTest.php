<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\Link;
use Fire\Tests\TestCase;
use Mockery;
use WP_Post;

final class LinkTest extends TestCase
{
    public function testAddsFilters(): void
    {
        $instance = (new Link('', $this->emptyFn()))->register();
        $this->assertTrue(has_filter('post_type_link', [$instance, 'run']));
    }

    public function testLink(): void
    {
        $fn = function (string $url, WP_Post $post): string {
            return $url.'-Test-'.$post->post_type;
        };

        $this->assertSame(
            'Something-Test-post',
            (new Link('post', $fn))->run('Something', $this->post())
        );
    }

    public function testDoesNotModifyOtherTypes(): void
    {
        $value = 'Something';

        $post = $this->post();
        $post->post_type = 'other';

        $fn = function (string $url, WP_Post $post): string {
            return $url.'-Test-'.$post->post_type;
        };

        $this->assertSame(
            $value,
            (new Link('post', $fn))->run($value, $post)
        );
    }

    protected function post(): WP_Post
    {
        /** @var WP_Post $post */
        $post = Mockery::mock('WP_Post');
        $post->post_type = 'post';
        return $post;
    }
}
