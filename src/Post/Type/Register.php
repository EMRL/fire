<?php

declare(strict_types=1);

namespace Fire\Post\Type;

class Register
{
    /** @var callable():array */
    protected $fn;

    public function __construct(
        protected readonly string $type,
        callable $fn,
    ) {
        $this->fn = $fn;
    }

    public function __invoke(): void
    {
        register_post_type($this->type, ($this->fn)());
    }
}
