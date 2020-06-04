<?php

declare(strict_types=1);

namespace Fire\Tests;

use Closure;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use WP_Query;

use function Brain\Monkey\setUp;
use function Brain\Monkey\tearDown;

abstract class TestCase extends PHPUnitTestCase
{
    use MockeryPHPUnitIntegration;

    protected function setUp(): void
    {
        parent::setUp();
        setUp();
    }

    protected function tearDown(): void
    {
        tearDown();
        parent::tearDown();
    }

    protected function wpQuery(): WP_Query
    {
        /** @var WP_Query */
        $query = Mockery::mock('WP_Query');
        return $query;
    }

    protected function emptyFn(): Closure
    {
        return function (): void {
        };
    }
}
