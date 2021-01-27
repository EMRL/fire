# Menus

## Descriptions

Show menu item descriptions. You must include the placeholder (`%s`) in at least one of the following arguments in order for the descriptions to show: `before`, `link_before`, `link_after`, `after`.

You may modify the format of the description by including a `descriptions` argument and the `%s` placeholder for where the description should appear (defaults to `<div>%s</div>`).

```php
new Fire\Menu\Descriptions();

// Use placeholder to tell WordPress where to show the descriptions
wp_nav_menu([
    // ...other args
    'descriptions' => '<span class="description">%s</span>',
    'after' => '<div class="menu-item-after">%s</div>',
]);
```

Would produce output similar to:

```html
<li class="menu-item">
    <a href="#">Link title</a>
    <div class="menu-item-after">
        <span class="description">This is the description</span>
    </div>
</li>
```

## Level Wrapper

This allows you to include wrapping elements for submenus (default is `<div></div>`).

```php
wp_nav_menu([
    // ...other args
    'walker' => new Fire\Menu\LevelWrapWalker('<div class="submenu-wrap">', '</div>'),
]);
```

Would produce output similar to:

```html
<li class="menu-item-has-children">
    <a href="#">Item</a>
    <div class="submenu-wrap">
        <ul class="submenu">
            ...
        </ul>
    </div>
</li>
```

You may also use a callback function if you need to access the `$depth` or `$args` parameters for your wrapper:

```php
wp_nav_menu([
    'walker' => (new Fire\Menu\LevelWrapWalker())
        ->setTagsFrom(function (callable $setTags, int $depth, array $args): void {
            $setTags("<div class='wrap-level-$depth'>", "</div>");
        }),
]);
```

Next: [Post Types](post-types.md)
