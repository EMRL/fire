<?php

declare(strict_types=1);

namespace Fire\Core;

use Closure;

/**
 * Insert array item before or after another key
 *
 * @param mixed $key
 */
function array_insert(array $arr, array $value, $key, bool $after = true): array
{
    $pos = array_search($key, array_keys($arr), true);

    if ($after) {
        $pos++;
    }

    if ($pos !== false) {
        $arr = array_merge(
            array_merge(array_slice($arr, 0, $pos), $value),
            array_slice($arr, $pos)
        );
    } else {
        $arr = array_merge($arr, $value);
    }

    return $arr;
}

/**
 * Returns a callback that inserts an array into another array before
 * or after specified key
 */
function filter_insert(array $arr, $key, bool $after = true): Closure
{
    return function (array $orig) use ($arr, $key, $after): array {
        return array_insert($orig, $arr, $key, $after);
    };
}

/**
 * Returns a callback that merges a supplied array
 */
function filter_merge(array $arr): Closure
{
    return function (array $orig) use ($arr): array {
        return array_merge($orig, $arr);
    };
}

/**
 * Returns a callback that recursively replaces a supplied array
 */
function filter_replace(array $arr): Closure
{
    return function (array $orig) use ($arr): array {
        return array_replace_recursive($orig, $arr);
    };
}

/**
 * Returns a callback that removes items from a supplied array
 */
function filter_remove(array $arr): Closure
{
    return function (array $orig) use ($arr): array {
        return array_diff($orig, $arr);
    };
}

/**
 * Return a callback that removes items by key from a supplied array
 */
function filter_remove_key(array $arr): Closure
{
    return function (array $orig) use ($arr): array {
        return array_diff_key($orig, array_flip($arr));
    };
}

/**
 * Returns a callback that returns the specified value
 *
 * @param mixed $value
 */
function filter_value($value): Closure
{
    /**
     * @return mixed
     */
    return function () use ($value) {
        return $value;
    };
}

/**
 * Return a list of valid hosts
 */
function parse_hosts(array $hosts): array
{
    return array_filter(array_map(function ($i) {
        return parse_url((strpos($i, '//') === false ? '//' : '').$i, PHP_URL_HOST);
    }, $hosts));
}

/**
 * Return a value that may be defined as a callback.
 *
 * @param mixed $value
 * @param mixed ...$args
 * @return mixed
 */
function value($value, ...$args)
{
    return is_callable($value) ? $value(...$args) : $value;
}
