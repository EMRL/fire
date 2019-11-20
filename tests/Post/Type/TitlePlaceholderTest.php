<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\TitlePlaceholder;
use Fire\Tests\TestCase;
use Mockery;
use WP_Post;

use function Fire\Core\filter_value;

final class TitlePlaceholderTest extends TestCase
{
    public function testAddsFilters(): void
    {
        $instance = (new TitlePlaceholder('', filter_value('')))->register();
        $this->assertTrue(has_filter('enter_title_here', [$instance, 'run']));
    }

    public function testTitlePlaceholder(): void
    {
        $fn = function (string $placeholder, WP_Post $post): string {
            return $placeholder.'-Test-'.$post->post_type;
        };

        $this->assertSame(
            'Something-Test-post',
            (new TitlePlaceholder('post', $fn))->run('Something', $this->post())
        );
    }

    public function testDoesNotModifyOtherTypes(): void
    {
        $value = 'Something';

        $post = $this->post();
        $post->post_type = 'other';

        $this->assertSame(
            $value,
            (new TitlePlaceholder('post', filter_value('Test')))->run($value, $post)
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
