<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

class RegisterForType extends Hook
{
    public function register(): Hook
    {
        add_action('init', [$this, 'run']);
        return $this;
    }

    public function run(): void
    {
        register_taxonomy_for_object_type($this->taxonomy, $this->fn());
    }
}
