<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use Fire\Post\Type\Support;
use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\when;

final class SupportTest extends TestCase
{
    public function testAddSupport(): void
    {
        $support = [];

        when('add_post_type_support')
            ->alias(function (string $type, string $feature, array $args = []) use (&$support): void {
                $support[$type] ??= [];
                $support[$type][$feature] = $args ?: true;
            });

        $type = 'post';
        $test1 = 'test1';
        $test2 = 'test2';
        $test2_args = ['testvalue'];
        $supports = [$test1, $test2 => $test2_args];

        (new Support($type, $supports))();

        $this->assertSame(
            [
                $type => [
                    $test1 => true,
                    $test2 => $test2_args,
                ],
            ],
            $support,
        );
    }

    public function testRemoveSupport(): void
    {
        $type = 'post';

        $support = [
            $type => [
                'test1' => true,
                'test2' => ['test' => 'another'],
                'test3' => true,
            ],
        ];

        $supports = ['test1', 'test2'];

        when('remove_post_type_support')->alias(function (string $type, string $feature) use(&$support): void {
            unset($support[$type][$feature]);
        });

        (new Support($type, $supports))->remove();

        $this->assertSame(
            [
                $type => [
                    'test3' => true,
                ]
            ],
            $support,
        );
    }
}
