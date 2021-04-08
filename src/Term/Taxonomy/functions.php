<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

/**
 * Generate taxonomy labels
 */
function generate_labels(string $plural, string $singular, array $labels = []): array
{
    $plural_lower = strtolower($plural);
    $singular_lower = strtolower($singular);

    return array_merge([
        'name' => $plural,
        'singular_name' => $singular,
        'search_items' => "Search $plural",
        'popular_items' => "Popular $plural",
        'all_items' => "All $plural",
        'parent_item' => "Parent $singular",
        'parent_item_colon' => "Parent $singular:",
        'edit_item' => "Edit $singular",
        'view_item' => "View $singular",
        'update_item' => "Update $singular",
        'add_new_item' => "Add New $singular",
        'new_item_name' => "New $singular Name",
        'separate_items_with_commas' => "Separate $plural_lower with commas",
        'add_or_remove_items' => "Add or remove $plural_lower",
        'choose_from_most_used' => "Choose from the most used $plural_lower",
        'not_found' => "No $plural_lower found",
        'no_terms' => "No $plural_lower",
        'items_list_navigation' => "$plural list navigation",
        'items_list' => "$plural list",
        'back_to_items' => "← Go to $plural",
        'filter_by_item' => "Filter by $singular_lower",
    ], $labels);
}
