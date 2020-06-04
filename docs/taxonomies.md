# Taxonomies

The `Taxonomy` class provides some helpful methods to make creating a new taxonomy easier.

## Basic example

**Country.php**
```php
use Fire\Post\Post;
use Fire\Post\Page;
use Fire\Term\Taxonomy;
use DownloadColumn;

class Country extends Taxonomy
{
    public const TAXONOMY = 'country';

    public function register(): self
    {
        // Register via array
        $this->registerTaxonomy([
            'label' => 'Countries',
            'public' => true,
            'show_admin_column' => true,
        ], Post::TYPE, Page::TYPE);

        // Or via callable that executes during `init` actions. More functions
        // are available and the main query has been parsed
        $this->registerTaxonomyFrom([$this, 'args'], Post::TYPE);

        // Closure example
        $this->registerTaxonomyFrom(fn () => [...], Post::TYPE);

        $this->addListTableColumnAfter(new DownloadColumn(), 'title');

        return $this;
    }

    public function args(): array
    {
        return [
            'label' => 'Resources',
            'public' => true,
            'hierarchical' => is_post_type_archive(Post::TYPE),
        ];
    }
}
```

**DownloadColumn.php**
```php
use Fire\Admin\ListTableColumn;

class DownloadColumn extends ListTableColumn
{
    protected string $key = 'download';

    protected string $label = 'Download';

    public function display(int $id): void
    {
        printf(
            '<a href="%s" download>Download %s</a>',
            wp_get_attachment_url(get_term_meta($id, 'download', true)),
            $this->config()->labels->singular_name
        );
    }
}
```

**functions.php**
```php
use Fire\Term\Taxonomy\Hooks;

// This must be called first to setup necessary
// WordPress filters and actions for taxonomies
(new Hooks())->register();

// Register taxonomy
(new Country())->register();
```

## Modify existing taxonomies

```php
class Category extends \Fire\Term\Category
{
    public function register(): self
    {
        // These args will be merged with existing
        $this->mergeTaxonomy([
            'public' => false,
        ]);

        // Or use a callback to modify or use existing args
        $this->modifyTaxonomy(function (array $args, array $types): array {
            $args['labels']['menu_name'] = $args['label'];
            return $args;
        });

        return $this;
    }
}
```

## Public methods

### `register()`

Responsible for adding all hooks for taxonomy. See examples above.

```php
(new Country)->register();
```

### `config()`

Return taxonomy object/configuration.

Uses: [`get_taxonomy`](https://developer.wordpress.org/reference/functions/get_taxonomy/)

```php
echo $type->config()->public;
```

## Protected methods

The following are helper methods to be used by the taxonomy class itself.

### `registerTaxonomy()`

Register taxonomy.

Uses: [`register_taxonomy`](https://developer.wordpress.org/reference/functions/register_taxonomy/)

```php
$this->registerTaxonomy([
    'label' => 'Country',
    'public' => true,
], 'post', 'page');
```

### `registerTaxonomyFrom()`

Register taxonomy via callable.

Uses: [`register_taxonomy`](https://developer.wordpress.org/reference/functions/register_taxonomy/)

```php
$this->registerTaxonomyFrom([$this, 'args'], Post::TYPE);
$this->registerTaxonomyFrom(fn (): array => [...], 'page');
```

### `mergeTaxonomy()`

Merge array with existing taxonomy's configuration.

Argument reference: [`register_taxonomy`](https://developer.wordpress.org/reference/functions/register_taxonomy/)  
Adds filters: [`register_taxonomy_args`](https://developer.wordpress.org/reference/hooks/register_taxonomy_args/)

```php
$this->mergeTaxonomy(['public' => false]);
```

### `modifyTaxonomy()`

Modify existing taxonomy's configuration. Callable will receive the existing configuration as first argument.

Argument reference: [`register_taxonomy`](https://developer.wordpress.org/reference/functions/register_taxonomy/)  
Adds filters: [`register_taxonomy_args`](https://developer.wordpress.org/reference/hooks/register_taxonomy_args/)

```php
$this->modifyTaxonomy([$this, 'makePrivate']);

$this->modifyTaxonomy(function (array $args, array $types): array {
    $args['public'] = false;
    return $args;
};
```

### `modifyLink()`

Modifies term link (URL).

Adds filters: [`term_link`](https://developer.wordpress.org/reference/hooks/term_link/)

```php
$this->modifyLink(fn (string $url, WP_Term $term): string => '...');
```

### `modifyListTableColumns()`

Allows modification of list table columns.

Adds filters: [`manage_edit-{$taxonomy}_columns`](https://developer.wordpress.org/reference/hooks/manage_screen-id_columns/)

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

Adds actions: [`manage_{$this->screen->taxonomy}_custom_column`](https://developer.wordpress.org/reference/hooks/manage_this-screen-taxonomy_custom_column/)

```php
$this->modifyListTableColumnDisplay(function (string $_, string $column, int $id): void {
    switch ($column) {
        case 'download':
            printf(
                '<a href="%s">Download %s</a>',
                wp_get_attachment_url(get_term_meta($id, 'download', true)),
                $this->config()->labels->singular_name
            );
            break;
    }
});
```

### `addListTableColumn()`

Adds column to end of list table.

This is a shortcut that combines `modifyListTableColumns()` and `modifyListTableColumnDisplay()`.

```php
$this->addListTableColumn(new DownloadColumn());
```

### `addListTableColumnBefore()`

Adds column before another existing column.

This is a shortcut that combines `modifyListTableColumns()`, and `modifyListTableColumnDisplay()`.

```php
$this->addListTableColumnBefore(new DownloadColumn(), 'date');
```

### `addListTableColumnAfter()`

Adds column after another existing column.

This is a shortcut that combines `modifyListTableColumns()` and `modifyListTableColumnDisplay()`.

```php
$this->addListTableColumnAfter(new DownloadColumn(), 'title');
```

Next: [Templates](templates.md)
