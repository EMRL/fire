<?php

declare(strict_types=1);

namespace Fire\Post;

use Fire\Post\Type\ArchivePageSetting;
use Fire\Query\Iterator;
use WP_Query;

/**
 * Test if current post matches type
 */
function is_type(string $type): bool
{
    return get_post_type() === $type;
}

/**
 * Page for post type archive
 */
function page_for_type(string $type = ''): Iterator
{
    return new Iterator(new WP_Query([
        'p' => page_id_for_type($type),
        'post_type' => Page::TYPE,
    ]));
}

/**
 * Page ID for post type archive
 */
function page_id_for_type(string $type = ''): int
{
    $type = $type ?: get_query_var('post_type');

    // Adjust for `page_for_posts` option
    if ($type === Post::TYPE) {
        $type .= 's';
    }

    return (int) get_option(ArchivePageSetting::optionName($type));
}

/**
 * Test if has page for post type
 */
function has_page_for_type(string $type = ''): bool
{
    return (bool) page_id_for_type($type);
}

/**
 * Current post ID, accounts for pages assigned for post type archives
 */
function id(): int
{
    $id = get_the_ID();

    if ((is_home() || is_post_type_archive()) && $page = page_id_for_type()) {
        $id = $page;
    }

    return (int) $id;
}
