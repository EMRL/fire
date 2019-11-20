<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\Query;
use Fire\Tests\TestCase;
use WP_Query;

final class QueryTest extends TestCase
{
    public function testAddsActions(): void
    {
        $instance = (new Query('', $this->emptyFn()))->register();
        $this->assertTrue(has_action('pre_get_posts', [$instance, 'run']));
    }

    public function testFromSet(): void
    {
        $query = $this->wpQuery();

        $query->shouldReceive('set')
            ->once()
            ->with('key', 'value');

        (new Query('post', Query::set(['key' => 'value'])))->run($query);
    }

    public function testQuery(): void
    {
        $fn = function (WP_Query $query): void {
            $query->set('key', 'value');
        };

        $query = $this->wpQuery();

        $query->shouldReceive('set')
            ->once()
            ->with('key', 'value');

        (new Query('post', $fn))->run($query);
    }

    public function testDoesNotModifyOtherTypes(): void
    {
        $query = $this->wpQuery();
        $query->shouldNotReceive('set');

        (new Query('other', Query::set(['key' => 'value'])))->run($query);
    }

    public function testOnlyModifiesMainQuery(): void
    {
        $query = parent::wpQuery();

        $query->shouldReceive('is_main_query')
            ->once()
            ->andReturn(false);

        $query->shouldNotReceive('get');
        $query->shouldNotReceive('set');

        (new Query('post', Query::set(['key' => 'value'])))->run($query);
    }

    protected function wpQuery(): WP_Query
    {
        $query = parent::wpQuery();

        $query->shouldReceive('is_main_query')
            ->once()
            ->andReturn(true);

        $query->shouldReceive('get')
            ->once()
            ->with('post_type')
            ->andReturn('post');

        return $query;
    }
}
