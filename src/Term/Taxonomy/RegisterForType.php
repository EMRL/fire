<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

class RegisterForType
{
    /**
     * @var string[] $types
     */
    protected array $types;

    public function __construct(
        protected readonly string $taxonomy,
        string ...$types,
    ) {
        $this->types = $types;
    }

    public function __invoke(): void
    {
        foreach ($this->types as $type) {
            register_taxonomy_for_object_type($this->taxonomy, $type);
        }
    }
}
