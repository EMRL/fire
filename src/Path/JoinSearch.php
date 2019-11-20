<?php

declare(strict_types=1);

namespace Fire\Path;

abstract class JoinSearch implements JoinPath
{
    /** @var JoinPath $join */
    protected $join;

    public function __construct(JoinPath $join)
    {
        $this->join = $join;
    }

    public function path(string $key = ''): string
    {
        return $this->join->path($this->search($key));
    }

    public function __invoke(string $key = ''): string
    {
        return $this->path($key);
    }

    abstract protected function search(string $key): string;
}
