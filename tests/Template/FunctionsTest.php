<?php

declare(strict_types=1);

namespace Fire\Tests\Template;

use Fire\Tests\TestCase;

use function Brain\Monkey\Functions\expect;
use function Fire\Template\buffer;
use function Fire\Template\html_attributes;

final class FunctionsTest extends TestCase
{
    public function testBuffer(): void
    {
        $this->assertSame(
            buffer(function (): void {
                echo 'hello world';
            }),
            'hello world',
            'Buffer returns string'
        );
    }

    public function testHtmlAttributes(): void
    {
        expect('esc_attr')
            ->times(4)
            ->andReturnFirstArg();

        $this->assertSame(
            html_attributes([
                'one' => 'wide&tall',
                'two' => 55,
                'three' => null,
                'four' => false,
                'five' => true,
            ]),
            ' one="wide&tall" two="55" three="" four="" five',
            'String, integer, null, and boolean attributes'
        );

        $this->assertSame(
            html_attributes([]),
            '',
            'Empty array'
        );
    }
}
