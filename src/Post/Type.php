<?php

declare(strict_types=1);

namespace Fire\Post;

use Fire\Admin\ListTableColumn;
use Fire\Post\Type\AddListTableColumn;
use Fire\Post\Type\ArchivePageSetting;
use Fire\Post\Type\Query;
use Fire\Post\Type\Register;
use Fire\Post\Type\SortableListTableColumn;
use WP_Post;
use WP_Post_Type;
use WP_Query;

use function Fire\Core\filter_replace;
use function Fire\Core\filter_value;

abstract class Type
{
    public const TYPE = '';

    /**
     * Register
     */
    public function register(): self
    {
        return $this;
    }

    /**
     * Get post type config
     */
    public function config(): WP_Post_Type
    {
        return get_post_type_object(static::TYPE);
    }

    /**
     * Register post type
     */
    protected function registerType(array $config): self
    {
        return $this->registerTypeFrom(filter_value($config));
    }

    /**
     * Register post type from callable
     *
     * @param callable():array<string,mixed> $fn
     */
    protected function registerTypeFrom(callable $fn): self
    {
        add_action('init', new Register(static::TYPE, $fn));
        return $this;
    }

    /**
     * Merge config with existing
     *
     * @param array<string,mixed> $config
     */
    protected function mergeType(array $config): self
    {
        return $this->modifyType(filter_replace($config));
    }

    /**
     * Modify post type from callable
     *
     * @param callable(array<string,mixed>):array<string,mixed> $fn
     */
    protected function modifyType(callable $fn): self
    {
        add_filter('fire/register_post_type_args/'.static::TYPE, $fn);
        return $this;
    }

    /**
     * Set title input placeholder
     */
    protected function setTitlePlaceholder(string $value): self
    {
        return $this->modifyTitlePlaceholder(filter_value($value));
    }

    /**
     * Modify title input placeholder
     *
     * @param callable(string,WP_Post):string $fn
     */
    protected function modifyTitlePlaceholder(callable $fn): self
    {
        add_filter('fire/enter_title_here/'.static::TYPE, $fn, 10, 2);
        return $this;
    }

    /**
     * Set archive title
     */
    protected function setArchiveTitle(string $value): self
    {
        return $this->modifyArchiveTitle(filter_value($value));
    }

    /**
     * Modify archive title
     *
     * @param callable(string):string $fn
     */
    protected function modifyArchiveTitle(callable $fn): self
    {
        add_filter('fire/post_type_archive_title/'.static::TYPE, $fn);
        return $this;
    }

    /**
     * Modify the post link
     *
     * @param callable(string,WP_Post):string $fn
     */
    protected function modifyLink(callable $fn): self
    {
        add_filter('fire/post_type_link/'.static::TYPE, $fn, 10, 2);
        return $this;
    }

    /**
     * Set vars on query
     *
     * @param array<string,mixed> $data
     */
    protected function setOnQuery(array $data): self
    {
        return $this->modifyQuery(new Query($data));
    }

    /**
     * Modify query
     *
     * @param callable(WP_Query):void $fn
     */
    protected function modifyQuery(callable $fn): self
    {
        add_action('fire/pre_get_posts/'.static::TYPE, $fn);
        return $this;
    }

    /**
     * Modify list table columns
     *
     * @param callable(array<string,string>):array<string,string> $fn
     */
    protected function modifyListTableColumns(callable $fn): self
    {
        add_filter(sprintf('manage_%s_posts_columns', static::TYPE), $fn);
        return $this;
    }

    /**
     * Modify sortable list table columns
     *
     * @param callable(array<string,mixed>):array<string,mixed> $fn
     */
    protected function modifySortableListTableColumns(callable $fn): self
    {
        add_filter(sprintf('manage_edit-%s_sortable_columns', static::TYPE), $fn);
        return $this;
    }

    /**
     * Modify custom list column content
     *
     * @param callable(string,int):void $fn
     */
    protected function modifyListTableColumnDisplay(callable $fn): self
    {
        add_action(sprintf('manage_%s_posts_custom_column', static::TYPE), $fn, 10, 2);
        return $this;
    }

    /**
     * Add list table column before another
     */
    protected function addListTableColumnBefore(ListTableColumn $column, string $ref): self
    {
        return $this->addListTableColumn($column, $ref, false);
    }

    /**
     * Add list table column after another
     */
    protected function addListTableColumnAfter(ListTableColumn $column, string $ref): self
    {
        return $this->addListTableColumn($column, $ref, true);
    }

    /**
     * Add list table column
     */
    protected function addListTableColumn(ListTableColumn $column, string $ref = '', bool $after = true): self
    {
        $add = new AddListTableColumn($column);
        $this->modifyListTableColumns($add->columns($ref, $after));
        $this->modifyListTableColumnDisplay($add->display());

        if ($column instanceof SortableListTableColumn) {
            $this->modifySortableListTableColumns($add->sortableColumns());
            $this->modifyQuery($add->query());
        }

        return $this;
    }

    /**
     * Register setting to assign archive page
     */
    protected function registerArchivePageSetting(callable $label = null): self
    {
        $setting = new ArchivePageSetting(static::TYPE, $label);
        add_action('admin_init', $setting->register());
        add_action('post_updated', $setting->permalinks(), 10, 3);
        add_action('before_delete_post', $setting->delete());
        add_filter('display_post_states', $setting->states(), 10, 2);
        $this->modifyType($setting->slug());
        $this->modifyArchiveTitle($setting->archiveTitle());
        return $this;
    }

    /**
     * Check if type is equal
     */
    protected function isType(string $type): bool
    {
        return $type === static::TYPE;
    }
}
