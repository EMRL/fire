<?php

declare(strict_types=1);

namespace Fire\Path;

/**
 * Join multiple parts of a path into one path
 */
function join_path(string ...$pieces): string
{
    $pieces = array_filter($pieces, function (string $i): bool {
        return $i !== '';
    });

    $sep = preg_quote(DIRECTORY_SEPARATOR);
    return preg_replace("~(?<!:)$sep+~", DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $pieces));
}
