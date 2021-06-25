<?php

declare(strict_types=1);

namespace Fire\Tests\Post;

use Fire\Admin\ListTableColumn;
use Fire\Post\Type;

final class TypeStub extends Type
{
    public const TYPE = 'test';

    public function doRegisterTypeFrom(callable $fn): void
    {
        $this->registerTypeFrom($fn);
    }

    public function doModifyType(callable $fn): void
    {
        $this->modifyType($fn);
    }

    public function doAddSupport(array $supports): void
    {
        $this->addSupport($supports);
    }

    public function doRemoveSupport(string ...$supports): void
    {
        $this->removeSupport(...$supports);
    }

    public function doModifyTitlePlaceholder(callable $fn): void
    {
        $this->modifyTitlePlaceholder($fn);
    }

    public function doModifyArchiveTitle(callable $fn): void
    {
        $this->modifyArchiveTitle($fn);
    }

    public function doModifyLink(callable $fn): void
    {
        $this->modifyLink($fn);
    }

    public function doSetOnQuery(array $data): void
    {
        $this->setOnQuery($data);
    }

    public function doSetOnFrontendQuery(array $data): void
    {
        $this->setOnFrontendQuery($data);
    }

    public function doSetOnAdminQuery(array $data): void
    {
        $this->setOnAdminQuery($data);
    }

    public function doModifyQuery(callable $fn): void
    {
        $this->modifyQuery($fn);
    }

    public function doModifyFrontendQuery(callable $fn): void
    {
        $this->modifyFrontendQuery($fn);
    }

    public function doModifyAdminQuery(callable $fn): void
    {
        $this->modifyAdminQuery($fn);
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

    public function doRegisterArchivePageSetting(): void
    {
        $this->registerArchivePageSetting();
    }
}
