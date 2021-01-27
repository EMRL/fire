<?php

declare(strict_types=1);

namespace Fire\Term\Taxonomy;

/**
 * Generate taxonomy labels
 */
function generate_labels(string $plural, string $singular, array $labels = []): array
{
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
        'separate_items_with_commas' => sprintf('Separate %s with commas', strtolower($plural)),
        'add_or_remove_items' => sprintf('Add or remove %s', strtolower($plural)),
        'choose_from_most_used' => sprintf('Choose from the most used %s', strtolower($plural)),
        'not_found' => sprintf('No %s found', strtolower($plural)),
        'no_terms' => sprintf('No %s', strtolower($plural)),
        'items_list_navigation' => "$plural list navigation",
        'items_list' => "$plural list",
        'back_to_items' => "← Go to $plural",
    ], $labels);
}
