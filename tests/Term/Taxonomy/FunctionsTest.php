<?php

declare(strict_types=1);

namespace Fire\Tests\Term\Taxonomy;

use PHPUnit\Framework\TestCase;

use function Fire\Term\Taxonomy\generate_labels;

final class FunctionsTest extends TestCase
{
    public function testGenerateLabels(): void
    {
        $this->assertSame([
            'name' => 'Resources',
            'singular_name' => 'Resource',
            'search_items' => 'Search Resources',
            'popular_items' => 'Popular Resources',
            'all_items' => 'Something different',
            'parent_item' => 'Parent Resource',
            'parent_item_colon' => 'Parent Resource:',
            'edit_item' => 'Edit Resource',
            'view_item' => 'View Resource',
            'update_item' => 'Update Resource',
            'add_new_item' => 'Add New Resource',
            'new_item_name' => 'New Resource Name',
            'separate_items_with_commas' => 'Separate resources with commas',
            'add_or_remove_items' => 'Add or remove resources',
            'choose_from_most_used' => 'Choose from the most used resources',
            'not_found' => 'No resources found',
            'no_terms' => 'No resources',
            'items_list_navigation' => 'Resources list navigation',
            'items_list' => 'Resources list',
            'back_to_items' => '← Go to Resources',
        ], generate_labels('Resources', 'Resource', [
            'all_items' => 'Something different',
        ]));
    }
}
