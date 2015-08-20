<?php

namespace Fire\Contracts\Asset;

interface AssetFinder
{
    /**
     * Find an asset file
     *
     * @param  string  $key
     * @return string
     */
    public function find($path);

    /**
     * Add a new path to search for asset files in
     *
     * @param  string  $path
     * @return void
     */
    public function addPath($path);
}
