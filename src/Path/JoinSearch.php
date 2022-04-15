<?php

declare(strict_types=1);

namespace Fire\Path;

abstract class JoinSearch implements JoinPath
{
    public function __construct(
        protected readonly JoinPath $join,
    ) {
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
