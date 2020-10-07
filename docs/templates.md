# Templates

## Layout

Instead of calling `get_header()` and `get_footer()` in each and every template file, this class allows you to set layouts that wrap your template files.

```php
use Fire\Template\Layout;

$content = (new Layout())->register();
// This tells WordPress to load the `layout.php` template file, and returns the
// contents of the original template (ie: page.php or index.php) when cast
// to a string (echo'd)
```

This would typically be used in conjunction with the [`Inject()`](query.md) class.

```php
use Fire\Query\Inject;
use Fire\Template\Layout;

(new Inject([
    'content' => (new Layout())->register(),
]))->register();
```

Then in `layout.php`:

```php
<html>
    <head>
        <?php wp_head() ?>
    </head>
    <body>
        <header>
            ...
        </header>
        <?php echo $content ?>
        <footer>
            ...
        </footer>
        <?php wp_footer() ?>
    </body>
</html>
```

It is also possible to set a different default layout, as well as specific layouts for individual templates.

```php
use Fire\Template\Layout;

$content = (new Layout('layout.default.php')
    ->setLayoutFor('page.php', 'layout.page.php')
    ->setLayoutFor('archive.php', 'layout.archive.php')
    ->register();
```

Some plugins also filter the WordPress template, and this may cause conflicts with the layout. If you need to adjust the priority of the template filter you can use the `setPriority()` method.

```php
use Fire\Template\Layout;

$content = (new Layout())
    ->setPriority(50)
    ->register();
```

## Functions

### `buffer()`

Uses output buffering to return output from callable.

```php
use function Fire\Template\buffer;

$content = buffer('the_content');

$content = buffer(function (): void {
    echo 'Hello world!';
});
```

### `html_attributes`

Transforms associative array into string of HTML attributes. If boolean `true` is passed as value, only the attribute name will be included. All values will be escaped.

```php
use function Fire\Template\html_attributes;

$attrs = html_attributes([
    'required' => true,
    'width' => 50,
    'class' => 'something',
]);

printf('<div%s>Hello</div>', $attrs);
// <div required width="50" class="something"></div>
```

### `nav_menu_items()`

Returns HTML for list items in menu. This is a shortcut to remove the default wrapper that [`wp_nav_menu`](https://developer.wordpress.org/reference/functions/wp_nav_menu/) normally uses. An array can be passed to be merged with defaults.

```php
<nav class="primary-menu">
    <ul>
        <?php echo Fire\Template\nav_menu_items(['theme_location' => 'primary']) ?>
        <li>
            Static item at the end
        </li>
    </ul>
</nav>
```

Next: [Value Objects](value-objects.md)
