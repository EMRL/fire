<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

class Register
{
    /** @var callable():array<string,mixed> $fn */
    protected $fn;

    /** @var string[] $types */
    protected array $types = [];

    public function __construct(
        protected readonly string $taxonomy,
        callable $fn,
        string ...$types,
    ) {
        $this->fn = $fn;
        $this->types = $types;
    }

    public function __invoke(): void
    {
        register_taxonomy($this->taxonomy, $this->types, ($this->fn)());
    }
}
