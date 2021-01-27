<?php

declare(strict_types=1);

namespace Fire\Term;

use Fire\Admin\ListTableColumn;
use Fire\Term\Taxonomy\AddListTableColumn;
use Fire\Term\Taxonomy\Register;
use Fire\Term\Taxonomy\RegisterForType;
use WP_Taxonomy;
use WP_Term;

use function Fire\Core\filter_replace;
use function Fire\Core\filter_value;

abstract class Taxonomy
{
    public const TAXONOMY = '';

    /**
     * Register
     */
    public function register(): self
    {
        return $this;
    }

    /**
     * Get taxonomy config
     *
     * @deprecated since version 3.3.0. Use static `object()` instead.
     */
    public function config(): WP_Taxonomy
    {
        @trigger_error(
            'config() method is deprecated since 3.3.0. Use static object() method instead',
            E_USER_DEPRECATED,
        );

        return get_taxonomy(static::TAXONOMY);
    }

    /**
     * Get taxonomy object
     */
    public static function object(): WP_Taxonomy
    {
        return get_taxonomy(static::TAXONOMY);
    }

    /**
     * Register taxonomy
     *
     * @param array<string,mixed> $config
     */
    protected function registerTaxonomy(array $config, string ...$types): self
    {
        return $this->registerTaxonomyFrom(filter_value($config), ...$types);
    }

    /**
     * Register taxonomy from callable
     *
     * @param callable():array $fn
     */
    protected function registerTaxonomyFrom(callable $fn, string ...$types): self
    {
        add_action('init', new Register(static::TAXONOMY, $fn, ...$types));
        return $this;
    }

    /**
     * Modify existing taxonomy
     *
     * @param array<string,mixed> $config
     */
    protected function mergeTaxonomy(array $config): self
    {
        return $this->modifyTaxonomy(filter_replace($config));
    }

    /**
     * Modify existing taxonomy from callable
     *
     * @param callable(array,array):array $fn
     */
    protected function modifyTaxonomy(callable $fn): self
    {
        add_filter('fire/register_taxonomy_args/'.static::TAXONOMY, $fn, 10, 2);
        return $this;
    }

    /**
     * Register taxonomy for post type
     */
    protected function registerForType(string ...$types): self
    {
        add_action('init', new RegisterForType(static::TAXONOMY, ...$types));
        return $this;
    }

    /**
     * Modify term link
     *
     * @param callable(string,WP_Term):string $fn
     */
    protected function modifyLink(callable $fn): self
    {
        add_filter('fire/term_link/'.static::TAXONOMY, $fn, 10, 2);
        return $this;
    }

    /**
     * Modify list table columns
     *
     * @param callable(array):array $fn
     */
    protected function modifyListTableColumns(callable $fn): self
    {
        add_filter(sprintf('manage_edit-%s_columns', static::TAXONOMY), $fn);
        return $this;
    }

    /**
     * Modify sortable list table columns
     *
     * @param callable(array:):array $fn
     */
    protected function modifySortableListTableColumns(callable $fn): self
    {
        add_filter(sprintf('manage_edit-%s_sortable_columns', static::TAXONOMY), $fn);
        return $this;
    }

    /**
     * Modify custom list column content
     *
     * @param callable(int):void $fn
     */
    protected function modifyListTableColumnDisplay(callable $fn): self
    {
        add_action(sprintf('manage_%s_custom_column', static::TAXONOMY), $fn, 10, 3);
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
        return $this;
    }
}
