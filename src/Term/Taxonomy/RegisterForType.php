<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

class RegisterForType
{
    protected string $taxonomy;

    /**
     * @var string[] $types
     */
    protected array $types;

    public function __construct(string $taxonomy, string ...$types)
    {
        $this->taxonomy = $taxonomy;
        $this->types = $types;
    }

    public function __invoke(): void
    {
        foreach ($this->types as $type) {
            register_taxonomy_for_object_type($this->taxonomy, $type);
        }
    }
}
