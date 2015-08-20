<?php

if ( ! function_exists('asset')) {
    /**
     * Return a URL to an asset
     *
     * Pass `true` as the second argument to return a "cache-busted" version
     * of the URL
     * @param  string   $key
     * @param  boolean  $hash
     * @return string
     */
    function asset($key, $hash = false)
    {
        return fire('asset')->url($key, $hash);
    }
}

if ( ! function_exists('assetPath')) {
    /**
     * Return the full path to an asset file
     *
     * @param  string  $key
     * @return string
     */
    function assetPath($key)
    {
        return fire('asset')->path($key);
    }
}
