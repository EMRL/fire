# Taxonomies

The `Taxonomy` class provides some helpful methods to make creating a new taxonomy easier.

## Basic example

**Country.php**
```php
use Fire\Post\Post;
use Fire\Term\Taxonomy;
use DownloadColumn;

class Country extends Taxonomy
{
    const TAXONOMY = 'country';

    public function register(): self
    {
        // Register via array
        $this->registerTaxonomy([Post::TYPE], [
            'label' => 'Countries',
            'public' => true,
            'show_admin_column' => true,
        ]);

        // Or via callable that executes during `init` actions. More functions
        // are available and the main query has been parsed
        $this->registerTaxonomyFrom([Post::TYPE], [$this, 'args']);

        // Closure example
        $this->registerTaxonomyFrom([Post::TYPE], function () { return [...] });

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
    protected $key = 'download';

    protected $label = 'Download';

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
(new Country)->register();
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
        $this->modifyTaxonomy(function (array $args): array {
            $args['labels']['menu_name'] = $args['label'];
            return $args;
        });

        return $this;
    }
}
```

## Available methods

### `config()`

Return the taxonomy object/configuration.

Uses: [`get_taxonomy`](https://developer.wordpress.org/reference/functions/get_taxonomy/)

```php
use Fire\Term\Category;

$type = new Category();
echo $type->config()->public;
```

### `registerTaxonomy()`

Register taxonomy.

Uses: [`register_taxonomy`](https://developer.wordpress.org/reference/functions/register_taxonomy/)

```php
$this->registerTaxonomy([Post::TYPE], [
    'label' => 'Country',
    'public' => true,
]);
```

### `registerTaxonomyFrom()`

Register taxonomy via callable.

Uses: [`register_taxonomy`](https://developer.wordpress.org/reference/functions/register_taxonomy/)

```php
$this->registerTaxonomyFrom(['page'], [$this, 'args']);
$this->registerTaxonomyFrom(['post'], function (): array { return [...]; });
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

### `setArchiveTitle()`

Sets archive page title.

Adds filters: [`single_cat_title`](https://developer.wordpress.org/reference/hooks/single_cat_title/)  
Adds filters: [`single_tag_title`](https://developer.wordpress.org/reference/hooks/single_tag_title/)  
Adds filters: [`single_term_title`](https://developer.wordpress.org/reference/hooks/single_term_title/)

```php
$this->setArchiveTitle('Countries');
```


### `modifyArchiveTitle()`

Modifies archive page title.

Adds filters: [`single_cat_title`](https://developer.wordpress.org/reference/hooks/single_cat_title/)  
Adds filters: [`single_tag_title`](https://developer.wordpress.org/reference/hooks/single_tag_title/)  
Adds filters: [`single_term_title`](https://developer.wordpress.org/reference/hooks/single_term_title/)

```php
$this->modifyArchiveTitle('My Archive Page');
$this->modifyArchiveTitle(function (string $title): string { ... });
```

### `modifyLink()`

Modifies term link (URL).

Adds filters: [`term_link`](https://developer.wordpress.org/reference/hooks/term_link/)

```php
$this->modifyLink(function (string $url, WP_Term $term): string { ... });
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
