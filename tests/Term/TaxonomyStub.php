<?php

declare(strict_types=1);

namespace Fire\Tests\Term;

use Fire\Admin\ListTableColumn;
use Fire\Term\Taxonomy;

final class TaxonomyStub extends Taxonomy
{
    public const TAXONOMY = 'test';

    public function doRegisterTaxonomyFrom(callable $fn, string ...$types): void
    {
        $this->registerTaxonomyFrom($fn, ...$types);
    }

    public function doModifyTaxonomy(callable $fn): void
    {
        $this->modifyTaxonomy($fn);
    }

    public function doRegisterForType(string $type): void
    {
        $this->registerForType($type);
    }

    public function doModifyLink(callable $fn): void
    {
        $this->modifyLink($fn);
    }

    public function doModifyListTableColumns(callable $fn): void
    {
        $this->modifyListTableColumns($fn);
    }

    public function doModifySortableListTableColumns(callable $fn): void
    {
        $this->modifySortableListTableColumns($fn);
    }

    public function doModifyListTableColumnDisplay(callable $fn): void
    {
        $this->modifyListTableColumnDisplay($fn);
    }

    public function doAddListTableColumn(ListTableColumn $column, string $ref = '', bool $after = true): void
    {
        $this->addListTableColumn($column, $ref, $after);
    }
}
