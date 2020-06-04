<?php

declare(strict_types=1);

namespace Fire\Post\Type;

class Register
{
    protected string $type;

    /** @var callable():array<string,mixed> */
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
