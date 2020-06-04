<?php

declare(strict_types=1);

namespace Fire\Path;

interface JoinPath
{
    public function path(string ...$paths): string;

    public function __invoke(string ...$paths): string;
}
