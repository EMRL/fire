<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\Support;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\expect;

final class SupportTest extends TestCase
{
    public function testAddSupport(): void
    {
        $type = 'post';
        $test1 = 'test1';
        $test2 = 'test2';
        $test2_args = ['testvalue'];
        $supports = [$test1, $test2 => $test2_args];

        expect('add_post_type_support')
            ->once()
            ->with($type, $test1);

        expect('add_post_type_support')
            ->once()
            ->with($type, $test2, $test2_args);

        (new Support($type, $supports))();
    }

    public function testRemoveSupport(): void
    {
        $type = 'post';
        $supports = ['test1', 'test2'];

        expect('remove_post_type_support')
            ->once()
            ->with($type, $supports[0]);

        expect('remove_post_type_support')
            ->once()
            ->with($type, $supports[1]);

        (new Support($type, $supports))->remove();
    }
}
