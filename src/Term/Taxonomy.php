<?php

declare(strict_types=1);

namespace Fire\Term;

use Fire\Admin\ListTableColumn;
use Fire\Term\Taxonomy\AddListTableColumn;
use Fire\Term\Taxonomy\ArchiveTitle;
use Fire\Term\Taxonomy\Link;
use Fire\Term\Taxonomy\Modify;
use Fire\Term\Taxonomy\Register;
use Fire\Term\Taxonomy\RegisterForType;
use WP_Taxonomy;
use WP_Term;

use function Fire\Core\filter_replace;
use function Fire\Core\filter_value;

abstract class Taxonomy
{
    /** @var string TAXONOMY */
    public const TAXONOMY = '';

    /** @var WP_Taxonomy $config */
    protected $config;

    /**
     * Setup taxonomy
     */
    public function register(): self
    {
        return $this;
    }

    /**
     * Return taxonomy configuration
     */
    public function config(): WP_Taxonomy
    {
        if (!$this->config) {
            $this->config = get_taxonomy(static::TAXONOMY);
        }

        return $this->config;
    }

    /**
     * Register taxonomy
     *
     * @param string[] $types
     * @param array<string,mixed> $config
     */
    public function registerTaxonomy(array $types, array $config): self
    {
        return $this->registerTaxonomyFrom($types, filter_value($config));
    }

    /**
     * Register taxonomy from callable
     *
     * @param string[] $types
     * @param callable():array $fn
     */
    public function registerTaxonomyFrom(array $types, callable $fn): self
    {
        (new Register(static::TAXONOMY, $fn))
            ->setTypes(...$types)
            ->register();
        return $this;
    }

    /**
     * Modify existing taxonomy
     *
     * @param array<string,mixed> $config
     */
    public function mergeTaxonomy(array $config): self
    {
        return $this->modifyTaxonomy(filter_replace($config));
    }

    /**
     * Modify existing taxonomy from callable
     *
     * @param callable(array,array):array $fn
     */
    public function modifyTaxonomy(callable $fn): self
    {
        (new Modify(static::TAXONOMY, $fn))->register();
        return $this;
    }

    /**
     * Register taxonomy for post type
     */
    public function registerForType(string $type): self
    {
        (new RegisterForType(static::TAXONOMY, filter_value($type)));
        return $this;
    }

    /**
     * Set archive title
     */
    public function setArchiveTitle(string $title): self
    {
        return $this->modifyArchiveTitle(filter_value($title));
    }

    /**
     * Modify archive title
     *
     * @param callable(string):string $fn
     */
    public function modifyArchiveTitle(callable $fn): self
    {
        (new ArchiveTitle(static::TAXONOMY, $fn))->register();
        return $this;
    }

    /**
     * Modify term link
     *
     * @param callable(string,WP_Term):string $fn
     */
    public function modifyLink(callable $fn): self
    {
        (new Link(static::TAXONOMY, $fn))->register();
        return $this;
    }

    /**
     * Modify list table columns
     *
     * @param callable(array):array $fn
     */
    public function modifyListTableColumns(callable $fn): self
    {
        add_filter(sprintf('manage_edit-%s_columns', static::TAXONOMY), $fn);
        return $this;
    }

    /**
     * Modify sortable list table columns
     *
     * @param callable(array:):array $fn
     */
    public function modifySortableListTableColumns(callable $fn): self
    {
        add_filter(sprintf('manage_edit-%s_sortable_columns', static::TAXONOMY), $fn);
        return $this;
    }

    /**
     * Modify custom list column content
     *
     * @param callable(int):void $fn
     */
    public function modifyListTableColumnDisplay(callable $fn): self
    {
        add_action(sprintf('manage_%s_custom_column', static::TAXONOMY), $fn, 10, 3);
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
        return $this;
    }
}
