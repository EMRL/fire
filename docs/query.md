# Query

Utilities to work with [`WP_Query`](https://developer.wordpress.org/reference/classes/wp_query/)

## Iterator

This class acts as a simple wrapper to allow iteration of `WP_Query->posts` via `foreach`. It returns a `Generator`, so all WordPress loop functions will work correctly.

```php
<?php foreach (new Fire\Query\Iterator($wp_query) as $article): ?>
    <h1><?php the_title() ?></h1>
    <time><?php echo date('F j, Y', strtotime($article->post_date)) ?></time>
<?php endforeach ?>
```

## 404 Resolver

Sometimes it is useful and necessary to force WordPress to render a 404 error response. For example, if you want to prevent WordPress' default behavior of showing author archives, you can use this class to return a 404 when an author archive page is requested.

```php
use Fire\Query\ResolveAs404;

(new ResolveAs404(
    'is_author',
    fn (): bool => is_author(4),
))->register();
```

## Variable injector

Inject query variables into all instances of `WP_Query`. This is mostly useful for using the variables in templates, as [`load_template`](https://developer.wordpress.org/reference/functions/load_template/) extracts `$wp_query->query_vars`.

```php
use Fire\Query\Inject;

(new Inject([
    'var' => 'testing',
    'other' => 10,
]))->register();
```

Later in your template you could use those variables:

```php
<?php if ($other > 9): ?>
    <h1><?php echo $var ?></h1>
<?php endif ?>
```

Next: [Taxonomies](taxonomies.md)
