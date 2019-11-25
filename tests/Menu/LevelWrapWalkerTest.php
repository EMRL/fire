<?php

declare(strict_types=1);

namespace Fire\Tests\Menu;

use Fire\Menu\LevelWrapWalker;
use PHPUnit\Framework\TestCase;

final class LevelWrapWalkerTest extends TestCase
{
    public function testStart(): void
    {
        $output = '';
        (new LevelWrapWalker())->start_lvl($output);

        $this->assertSame(
            '<div>Start',
            $output
        );
    }

    public function testEnd(): void
    {
        $output = '';
        (new LevelWrapWalker())->end_lvl($output);

        $this->assertSame(
            'End</div>',
            $output
        );
    }

    public function testCustomTags(): void
    {
        $output = '';
        $walker = (new LevelWrapWalker())->setTags('<', '>');
        $walker->start_lvl($output);
        $walker->end_lvl($output);

        $this->assertSame(
            '<StartEnd>',
            $output
        );
    }

    public function testClosure()
    {
        $output = '';

        $walker = (new LevelWrapWalker())->setTagsFrom(function (callable $setTags, int $depth): void {
            $setTags("$depth", '>');
        });

        $walker->start_lvl($output);
        $walker->start_lvl($output, 1);
        $walker->end_lvl($output, 1);
        $walker->end_lvl($output);

        $this->assertSame(
            '0Start1StartEnd>End>',
            $output
        );
    }
}
