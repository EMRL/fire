<?php

declare(strict_types=1);

namespace Fire\Path;

class Join implements JoinPath
{
    /**
     * The base path
     */
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
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
