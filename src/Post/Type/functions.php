<?php

declare(strict_types=1);

namespace Fire\Post\Type;

/**
 * Generate post type labels
 */
function generate_labels(string $plural, string $singular, array $labels = []): array
{
    $plural_lower = strtolower($plural);
    $singular_lower = strtolower($singular);

    return array_merge([
        'name' => $plural,
        'singular_name' => $singular,
        'add_new_item' => "Add New $singular",
        'edit_item' => "Edit $singular",
        'new_item' => "New $singular",
        'view_item' => "View $singular",
        'view_items' => "View $plural",
        'search_items' => "Search $plural",
        'not_found' => "No $plural_lower found",
        'not_found_in_trash' => "No $plural_lower found in Trash",
        'parent_item_colon' => "Parent $singular:",
        'all_items' => "All $plural",
        'archives' => "$singular Archives",
        'attributes' => "$singular Attributes",
        'insert_into_item' => "Insert into $singular_lower",
        'uploaded_to_this_item' => "Uploaded to this $singular_lower",
        'filter_items_list' => "Filter $plural_lower list",
        'items_list_navigation' => "$plural list navigation",
        'items_list' => "$plural list",
        'item_published' => "$singular published.",
        'item_published_privately' => "$singular published privately.",
        'item_reverted_to_draft' => "$singular reverted to draft.",
        'item_trashed' => "$singular trashed.",
        'item_scheduled' => "$singular scheduled.",
        'item_updated' => "$singular updated.",
    ], $labels);
}
