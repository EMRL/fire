# Functions

Useful utilities to write less code.

## `array_insert()`

Insert array into another array before or after another key.

```php
use function Fire\Core\array_insert;

$arr = [
    'a' => 'One',
    'c' => 'Three',
];

$arr2 = ['b' => 'Two'];

// Insert after
$arr = array_insert($a, $b, 'a');
// [
//     'a' => 'One',
//     'b' => 'Two',
//     'c' => 'Three',
// ]

// Insert before
$arr = array_insert($a, $b, 'c', false);
```

## `array_smart_merge()`

Overwrites simple values, and merges array values.

```php
use function Fire\Core\array_smart_merge;

$arr = [
    'a' => 'A',
    'b' => ['B'],
];

$arr2 = [
    'a' => 'AAA',
    'b' => ['BBB'],
];

$arr = array_smart_merge($arr, $arr2);
// [
//     'a' => 'AAA',
//     'b' => ['B', 'BBB'],
// ]
```

## `filter_insert()`

Shortcut for using `array_insert` as filter.

```php
use function Fire\Core\filter_insert;

// Add our custom column after the existing `title` column
add_filter('manage_pages_columns', filter_insert(['custom' => 'Custom'], 'title'));
```

## `filter_merge()`

Shortcut for using `array_merge` as filter.

```php
use function Fire\Core\filter_merge;

add_filter('body_class', filter_merge(['class-name']));
```

## `filter_remove()`

Shortcut for removing elements from array as filter.

```php
use function Fire\Core\filter_remove;

add_filter('body_class', filter_remove(['class-name']));
```

## `filter_remove_key()`

Shortcut for removing elements from array by key as filter.

```php
use function Fire\Core\filter_remove_key;

// Remove `title` column
add_filter('manage_pages_columns', filter_remove_key(['title']));
```

## `filter_value()`

Shortcut for returning value as filter.

```php
use function Fire\Core\filter_value;

add_filter('login_headertext', filter_value('Website Login'));
```

## `parse_hosts()`

Parse list of hosts to return only valid hosts.

```php
use function Fire\Core\parse_hosts;

$hosts = parse_hosts('http://website.com/page/', 'test.com', '//');
// ['website.com', 'test.com']
```

## `value()`

Returns value that may be wrapped inside callback function. Optionally pass parameters to the callback.

```php
use function Fire\Core\value;

$now = 1;
$lazy = fn (): int => 1;
$another = fn (int $a, int $b): int => $a + $b;
$three = 3;

value($now);
// 1

value($lazy);
// 1

value($another, 1, 2);
// 3

value($three, 1, 2);
// 3
```

Next: [Menus](menus.md)
