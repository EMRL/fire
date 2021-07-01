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
        ++$pos;
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
 * Smart array merge
 *
 * Overwrites simple values, and merges array values
 */
function array_smart_merge(array ...$arrays): array
{
    $res = [];

    foreach ($arrays as $array) {
        foreach ($array as $key => $value) {
            if (is_int($key)) {
                if (array_key_exists($key, $res)) {
                    $res[] = $value;
                } else {
                    $res[$key] = $value;
                }
            } elseif (is_array($value) && isset($res[$key]) && is_array($res[$key])) {
                $res[$key] = array_smart_merge($res[$key], $value);
            } else {
                $res[$key] = $value;
            }
        }
    }

    return $res;
}

/**
 * Returns a callback that inserts an array into another array before
 * or after specified key
 *
 * @param mixed $key
 */
function filter_insert(array $arr, $key, bool $after = true): Closure
{
    return fn (array $orig): array => array_insert($orig, $arr, $key, $after);
}

/**
 * Returns a callback that recursively merges a supplied array
 */
function filter_merge(array ...$arr): Closure
{
    return fn (array $orig): array => array_smart_merge($orig, ...$arr);
}

/**
 * Returns a callback that recursively replaces a supplied array
 *
 * @deprecated since version 3.4.0, will be removed in version 4
 */
function filter_replace(array ...$arr): Closure
{
    @trigger_error(
        'filter_replace() is deprecated since 3.4.0 and will be removed in version 4',
        E_USER_DEPRECATED,
    );

    return fn (array $orig): array => array_replace_recursive($orig, ...$arr);
}

/**
 * Returns a callback that removes items from a supplied array
 */
function filter_remove(array ...$arr): Closure
{
    return fn (array $orig): array => array_diff($orig, ...$arr);
}

/**
 * Return a callback that removes items by key from a supplied array
 */
function filter_remove_key(array ...$arr): Closure
{
    return fn (array $orig): array => array_diff_key(
        $orig,
        ...array_map(fn (array $i): array => array_flip($i), $arr)
    );
}

/**
 * Returns a callback that returns the specified value
 *
 * @param mixed $value
 */
function filter_value($value): Closure
{
    return fn () => $value;
}

/**
 * Return a list of valid hosts
 */
function parse_hosts(string ...$hosts): array
{
    return array_filter(array_map(
        fn ($i) => parse_url(((strpos($i, '//') === false) ? '//' : '').$i, PHP_URL_HOST),
        $hosts,
    ));
}

/**
 * Return a value that may be defined as a callback
 *
 * @param mixed $value
 * @param mixed ...$args
 * @return mixed
 */
function value($value, ...$args)
{
    return is_callable($value) ? $value(...$args) : $value;
}
