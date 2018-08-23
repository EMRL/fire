<?php

namespace Fire\Contracts\Asset;

interface Asset
{
    /**
     * Get the full path to an asset
     *
     * @param string $key
     * @return string
     */
    public function path($key);

    /**
     * Get the root-relative URL to an asset
     *
     *     $asset->url('test.css')
     *     // could return "/wp-content/themes/theme/assets/test.css"
     *
     * @param string $key
     * @return string
     */
    public function url($key);
}
