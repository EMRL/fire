<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

class Register extends Hook
{
    /** @var string[] $types */
    protected $types = [];

    public function register(): Hook
    {
        add_action('init', [$this, 'run']);
        return $this;
    }

    public function setTypes(string ...$types): self
    {
        $this->types = $types;
        return $this;
    }

    public function run(): void
    {
        register_taxonomy($this->taxonomy, $this->types, $this->fn());
    }
}
