<?php

declare(strict_types=1);

namespace Fire\Admin;

abstract class ListTableColumn
{
    protected string $key;

    protected string $label;

    public function key(): string
    {
        return $this->key;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function display(int $id): void
    {
        // Do nothing by default
    }
}
