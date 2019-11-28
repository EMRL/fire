<?php

declare(strict_types=1);

namespace Fire\Post\Type;

class Register
{
    /** @var string $type */
    protected $type;

    /** @var callable():array<string,mixed> $fn */
    protected $fn;

    /**
     * @param callable():array<string,mixed> $fn
     */
    public function __construct(string $type, callable $fn)
    {
        $this->type = $type;
        $this->fn = $fn;
    }

    public function __invoke(): void
    {
        register_post_type($this->type, ($this->fn)());
    }
}
