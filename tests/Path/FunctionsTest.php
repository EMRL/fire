<?php

declare(strict_types=1);

namespace Fire\Tests\Path;

use PHPUnit\Framework\TestCase;

use function Fire\Path\join_path;

final class FunctionsTest extends TestCase
{
    public function testJoinPath(): void
    {
        $this->assertSame('', join_path('', ''));
        $this->assertSame('/', join_path('', '/'));
        $this->assertSame('/a', join_path('', '/a'));
        $this->assertSame('/a', join_path('/', 'a'));
        $this->assertSame('/a', join_path('/', '/a'));
        $this->assertSame('/a/', join_path('/', '/a/'));
        $this->assertSame('/a/', join_path('//', '/a/'));
        $this->assertSame('abc/def', join_path('abc', 'def'));
        $this->assertSame('abc/def', join_path('abc', '/def'));
        $this->assertSame('/abc/def', join_path('/abc', 'def'));
        $this->assertSame('foo.jpg', join_path('', 'foo.jpg'));
        $this->assertSame('dir/0/a.jpg', join_path('dir', '0', 'a.jpg'));
    }
}
