<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

use Closure;
use Fire\Admin\ListTableColumn;

use function Fire\Core\filter_insert;

class AddListTableColumn
{
    public function __construct(
        protected readonly ListTableColumn $column,
    ) {
    }

    public function columns(string $ref, bool $after): Closure
    {
        return filter_insert([$this->column->key() => $this->column->label()], $ref, $after);
    }

    public function display(): Closure
    {
        return function (string $_, string $key, int $id): void {
            if ($key === $this->column->key()) {
                $this->column->display($id);
            }
        };
    }
}
