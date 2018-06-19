<?php

namespace Fire\Asset;

use Fire\Contracts\Asset\Asset as AssetContract;
use Fire\Contracts\Asset\AssetFinder as AssetFinderContract;

class Asset implements AssetContract
{
    /**
     * Asset finder
     *
     * @var \Fire\Contracts\Asset\AssetFinder
     */
    protected $finder;

    /**
     * Create a new Asset
     *
     * @param  \Fire\Contracts\Asset\AssetFinder  $finder
     * @return void
     */
    public function __construct(AssetFinderContract $finder)
    {
        $this->finder = $finder;
    }

    public function path($key)
    {
        return $this->finder->find($key);
    }

    /**
     * Get the root-relative URL to an asset, and optionally use cache-busting hash
     *
     * @inheritDoc
     *
     * @param  boolean  $hash  Flag to use cache busting or not
     */
    public function url($key, $hash = false)
    {
        if ($hash) {
            return $this->hashedUrl($key);
        }

        $dir = wp_normalize_path(WP_CONTENT_DIR);
        $url = content_url();
        $file = wp_normalize_path($this->path($key));

        return str_replace($dir, $url, $file);
    }

    /**
     * Returns a URL with a prefix of a hash of the file's contents appended
     * to the filename. This is used for busting the cache and making sure browsers
     * can cache the asset until it changes.
     *
     * @param  string  $key
     * @return string
     */
    public function hashedUrl($key)
    {
        $file  = $this->path($key);
        $hash  = substr(sha1_file($file), 0, 8);
        $parts = preg_split('/\.(?=[^\.]+$)/', $this->url($key));

        return sprintf('%s.%s.%s', $parts[0], $hash, $parts[1]);
    }
}
