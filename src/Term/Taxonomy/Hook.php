<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

abstract class Hook
{
    /** @var string $taxonomy */
    protected $taxonomy;

    /** @var callable $fn */
    protected $fn;

    public function __construct(string $taxonomy, callable $fn)
    {
        $this->taxonomy = $taxonomy;
        $this->fn = $fn;
    }

    abstract public function register(): self;

    /**
     * @param mixed ...$args
     * @return mixed
     */
    protected function fn(...$args)
    {
        return ($this->fn)(...$args);
    }

    protected function isTaxonomy(string $taxonomy): bool
    {
        return $taxonomy === $this->taxonomy;
    }
}
