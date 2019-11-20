# Post Types

The `Type` class provides some helpful methods to make creating a new post type easier.

## Basic example

**Resource.php**
```php
use Fire\Post\Type;
use DownloadColumn;

class Resource extends Type
{
    const TYPE = 'resource';

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
        $this->registerTypeFrom(function () { return [...] });

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
    protected $key = 'download';

    protected $label = 'Download';

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
(new Resource())->register();
```

## Modify existing post types

```php
class Page extends \Fire\Post\Page
{
    public function __construct()
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
    }
}
```

## Available methods

### `config()`

Return post type object/configuration.

Uses: [`get_post_type_object`](https://developer.wordpress.org/reference/functions/get_post_type_object/)

```php
echo $this->config()->public;
```

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
$this->registerType([$this, 'args']);
$this->registerType(function (): array { return [...]; })
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
$this->modify([$this, 'makePrivate']);

$this->modify(function (array $args): array {
    $args['public'] = false;
    return $args;
};
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
$this->modifyArchiveTitle(function (string $title): string { ... });
```

### `modifyLink()`

Modifies post type link (URL).

Adds filters: [`post_type_link`](https://developer.wordpress.org/reference/hooks/post_type_link/)

```php
$this->modifyLink(function (string $url, WP_Post $post): string { ... });
```

### `setOnQuery()`

Hooks into query for post type (archive and single) and sets query vars.

Adds actions: [`pre_get_posts`](https://developer.wordpress.org/reference/hooks/pre_get_posts/)

```php
$this->setOnQuery(['key' => 'value']);
```

### `modifyQuery()`

Hooks into query for post type (archive and single) to allow for modification.

Adds actions: [`pre_get_posts`](https://developer.wordpress.org/reference/hooks/pre_get_posts/)

```php
$this->modifyQuery(function (WP_Query $query): void {
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

Next: [Query](query.md)
