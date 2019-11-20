<?php

declare(strict_types=1);

namespace Fire\Post;

use Fire\Admin\ListTableColumn;
use Fire\Post\Type\AddListTableColumn;
use Fire\Post\Type\ArchiveTitle;
use Fire\Post\Type\Link;
use Fire\Post\Type\Modify;
use Fire\Post\Type\Query;
use Fire\Post\Type\Register;
use Fire\Post\Type\SortableListTableColumn;
use Fire\Post\Type\TitlePlaceholder;
use WP_Post;
use WP_Post_Type;
use WP_Query;

use function Fire\Core\filter_replace;
use function Fire\Core\filter_value;

abstract class Type
{
    /** @var string TYPE */
    public const TYPE = '';

    /**
     * Setup post type
     */
    public function register(): self
    {
        return $this;
    }

    /**
     * Return post type config
     */
    public function config(): WP_Post_Type
    {
        return get_post_type_object(static::TYPE);
    }

    /**
     * Register post type
     */
    public function registerType(array $config): self
    {
        return $this->registerTypeFrom(filter_value($config));
    }

    /**
     * Register post type from callable
     *
     * @param callable():array $fn
     */
    public function registerTypeFrom(callable $fn): self
    {
        (new Register(static::TYPE, $fn))->register();
        return $this;
    }

    /**
     * Merge config with existing
     *
     * @param array<string,mixed> $config
     */
    public function mergeType(array $config): self
    {
        return $this->modifyType(filter_replace($config));
    }

    /**
     * Modify post type from callable
     *
     * @param callable(array):array $fn
     */
    public function modifyType(callable $fn): self
    {
        (new Modify(static::TYPE, $fn))->register();
        return $this;
    }

    /**
     * Set title input placeholder
     */
    public function setTitlePlaceholder(string $value): self
    {
        return $this->modifyTitlePlaceholder(filter_value($value));
    }

    /**
     * Modify title input placeholder
     *
     * @param callable(string,WP_Post):string $fn
     */
    public function modifyTitlePlaceholder(callable $fn): self
    {
        (new TitlePlaceholder(static::TYPE, $fn))->register();
        return $this;
    }

    /**
     * Set archive title
     */
    public function setArchiveTitle(string $value): self
    {
        return $this->modifyArchiveTitle(filter_value($value));
    }

    /**
     * Modify archive title
     *
     * @param callable(string):string $fn
     */
    public function modifyArchiveTitle(callable $fn): self
    {
        (new ArchiveTitle(static::TYPE, $fn))->register();
        return $this;
    }

    /**
     * Modify the post link
     *
     * @param callable(string,WP_Post):string $fn
     */
    public function modifyLink(callable $fn): self
    {
        (new Link(static::TYPE, $fn))->register();
        return $this;
    }

    /**
     * Set vars on query
     */
    public function setOnQuery(array $data): self
    {
        return $this->modifyQuery(Query::set($data));
    }

    /**
     * Modify query
     *
     * @param callable(WP_Query):void $fn
     */
    public function modifyQuery(callable $fn): self
    {
        (new Query(static::TYPE, $fn))->register();
        return $this;
    }

    /**
     * Modify list table columns
     *
     * @param callable(array):array $fn
     */
    public function modifyListTableColumns(callable $fn): self
    {
        add_filter(sprintf('manage_%s_posts_columns', static::TYPE), $fn);
        return $this;
    }

    /**
     * Modify sortable list table columns
     *
     * @param callable(array):array $fn
     */
    public function modifySortableListTableColumns(callable $fn): self
    {
        add_filter(sprintf('manage_edit-%s_sortable_columns', static::TYPE), $fn);
        return $this;
    }

    /**
     * Modify custom list column content
     *
     * @param callable(string,int):void $fn
     */
    public function modifyListTableColumnDisplay(callable $fn): self
    {
        add_action(sprintf('manage_%s_posts_custom_column', static::TYPE), $fn, 10, 2);
        return $this;
    }

    /**
     * Add list table column before another
     */
    public function addListTableColumnBefore(ListTableColumn $column, string $ref): self
    {
        return $this->addListTableColumn($column, $ref, false);
    }

    /**
     * Add list table column after another
     */
    public function addListTableColumnAfter(ListTableColumn $column, string $ref): self
    {
        return $this->addListTableColumn($column, $ref, true);
    }

    /**
     * Add list table column
     */
    public function addListTableColumn(ListTableColumn $column, string $ref = '', bool $after = true): self
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

    protected function isType(string $type): bool
    {
        return $type === static::TYPE;
    }
}
