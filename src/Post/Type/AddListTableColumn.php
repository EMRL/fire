<?php

declare(strict_types=1);

namespace Fire\Post\Type;

use Closure;
use Fire\Admin\ListTableColumn;
use WP_Query;

use function Fire\Core\filter_insert;
use function Fire\Core\filter_merge;

class AddListTableColumn
{
    /** @var ListTableColumn $column */
    protected $column;

    public function __construct(ListTableColumn $column)
    {
        $this->column = $column;
    }

    public function columns(string $ref, bool $after): Closure
    {
        return filter_insert([$this->column->key() => $this->column->label()], $ref, $after);
    }

    public function display(): Closure
    {
        return function (string $key, int $id): void {
            if ($key === $this->column->key()) {
                $this->column->display($id);
            }
        };
    }

    public function sortableColumns(): Closure
    {
        return filter_merge([$this->column->key() => $this->column->key()]);
    }

    public function query(): Closure
    {
        return function (WP_Query $query): void {
            if (is_admin() && $query->get('orderby') === $this->column->key()) {
                $this->column->sort($query);
            }
        };
    }
}
