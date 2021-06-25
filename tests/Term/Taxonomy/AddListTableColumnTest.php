<?php

declare(strict_types=1);

namespace Fire\Tests\Term\Taxonomy;

use DownloadColumn;
use Fire\Term\Taxonomy\AddListTableColumn;
use Fire\Tests\TestCase;

use function Fire\Template\buffer;

final class AddListTableColumnTest extends TestCase
{
    public function testColumns(): void
    {
        $column = new DownloadColumn();

        $this->assertSame(
            ['title' => 'Title', $column->key() => $column->label()],
            (new AddListTableColumn($column))->columns('', true)(['title' => 'Title']),
        );

        $this->assertSame(
            [$column->key() => $column->label(), 'title' => 'Title'],
            (new AddListTableColumn($column))->columns('title', false)(['title' => 'Title']),
            'Insert before',
        );
    }

    public function testDisplay(): void
    {
        $this->assertSame(
            'id:1',
            buffer(function (): void {
                (new AddListTableColumn(new DownloadColumn()))->display()('', 'download', 1);
            }),
        );
    }

    public function testDisplayOther(): void
    {
        $this->assertSame(
            '',
            buffer(function (): void {
                (new AddListTableColumn(new DownloadColumn()))->display()('', 'other', 1);
            }),
        );
    }
}
