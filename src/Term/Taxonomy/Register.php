<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

class Register
{
    /** @var string $taxonomy */
    protected $taxonomy;

    /** @var callable():array<string,mixed> $fn */
    protected $fn;

    /** @var string[] $types */
    protected $types = [];

    /**
     * @param callable():array<string,mixed> $fn
     */
    public function __construct(string $taxonomy, callable $fn, string ...$types)
    {
        $this->taxonomy = $taxonomy;
        $this->fn = $fn;
        $this->types = $types;
    }

    public function __invoke(): void
    {
        register_taxonomy($this->taxonomy, $this->types, ($this->fn)());
    }
}
