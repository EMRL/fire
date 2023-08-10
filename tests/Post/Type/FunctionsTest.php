<?php

declare(strict_types=1);

namespace Fire\Tests\Post\Type;

use PHPUnit\Framework\TestCase;

use function Fire\Post\Type\generate_labels;

final class FunctionsTest extends TestCase
{
    public function testGenerateLabels(): void
    {
        $this->assertSame([
            'name' => 'Resources',
            'singular_name' => 'Resource',
            'add_new_item' => 'Add New Resource',
            'edit_item' => 'Edit Resource',
            'new_item' => 'New Resource',
            'view_item' => 'View Resource',
            'view_items' => 'View Resources',
            'search_items' => 'Search Resources',
            'not_found' => 'No resources found',
            'not_found_in_trash' => 'No resources found in Trash',
            'parent_item_colon' => 'Parent Resource:',
            'all_items' => 'Something different',
            'archives' => 'Resource Archives',
            'attributes' => 'Resource Attributes',
            'insert_into_item' => 'Insert into resource',
            'uploaded_to_this_item' => 'Uploaded to this resource',
            'filter_items_list' => 'Filter resources list',
            'items_list_navigation' => 'Resources list navigation',
            'items_list' => 'Resources list',
            'item_published' => 'Resource published.',
            'item_published_privately' => 'Resource published privately.',
            'item_reverted_to_draft' => 'Resource reverted to draft.',
            'item_trashed' => 'Resource trashed.',
            'item_scheduled' => 'Resource scheduled.',
            'item_updated' => 'Resource updated.',
        ], generate_labels('Resources', 'Resource', [
            'all_items' => 'Something different',
        ]));
    }
}
