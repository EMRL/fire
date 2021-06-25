<?php

declare(strict_types=1);

namespace Fire\Tests\Post;

use DownloadColumn;
use Fire\Post\Type\Register;
use Fire\Tests\TestCase;
use Mockery;
use SortableDownloadColumn;
use WP_Post_Type;

use function Brain\Monkey\Actions\expectAdded;
use function Brain\Monkey\Functions\expect;

final class TypeTest extends TestCase
{
    public function testObject(): void
    {
        /** @var WP_Post_Type */
        $type = Mockery::mock('WP_Post_Type');

        expect('get_post_type_object')
            ->once()
            ->with('test')
            ->andReturn($type);

        $this->assertSame(
            $type,
            TypeStub::object(),
        );
    }

    public function testRegisterTypeFrom(): void
    {
        expectAdded('init')->with(Mockery::type(Register::class));
        $this->type()->doRegisterTypeFrom($this->emptyFn());
    }

    public function testModifyType(): void
    {
        $fn = $this->emptyFn();
        $this->type()->doModifyType($fn);
        $this->assertIsInt(has_filter('fire/register_post_type_args/test', $fn));
    }

    public function testAddSupport(): void
    {
        $this->type()->doAddSupport(['test']);
        $this->assertTrue(has_action('init'));
    }

    public function testRemoveSupport(): void
    {
        $this->type()->doRemoveSupport('test1', 'test2');
        $this->assertTrue(has_action('init'));
    }

    public function testModifyTitlePlaceholder(): void
    {
        $fn = $this->emptyFn();
        $this->type()->doModifyTitlePlaceholder($fn);
        $this->assertIsInt(has_filter('fire/enter_title_here/test', $fn));
    }

    public function testModifyArchiveTitle(): void
    {
        $fn = $this->emptyFn();
        $this->type()->doModifyArchiveTitle($fn);
        $this->assertIsInt(has_filter('fire/post_type_archive_title/test', $fn));
    }

    public function testModifyLink(): void
    {
        $fn = $this->emptyFn();
        $this->type()->doModifyLink($fn);
        $this->assertIsInt(has_filter('fire/post_type_link/test', $fn));
    }

    public function testSetOnQuery(): void
    {
        $this->type()->doSetOnQuery([]);
        $this->assertTrue(has_action('fire/pre_get_posts/test/main'));
    }

    public function testSetOnFrontendQuery(): void
    {
        expect('is_admin')
            ->twice()
            ->andReturn(true, false);

        $this->type()->doSetOnFrontendQuery([]);
        $this->assertFalse(has_action('fire/pre_get_posts/test/main'));

        $this->type()->doSetOnFrontendQuery([]);
        $this->assertTrue(has_action('fire/pre_get_posts/test/main'));
    }

    public function testSetOnAdminQuery(): void
    {
        expect('is_admin')
            ->twice()
            ->andReturn(false, true);

        $this->type()->doSetOnAdminQuery([]);
        $this->assertFalse(has_action('fire/pre_get_posts/test/main'));

        $this->type()->doSetOnAdminQuery([]);
        $this->assertTrue(has_action('fire/pre_get_posts/test/main'));
    }

    public function testModifyQuery(): void
    {
        $fn = $this->emptyFn();
        $this->type()->doModifyQuery($fn);
        $this->assertIsInt(has_action('fire/pre_get_posts/test/main', $fn));
    }

    public function testModifyQueryNotMain(): void
    {
        $fn = $this->emptyFn();
        $this->type()->doModifyQuery($fn, false);
        $this->assertIsInt(has_action('fire/pre_get_posts/test', $fn));
        $this->assertFalse(has_action('fire/pre_get_posts/test/main'));
    }

    public function testModifyFrontendQuery(): void
    {
        expect('is_admin')
            ->twice()
            ->andReturn(true, false);

        $fn = $this->emptyFn();

        $this->type()->doModifyFrontendQuery($fn);
        $this->assertFalse(has_action('fire/pre_get_posts/test/main', $fn));

        $this->type()->doModifyFrontendQuery($fn);
        $this->assertIsInt(has_action('fire/pre_get_posts/test/main', $fn));
    }

    public function testModifyAdminQuery(): void
    {
        expect('is_admin')
            ->twice()
            ->andReturn(false, true);

        $fn = $this->emptyFn();

        $this->type()->doModifyAdminQuery($fn);
        $this->assertFalse(has_action('fire/pre_get_posts/test/main', $fn));

        $this->type()->doModifyAdminQuery($fn);
        $this->assertIsInt(has_action('fire/pre_get_posts/test/main', $fn));
    }

    public function testModifyListTableColumns(): void
    {
        $fn = $this->emptyFn();
        $this->type()->doModifyListTableColumns($fn);
        $this->assertIsInt(has_filter('manage_test_posts_columns', $fn));
    }

    public function testModifySortableListTableColumns(): void
    {
        $fn = $this->emptyFn();
        $this->type()->doModifySortableListTableColumns($fn);
        $this->assertIsInt(has_filter('manage_edit-test_sortable_columns', $fn));
    }

    public function testModifyListTableColumnDisplay(): void
    {
        $fn = $this->emptyFn();
        $this->type()->doModifyListTableColumnDisplay($fn);
        $this->assertIsInt(has_action('manage_test_posts_custom_column', $fn));
    }

    public function testAddListTableColumn(): void
    {
        $column = new DownloadColumn();
        $this->type()->doAddListTableColumn($column);
        $this->assertTrue(has_filter('manage_test_posts_columns'));
        $this->assertTrue(has_action('manage_test_posts_custom_column'));
        $this->assertFalse(has_filter('manage_edit-test_sortable_columns'));
        $this->assertFalse(has_action('fire/pre_get_posts/test'));

        $column = new SortableDownloadColumn();
        $this->type()->doAddListTableColumn($column);
        $this->assertTrue(has_filter('manage_edit-test_sortable_columns'));
        $this->assertTrue(has_action('fire/pre_get_posts/test/main'));
    }

    public function testRegisterArchivePageSetting(): void
    {
        $this->type()->doRegisterArchivePageSetting();
        $this->assertTrue(has_action('init'));
        $this->assertTrue(has_action('admin_init'));
        $this->assertTrue(has_action('post_updated'));
        $this->assertTrue(has_action('update_option_page_for_test'));
        $this->assertTrue(has_action('add_option_page_for_test'));
        $this->assertTrue(has_action('trashed_post'));
        $this->assertTrue(has_action('deleted_post'));
        $this->assertTrue(has_filter('display_post_states'));
        $this->assertTrue(has_filter('fire/register_post_type_args/test'));
        $this->assertTrue(has_filter('fire/post_type_archive_title/test'));
    }

    public function testRegisterArchivePageSettingForPost(): void
    {
        (new PostStub())->doRegisterArchivePageSetting();
        $this->assertFalse(has_action('admin_init'));
        $this->assertTrue(has_filter('fire/post_type_archive_title/post'));
        $this->assertTrue(has_action('init'));
    }

    protected function type(): TypeStub
    {
        return new TypeStub();
    }
}
