<?php

declare(strict_types=1);

namespace Fire\Template;

/**
 * Return the output of a callback function
 */
function buffer(callable $fn): string
{
    ob_start();
    $fn();
    return ob_get_clean();
}

/**
 * Return a string of HTML attributes
 *
 * @param array<string,mixed> $attrs
 */
function html_attributes(array $attrs): string
{
    return array_reduce(array_keys($attrs), function (string $carry, string $key) use ($attrs): string {
        return sprintf(
            '%s %s%s',
            $carry,
            $key,
            ($attrs[$key] === true) ? '' : sprintf('="%s"', esc_attr((string) $attrs[$key]))
        );
    }, '');
}

/**
 * Return the list items for a navigation menu
 *
 * @param array<string,mixed> $args
 */
function nav_menu_items(array $args): string
{
    $args = array_merge([
        'items_wrap' => '%3$s',
        'container' => false,
        'fallback_cb' => false,
    ], $args);

    // Never echo
    $args['echo'] = false;

    return (string) wp_nav_menu($args);
}
