# Post Types

The `Type` class provides some helpful methods to make creating a new post type easier.

## Basic example

**Resource.php**
```php
use Fire\Post\Type;
use DownloadColumn;

class Resource extends Type
{
    public const TYPE = 'resource';

    public function register(): self
    {
        // Register via array
        $this->registerType([
            'label' => 'Resources',
            'public' => true,
            'menu_icon' => 'dashicons-book',
        ]);

        // Or via callable that executes during `init` actions. More functions
        // are available and the main query has been parsed
        $this->registerTypeFrom([$this, 'args']);

        // Closure example
        $this->registerTypeFrom(fn (): array => [...]);

        $this->setTitlePlaceholder('Custom Input Placeholder');

        $this->addListTableColumnAfter(new DownloadColumn(), 'title');

        return $this;
    }

    public function args(): array
    {
        return [
            'label' => 'Resources',
            'public' => true,
            'hierarchical' => is_post_type_archive(static::TYPE),
        ];
    }
}
```

**DownloadColumn.php**
```php
use Fire\Post\Type\SortableListTableColumn;

class DownloadColumn extends SortableListTableColumn
{
    protected string $key = 'download';

    protected string $label = 'Download';

    public function display(int $id): void
    {
        printf(
            '<a href="%s" download>Download %s</a>',
            wp_get_attachment_url(get_post_meta($id, 'download', true)),
            $this->config()->labels->singular_name
        );
    }
}
```

**functions.php**
```php
use Fire\Post\Type\Hooks;

// This must be called first to setup necessary
// WordPress filters and actions for post types
(new Hooks())->register();

// Register post type
(new Resource())->register();
```

## Modify existing post types

```php
class Page extends \Fire\Post\Page
{
    public function register(): self
    {
        // These args will be merged with existing
        $this->mergeType([
            'public' => false,
        ]);

        // Or use a callback to modify or use existing args
        $this->modifyType(function (array $args): array {
            $args['labels']['menu_name'] = $args['label'];
            return $args;
        });

        return $this;
    }
}
```

## Public methods

### `register()`

Responsible for adding all hooks for post type. See examples above.

```php
(new Resource)->register();
```

### `object()`

Return post type object/configuration.

Uses: [`get_post_type_object`](https://developer.wordpress.org/reference/functions/get_post_type_object/)

```php
echo Resource::object()->public;
```

## Protected methods

The following are helper methods to be used by the post type class itself.

### `registerType()`

Register post type.

Uses: [`register_post_type`](https://developer.wordpress.org/reference/functions/register_post_type/)

```php
$this->registerType([
    'label' => 'Resource',
    'public' => true,
]);
```

### `registerTypeFrom()`

Register post type via callable

Uses: [`register_post_type`](https://developer.wordpress.org/reference/functions/register_post_type/)

```php
$this->registerTypeFrom([$this, 'args']);
$this->registerTypeFrom(fn (): array => [...]);
```

### `mergeType()`

Merge array with existing post type's configuration.

Argument reference: [`register_post_type`](https://developer.wordpress.org/reference/functions/register_post_type/)  
Adds filters: [`register_post_type_args`](https://developer.wordpress.org/reference/hooks/register_post_type_args/)

```php
$this->mergeType(['public' => false]);
```

### `modifyType()`

Modify existing post type's configuration. Callable will receive the existing configuration as first argument.

Argument reference: [`register_post_type`](https://developer.wordpress.org/reference/functions/register_post_type/)  
Adds filters: [`register_post_type_args`](https://developer.wordpress.org/reference/hooks/register_post_type_args/)

```php
$this->modifyType([$this, 'makePrivate']);

$this->modifyType(function (array $args): array {
    $args['public'] = false;
    return $args;
};
```

### `addSupport()`

Add post type support. Matches format used by `supports` argument in `register_post_type()`.

Argument reference: [`register_post_type`](https://developer.wordpress.org/reference/functions/register_post_type/)  
Uses: [`add_post_type_support`](https://developer.wordpress.org/reference/functions/add_post_type_support/)

```php
$this->addSupport(['title', 'example' => ['that' => 'uses array']]);
```

### `removeSupport()`

Remove post type support. Accepts variadic list of strings (features) to remove from post type.

Uses: [`remove_post_type_support`](https://developer.wordpress.org/reference/functions/remove_post_type_support/)

```php
$this->removeSupport('editor', 'comments');
```

### `setTitlePlaceholder()`

Sets placeholder for post title input field (admin screen) when creating or editing post.

Adds filters: [`enter_title_here`](https://developer.wordpress.org/reference/hooks/enter_title_here/)

```php
$this->setTitlePlaceholder('New Placeholder');
```

### `modifyTitlePlaceholder()`

Modifies placeholder for post title input field (admin screen) when creating or editing post.

Adds filters: [`enter_title_here`](https://developer.wordpress.org/reference/hooks/enter_title_here/)

```php
$this->modifyTitlePlaceholder(function (string $placeholder, WP_Post $post): string {
    if ($post->id === 1) {
        $placeholder = 'New Placeholder';
    }

    return $placeholder;
});
```

### `setArchiveTitle()`

Sets archive page title.

Adds filters: [`post_type_archive_title`](https://developer.wordpress.org/reference/hooks/post_type_archive_title/)

```php
$this->setArchiveTitle('My Archive Page');
```

### `modifyArchiveTitle()`

Modifies archive page title.

Adds filters: [`post_type_archive_title`](https://developer.wordpress.org/reference/hooks/post_type_archive_title/)

```php
$this->modifyArchiveTitle(fn (string $title): string => '...');
```

### `modifyLink()`

Modifies post type link (URL).

Adds filters: [`post_type_link`](https://developer.wordpress.org/reference/hooks/post_type_link/)

```php
$this->modifyLink(fn (string $url, WP_Post $post): string => '...');
```

### `setOnQuery()`

Hooks into the main query for post type (archive and single) and sets query vars.

If you would rather hook into all queries (not just the main) for this post type, pass `false` as the second argument.

Adds actions: [`pre_get_posts`](https://developer.wordpress.org/reference/hooks/pre_get_posts/)

```php
$this->setOnQuery(['key' => 'value']);

// Set for main query and other queries
$this->setOnQuery(['key' => 'value'], false);
```

### `setOnFrontendQuery()`

Hooks into frontend query for post type (archive and single) and sets query vars.

If you would rather hook into all queries (not just the main) for this post type, pass `false` as the second argument.

Adds actions: [`pre_get_posts`](https://developer.wordpress.org/reference/hooks/pre_get_posts/)

```php
$this->setOnFrontendQuery(['key' => 'value']);

// Set for main query and other queries
$this->setOnFrontendQuery(['key' => 'value'], false);
```

### `setOnAdminQuery()`

Hooks into admin query for post type (archive and single) and sets query vars.

Adds actions: [`pre_get_posts`](https://developer.wordpress.org/reference/hooks/pre_get_posts/)

```php
$this->setOnAdminQuery(['key' => 'value']);
```

### `modifyQuery()`

Hooks into query for post type (archive and single) to allow for modification.

If you would rather hook into all queries (not just the main) for this post type, pass `false` as the second argument.

Adds actions: [`pre_get_posts`](https://developer.wordpress.org/reference/hooks/pre_get_posts/)

```php
$this->modifyQuery(function (WP_Query $query): void {
    $query->set('posts_per_page', 20);
});

// Sets the default order for main and other queries together
$this->modifyQuery(function (WP_Query $query): void {
    if (!$query->get('orderby')) {
        $query->set('orderby', ['title' => 'asc']);
    }
}, false);
```

### `modifyFrontendQuery()`

Hooks into frontend query for post type (archive and single) to allow for modification.

If you would rather hook into all queries (not just the main) for this post type, pass `false` as the second argument.

Adds actions: [`pre_get_posts`](https://developer.wordpress.org/reference/hooks/pre_get_posts/)

```php
$this->modifyFrontendQuery(function (WP_Query $query): void {
    $query->set('posts_per_page', 20);
});

// Set for main query and other queries
$this->modifyFrontendQuery(function (WP_Query $query): void {
    $query->set('posts_per_page', 20);
}, false);
```

### `modifyAdminQuery()`

Hooks into admin query for post type (archive and single) to allow for modification.

Adds actions: [`pre_get_posts`](https://developer.wordpress.org/reference/hooks/pre_get_posts/)

```php
$this->modifyAdminQuery(function (WP_Query $query): void {
    $query->set('posts_per_page', 20);
});
```

### `modifyListTableColumns()`

Allows modification of list table columns.

Adds filters: [`manage_{$post_type}_posts_columns`](https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/)

```php
$this->modifyListTableColumns(function (array $cols): array {
    $cols['download'] = 'Download';
    return $cols;
});

// Or use helper function
$this->modifyListTableColumns(filter_merge(['download' => 'Download']));
```

### `modifySortableListTableColumns()`

Allows modification of sortable list table columns.

Adds filters: [`manage_{$this->screen->id}_sortable_columns`](https://developer.wordpress.org/reference/hooks/manage_this-screen-id_sortable_columns/)

```php
$this->modifySortableListTableColumns(function (array $cols): array {
    $cols['download'] = 'download';
    return $cols;
});

// Or use helper function
$this->modifySortableListTableColumns(filter_remove_key(['title']));
```

### `modifyListTableColumnDisplay()`

Output content for custom list table column.

Adds actions: [`manage_{$post->post_type}_posts_custom_column`](https://developer.wordpress.org/reference/hooks/manage_post-post_type_posts_custom_column/)

```php
$this->modifyListTableColumnDisplay(function (string $column, int $id): void {
    switch ($column) {
        case 'download':
            printf(
                '<a href="%s">Download %s</a>',
                wp_get_attachment_url(get_post_meta($id, 'download', true)),
                $this->config()->labels->singular_name
            );
            break;
    }
});
```

### `addListTableColumn()`

Adds column to end of list table.

This is a shortcut that combines `modifyQuery()`, `modifyListTableColumns()`, `modifySortableListTableColumns()`, and `modifyListTableColumnDisplay()`.

```php
$this->addListTableColumn(new DownloadColumn());
```

### `addListTableColumnBefore()`

Adds column before another existing column.

This is a shortcut that combines `modifyQuery()`, `modifyListTableColumns()`, `modifySortableListTableColumns()`, and `modifyListTableColumnDisplay()`.

```php
// Add download column before date column
$this->addListTableColumnBefore(new DownloadColumn(), 'date');
```

### `addListTableColumnAfter()`

Adds column after another existing column.

This is a shortcut that combines `modifyQuery()`, `modifyListTableColumns()`, `modifySortableListTableColumns()`, and `modifyListTableColumnDisplay()`.

```php
// Add download column after title column
$this->addListTableColumnAfter(new DownloadColumn(), 'title');
```

### `registerArchivePageSetting()`

Registers setting field on Reading options page to allow assigning a page to post type.

```php
$this->registerArchivePageSetting();

$this->registerArchivePageSetting(function (WP_Post_Type $type): string {
    return $type->labels->singular_name;
});
```

## Functions

### `is_type()`

Test if current post's type matches passed type.

```php
if (Fire\Post\is_type('page')) {
    // This post belongs to the `page` post type
}
```

### `page_for_type()`

Get the page assigned for the type (or currently queried type) as an iterator ready to loop.

```php
<?php foreach (Fire\Post\page_for_type() as $archive): ?>
    <h1><?php the_title() ?></h1>
<?php endforeach ?>

<?php foreach (Fire\Post\page_for_type('portfolio') as $archive): ?>
    <h1><?php the_title() ?></h1>
<?php endforeach ?>
```

### `page_id_for_type()`

Get the page ID for the type (or currently queried type).

```php
$id = Fire\Post\page_id_for_type();
$id = Fire\Post\page_id_for_type('portfolio');
```

### `has_page_for_type()`

Test whether the post type has a page assigned to it.

```php
<?php if (Fire\Post\has_page_for_type()): ?>
    <?php foreach (Fire\Post\page_for_type() as $archive): ?>
        <div>
            <?php the_content() ?>
        </div>
    <?php endforeach ?>
<?php endforeach ?>

<?php if (Fire\Post\has_page_for_type('portfolio')): ?>
    <?php foreach (Fire\Post\page_for_type('portfolio') as $archive): ?>
        <div>
            <?php the_content() ?>
        </div>
    <?php endforeach ?>
<?php endforeach ?>
```

### `id()`

Gets the ID of the current post or the ID of the assigned post type page if you are viewing a post type archive.

```php
$show_title = get_post_meta(Fire\Post\id(), 'page_show_title', true);
```

### `generate_labels()`

Generate labels for post types.

```php
$this->registerType([
    'labels' => Fire\Post\Type\generate_labels('Resources', 'Resource', [
        'all_items' => 'All types of resources',
    ]),
]);
```

Next: [Query](query.md)
