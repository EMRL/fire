<?php

declare(strict_types=1);

namespace Fire\Post\Type;

/**
 * Generate post type labels
 */
function generate_labels(string $plural, string $singular, array $labels = []): array
{
    return array_merge([
        'name' => $plural,
        'singular_name' => $singular,
        'add_new_item' => "Add New $singular",
        'edit_item' => "Edit $singular",
        'new_item' => "New $singular",
        'view_item' => "View $singular",
        'view_items' => "View $plural",
        'search_items' => "Search $plural",
        'not_found' => sprintf('No %s found', strtolower($plural)),
        'not_found_in_trash' => sprintf('No %s found in Trash', strtolower($plural)),
        'parent_item_colon' => "Parent $singular:",
        'all_items' => "All $plural",
        'archives' => "$singular Archives",
        'attributes' => "$singular Attributes",
        'insert_into_item' => sprintf('Insert into %s', strtolower($singular)),
        'uploaded_to_this_item' => sprintf('Uploaded to this %s', strtolower($singular)),
        'filter_items_list' => sprintf('Filter %s list', strtolower($plural)),
        'items_list_navigation' => "$plural list navigation",
        'items_list' => "$plural list",
        'item_published' => "$singular published.",
        'item_published_privately' => "$singular published privately.",
        'item_reverted_to_draft' => "$singular reverted to draft.",
        'item_scheduled' => "$singular scheduled.",
        'item_updated' => "$singular updated.",
    ], $labels);
}
