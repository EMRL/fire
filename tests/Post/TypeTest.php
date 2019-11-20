<?php

declare(strict_types=1);

namespace Fire\Tests\Post;

use Fire\Post\Type;
use Fire\Tests\TestCase;
use Mockery;
use SortableDownloadColumn;

final class TypeTest extends TestCase
{
    public function testRegisterType(): void
    {
        $this->type()->registerType(['label' => 'Resource']);
        $this->assertTrue(has_action('init'));
    }

    public function testRegisterTypeFrom(): void
    {
        $this->type()->registerTypeFrom($this->emptyFn());
        $this->assertTrue(has_action('init'));
    }

    public function testMergeType(): void
    {
        $this->type()->mergeType([]);
        $this->assertTrue(has_filter('register_post_type_args'));
    }

    public function testModifyType(): void
    {
        $this->type()->modifyType($this->emptyFn());
        $this->assertTrue(has_filter('register_post_type_args'));
    }

    public function testSetTitlePlaceholder(): void
    {
        $this->type()->setTitlePlaceholder('');
        $this->assertTrue(has_filter('enter_title_here'));
    }

    public function testModifyTitlePlaceholder(): void
    {
        $this->type()->modifyTitlePlaceholder($this->emptyFn());
        $this->assertTrue(has_filter('enter_title_here'));
    }

    public function testSetArchiveTitle(): void
    {
        $this->type()->setArchiveTitle('');
        $this->assertTrue(has_filter('post_type_archive_title'));
    }

    public function testModifyArchiveTitle(): void
    {
        $this->type()->modifyArchiveTitle($this->emptyFn());
        $this->assertTrue(has_filter('post_type_archive_title'));
    }

    public function testModifyLink(): void
    {
        $this->type()->modifyLink($this->emptyFn());
        $this->assertTrue(has_filter('post_type_link'));
    }

    public function testSetOnQuery(): void
    {
        $this->type()->setOnQuery([]);
        $this->assertTrue(has_action('pre_get_posts'));
    }

    public function testModifyQuery(): void
    {
        $this->type()->modifyQuery($this->emptyFn());
        $this->assertTrue(has_action('pre_get_posts'));
    }

    public function testModifyListTableColumns(): void
    {
        $fn = $this->emptyFn();
        $this->type()->modifyListTableColumns($fn);
        $this->assertTrue(has_filter('manage__posts_columns', $fn));
    }

    public function testModifySortableListTableColumns(): void
    {
        $fn = $this->emptyFn();
        $this->type()->modifySortableListTableColumns($fn);
        $this->assertTrue(has_filter('manage_edit-_sortable_columns', $fn));
    }

    public function testModifyListTableColumnDisplay(): void
    {
        $fn = $this->emptyFn();
        $this->type()->modifyListTableColumnDisplay($fn);
        $this->assertTrue(has_action('manage__posts_custom_column', $fn));
    }

    public function testAddListTableColumn(): void
    {
        $column = new SortableDownloadColumn();
        $this->type()->addListTableColumn($column);
        $this->assertTrue(has_filter('manage__posts_columns'));
        $this->assertTrue(has_action('manage__posts_custom_column'));
        $this->assertTrue(has_filter('manage_edit-_sortable_columns'));
        $this->assertTrue(has_action('pre_get_posts'));
    }

    protected function type(): Type
    {
        /** @var Type $type */
        $type = Mockery::mock(Type::class)->makePartial();
        return $type;
    }
}
