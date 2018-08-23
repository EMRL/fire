<?php

if ( ! function_exists('asset')) {
    /**
     * Return a URL to an asset
     *
     * Pass `true` as the second argument to return a "cache-busted" version
     * of the URL (deprecated in favor of using a manifest.json file)
     *
     * @param string $key
     * @param boolean $hash
     * @return string
     */
    function asset($key, $hash = false)
    {
        return fire('asset')->url($key, $hash);
    }
}

if ( ! function_exists('asset_path')) {
    /**
     * Return the full path to an asset file
     *
     * @param string $key
     * @return string
     */
    function asset_path($key)
    {
        return fire('asset')->path($key);
    }
}

if ( ! function_exists('assetPath')) {
    /**
     * Return the full path to an asset file
     *
     * @deprecated 2.3.0 Use `asset_path` instead
     * @param string $key
     * @return string
     */
    function assetPath($key)
    {
        return asset_path($key);
    }
}
