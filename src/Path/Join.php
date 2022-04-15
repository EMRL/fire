<?php

declare(strict_types=1);

namespace Fire\Path;

class Join implements JoinPath
{
    public function __construct(
        protected readonly string $path,
    ) {
    }

    public function path(string ...$paths): string
    {
        return join_path($this->path, ...$paths);
    }

    public function __invoke(string ...$paths): string
    {
        return $this->path(...$paths);
    }
}
