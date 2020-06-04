<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

class RegisterForType
{
    protected string $taxonomy;

    protected string $type;

    public function __construct(string $taxonomy, string $type)
    {
        $this->taxonomy = $taxonomy;
        $this->type = $type;
    }

    public function __invoke(): void
    {
        register_taxonomy_for_object_type($this->taxonomy, $this->type);
    }
}
