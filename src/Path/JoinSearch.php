<?php

declare(strict_types=1);

namespace Fire\Path;

abstract class JoinSearch implements JoinPath
{
    protected JoinPath $join;

    public function __construct(JoinPath $join)
    {
        $this->join = $join;
    }

    public function path(string ...$paths): string
    {
        return $this->join->path($this->search(join_path(...$paths)));
    }

    public function __invoke(string ...$paths): string
    {
        return $this->path(...$paths);
    }

    abstract protected function search(string $path): string;
}
