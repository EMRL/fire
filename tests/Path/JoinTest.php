<?php

declare(strict_types=1);

namespace Fire\Tests\Path;

use Fire\Path\Join;
use Fire\Path\JoinManifest;
use PHPUnit\Framework\TestCase;

final class JoinTest extends TestCase
{
    public function testJoin(): void
    {
        $join = new Join('/var/www/app');
        $this->assertSame('/var/www/app/dist/file.jpg', $join->path('dist/file.jpg'));
    }

    public function testManifest(): void
    {
        $dir = __DIR__;
        $join = new JoinManifest(new Join($dir), 'fixtures/manifest.json');
        $this->assertSame($dir.'/file.12345.jpg', $join->path('file.jpg'));
        $this->assertSame($dir.'/dist/missing.txt', $join->path('/dist/missing.txt'), 'Missing file');
    }
}
