<?php

declare(strict_types=1);

namespace Fire\Admin;

abstract class ListTableColumn
{
    /** @var string $key */
    protected $key;

    /** @var string $label */
    protected $label;

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
