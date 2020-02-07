# Assets

## Cache bust enqueued scripts and styles

This rewrites URLs for enqueued scripts and styles, transforming the version query parameter into a hash in the filename. There are [several benefits](https://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring/) of doing this.

All assets that match the given hosts will be updated (including scripts enqueued by plugins and WordPress core).

**A server rewrite must be set up to serve the correct file. Example:**

```apache
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)\.[a-z0-9]{10}\.(js|css)$ $1.$2 [L]
```

Example input:

```php
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('test', 'test.js', [], '3.5');
});
```

Normal output:

```html
<script src="test.js?ver=3.5"></script>
```

Output after cache bust:

```html
<script src="test.c3e66c1668.js"></script>
```

## Usage

```php
use Fire\Core\CacheBustScripts;

(new CacheBustScripts())->register();

// Or set the valid hosts and hash length
(new CacheBustScripts(home_url(), 'cdn.mysite.com'))
    ->setHashLength(5)
    ->register();
```

## Linking to assets and files

```php
use Fire\Path\Join;
use Fire\Query\Inject;

(new Inject([
    'path' => new Join(get_theme_file_path()),
    'url' => new Join(get_theme_file_uri()),
]))->register();
```

**`page.php`**
```php
<link rel="stylesheet" href="<?php echo $url('assets/css/theme.css') ?>">
...
<div class="inline-svg">
    <?php echo file_get_contents($path('assets/svg/icon.svg')) ?>
</div>
```

#### Using a manifest file

If you compile files using a bundler (Webpack, rollup, etc) and enable filename
hashing, you can link to the hashed version based on a manifest file lookup. If
a file is found in the manifest, its hashed filename will be used.

**`manifest.json`**:
```json
{
    "assets/css/theme.css": "assets/css/theme.a5d93efdc6.css",
    "assets/svg/icon.svg": "assets/svg/icon.50adc312de.svg"
}
```

```php
use Fire\Path\Join;
use Fire\Path\JoinManifest;
use Fire\Query\Inject;

$manifest = get_theme_file_path('assets/manifest.json');

(new Inject([
    'path' => new JoinManifest(new Join(get_theme_file_path()), $manifest),
    'url' => new JoinManifest(new Join(get_theme_file_uri()), $manifest),
]))->register();
```

Next: [Dashboard](dashboard.md)
