<?php

declare(strict_types=1);

namespace Fire\Tests\Term;

use DownloadColumn;
use Fire\Term\Taxonomy;
use Fire\Tests\TestCase;
use Mockery;

final class TaxonomyTest extends TestCase
{
    public function testRegisterTaxonomy(): void
    {
        $this->taxonomy()->registerTaxonomy([], []);
        $this->assertTrue(has_action('init'));
    }

    public function testRegisterTaxonomyFrom(): void
    {
        $this->taxonomy()->registerTaxonomyFrom([], $this->emptyFn());
        $this->assertTrue(has_action('init'));
    }

    public function testMergeTaxonomy(): void
    {
        $this->taxonomy()->mergeTaxonomy([]);
        $this->assertTrue(has_filter('register_taxonomy_args'));
    }

    public function testModifyTaxonomy(): void
    {
        $this->taxonomy()->modifyTaxonomy($this->emptyFn());
        $this->assertTrue(has_filter('register_taxonomy_args'));
    }

    public function testSetArchiveTitle(): void
    {
        $this->taxonomy()->setArchiveTitle('');
        $this->assertTrue(has_filter('single_term_title'));
    }

    public function testModifyArchiveTitle(): void
    {
        $this->taxonomy()->modifyArchiveTitle($this->emptyFn());
        $this->assertTrue(has_filter('single_term_title'));
    }

    public function testModifyLink(): void
    {
        $this->taxonomy()->modifyLink($this->emptyFn());
        $this->assertTrue(has_filter('term_link'));
    }

    public function testModifyListTableColumns(): void
    {
        $fn = $this->emptyFn();
        $this->taxonomy()->modifyListTableColumns($fn);
        $this->assertTrue(has_filter('manage_edit-_columns', $fn));
    }

    public function testModifySortableListTableColumns(): void
    {
        $fn = $this->emptyFn();
        $this->taxonomy()->modifySortableListTableColumns($fn);
        $this->assertTrue(has_filter('manage_edit-_sortable_columns', $fn));
    }

    public function testModifyListTableColumnDisplay(): void
    {
        $fn = $this->emptyFn();
        $this->taxonomy()->modifyListTableColumnDisplay($fn);
        $this->assertTrue(has_action('manage__custom_column', $fn));
    }

    public function testAddListTableColumn(): void
    {
        $column = new DownloadColumn();
        $this->taxonomy()->addListTableColumn($column);
        $this->assertTrue(has_filter('manage_edit-_columns'));
        $this->assertTrue(has_action('manage__custom_column'));
    }

    protected function taxonomy(): Taxonomy
    {
        /** @var Taxonomy $taxonomy */
        $taxonomy = Mockery::mock(Taxonomy::class)->makePartial();
        return $taxonomy;
    }
}
