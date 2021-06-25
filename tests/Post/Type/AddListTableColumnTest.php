<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use DownloadColumn;
use Fire\Post\Type\AddListTableColumn;
use Fire\Tests\TestCase;
use SortableDownloadColumn;

use function Brain\Monkey\Functions\when;
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
                (new AddListTableColumn(new DownloadColumn()))->display()('download', 1);
            }),
        );
    }

    public function testDisplayOther(): void
    {
        $this->assertSame(
            '',
            buffer(function (): void {
                (new AddListTableColumn(new DownloadColumn()))->display()('other', 1);
            }),
        );
    }

    public function testSortableColumns(): void
    {
        $column = new SortableDownloadColumn();

        $this->assertSame(
            ['title' => 'title', $column->key() => $column->key()],
            (new AddListTableColumn($column))->sortableColumns()(['title' => 'title']),
        );
    }

    public function testQuery(): void
    {
        when('is_admin')->justReturn(true);

        $query = $this->wpQuery();

        $query->shouldReceive('get')
            ->once()
            ->with('orderby')
            ->andReturn('download');

        $query->shouldReceive('set')
            ->once()
            ->with('meta_key', 'download');

        $query->shouldReceive('set')
            ->once()
            ->with('orderby', 'meta_value');

        (new AddListTableColumn(new SortableDownloadColumn()))->query()($query);
    }

    public function testQueryNotAdmin(): void
    {
        when('is_admin')->justReturn(false);
        $query = $this->wpQuery();
        $query->shouldNotReceive('get');
        (new AddListTableColumn(new SortableDownloadColumn()))->query()($query);
    }

    public function testQueryOtherOrder(): void
    {
        when('is_admin')->justReturn(true);

        $query = $this->wpQuery();

        $query->shouldReceive('get')
            ->once()
            ->with('orderby')
            ->andReturn('other');

        $query->shouldNotReceive('set');

        (new AddListTableColumn(new SortableDownloadColumn()))->query()($query);
    }
}
