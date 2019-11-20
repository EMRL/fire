<?php

declare(strict_types=1);

namespace Fire\Path;

interface JoinPath
{
    public function path(string $key = ''): string;

    public function __invoke(string $key = ''): string;
}
