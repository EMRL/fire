<?php

declare(strict_types=1);

namespace Fire\Post\Type;

abstract class Hook
{
    /** @var string $type */
    protected $type;

    /** @var callable $fn */
    protected $fn;

    public function __construct(string $type, callable $fn)
    {
        $this->type = $type;
        $this->fn = $fn;
    }

    abstract public function register(): self;

    /**
     * @param mixed ...$args
     * @return mixed
     */
    protected function fn(...$args)
    {
        return ($this->fn)(...$args);
    }

    protected function isType(string $type): bool
    {
        return $type === $this->type;
    }
}
