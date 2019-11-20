<?php

declare(strict_types=1);

namespace Fire\Path;

class Join implements JoinPath
{
    /**
     * The base path
     *
     * @var string $path
     */
    protected $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function path(string $key = ''): string
    {
        return join_path($this->path, $key);
    }

    public function __invoke(string $key = ''): string
    {
        return $this->path($key);
    }
}
