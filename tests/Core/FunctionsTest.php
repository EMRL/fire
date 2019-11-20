<?php

declare(strict_types=1);

namespace Fire\Tests\Core;

use function Fire\Core\array_insert;
use function Fire\Core\filter_insert;
use function Fire\Core\filter_merge;
use function Fire\Core\filter_remove;
use function Fire\Core\filter_remove_key;
use function Fire\Core\filter_value;
use function Fire\Core\parse_hosts;
use function Fire\Core\value;

use Closure;
use PHPUnit\Framework\TestCase;

final class FunctionsTest extends TestCase
{
    public function testValue(): void
    {
        $this->assertSame(
            'hello world',
            value('hello world'),
            'String value'
        );

        $this->assertSame(
            'hello world',
            value(function (): string { return 'hello world'; }),
            'Closure value'
        );

        $this->assertSame(
            'hello world',
            value(function (string $who): string { return 'hello '.$who; }, 'world'),
            'Passes arguments if callable'
        );

        $this->assertSame(
            'hello',
            value('hello', 'world'),
            'Ignores arguments if not callable'
        );
    }

    public function testArrayInsert(): void
    {
        $this->assertSame(
            [1, 2, 3],
            array_insert([1, 3], [2], 0),
            'Insert after, numeric index'
        );

        $this->assertSame(
            [1, 2, 3],
            array_insert([1, 3], [2], 1, false),
            'Insert before, numeric index'
        );

        $this->assertSame(
            [1, 3, 2],
            array_insert([1, 3], [2], -1),
            'Appends if key not found'
        );

        $this->assertSame(
            ['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'],
            array_insert(['a' => 'A', 'd' => 'D'], ['b' => 'B', 'c' => 'C'], 'a'),
            'Insert multiple after'
        );
    }

    public function testFilterInsert(): void
    {
        $value = filter_insert([2], 0);

        $this->assertInstanceOf(
            Closure::class,
            $value,
            'Expect instance of Closure'
        );

        $this->assertSame(
            [1, 2, 3],
            $value([1, 3]),
            'Returns value'
        );
    }

    public function testFilterValue(): void
    {
        $value = filter_value('hello world');

        $this->assertInstanceOf(
            Closure::class,
            $value,
            'Expect instance of Closure'
        );

        $this->assertSame(
            'hello world',
            $value('ignored'),
            'Returns value'
        );
    }

    public function testFilterMerge(): void
    {
        $merge = filter_merge(['c' => 'd']);

        $this->assertInstanceOf(
            Closure::class,
            $merge,
            'Expect instance of Closure'
        );

        $this->assertSame(
            ['a' => 'b', 'c' => 'd'],
            $merge(['a' => 'b']),
            'Returns merged array'
        );
    }

    public function testFilterRemove(): void
    {
        $remove = filter_remove(['c', 'd']);

        $this->assertInstanceOf(
            Closure::class,
            $remove,
            'Expect instance of Closure'
        );

        $this->assertSame(
            ['a', 'b', 'e'],
            array_values($remove(['a', 'b', 'c', 'd', 'e'])),
            'Returns array without values'
        );
    }

    public function testFilterRemoveKey(): void
    {
        $remove = filter_remove_key(['c', 'd']);

        $this->assertInstanceOf(
            Closure::class,
            $remove,
            'Expect instance of Closure'
        );

        $this->assertSame(
            ['a' => 'A', 'b' => 'B', 'e' => 'E'],
            $remove(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D', 'e' => 'E']),
            'Returns array without values'
        );
    }

    public function testParseHosts(): void
    {
        $this->assertSame(
            ['a.co', 'b.com'],
            parse_hosts(['http://a.co', 'b.com', '//']),
        );
    }
}
