<?php

declare(strict_types=1);

namespace Fire\Tests\Term;

use DownloadColumn;
use Fire\Term\Taxonomy\Register;
use Fire\Term\Taxonomy\RegisterForType;
use Fire\Tests\TestCase;
use Mockery;
use WP_Taxonomy;

use function Brain\Monkey\Actions\expectAdded;
use function Brain\Monkey\Functions\expect;

final class TaxonomyTest extends TestCase
{
    public function testObject(): void
    {
        /** @var WP_Taxonomy */
        $taxonomy = Mockery::mock('WP_Taxonomy');

        expect('get_taxonomy')
            ->once()
            ->with('test')
            ->andReturn($taxonomy);

        $this->assertSame(
            $taxonomy,
            TaxonomyStub::object(),
        );
    }

    public function testRegisterTaxonomyFrom(): void
    {
        $types = ['post'];
        expectAdded('init')->with(Mockery::type(Register::class));
        $this->taxonomy()->doRegisterTaxonomyFrom($this->emptyFn(), ...$types);
    }

    public function testModifyTaxonomy(): void
    {
        $fn = $this->emptyFn();
        $this->taxonomy()->doModifyTaxonomy($fn);
        $this->assertIsInt(has_filter('fire/register_taxonomy_args/test', $fn));
    }

    public function testRegisterForType(): void
    {
        expectAdded('init')->with(Mockery::type(RegisterForType::class));
        $this->taxonomy()->doRegisterForType('post', 'page');
    }

    public function testModifyLink(): void
    {
        $fn = $this->emptyFn();
        $this->taxonomy()->doModifyLink($fn);
        $this->assertIsInt(has_filter('fire/term_link/test', $fn));
    }

    public function testModifyListTableColumns(): void
    {
        $fn = $this->emptyFn();
        $this->taxonomy()->doModifyListTableColumns($fn);
        $this->assertIsInt(has_filter('manage_edit-test_columns', $fn));
    }

    public function testModifySortableListTableColumns(): void
    {
        $fn = $this->emptyFn();
        $this->taxonomy()->doModifySortableListTableColumns($fn);
        $this->assertIsInt(has_filter('manage_edit-test_sortable_columns', $fn));
    }

    public function testModifyListTableColumnDisplay(): void
    {
        $fn = $this->emptyFn();
        $this->taxonomy()->doModifyListTableColumnDisplay($fn);
        $this->assertIsInt(has_action('manage_test_custom_column', $fn));
    }

    public function testAddListTableColumn(): void
    {
        $column = new DownloadColumn();
        $this->taxonomy()->doAddListTableColumn($column);
        $this->assertTrue(has_filter('manage_edit-test_columns'));
        $this->assertTrue(has_action('manage_test_custom_column'));
    }

    protected function taxonomy(): TaxonomyStub
    {
        return new TaxonomyStub();
    }
}
