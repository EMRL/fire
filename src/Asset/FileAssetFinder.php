<?php

namespace Fire\Asset;

use Fire\Contracts\Asset\AssetFinder as AssetFinderContract;
use Fire\Contracts\Filesystem\Filesystem as FilesystemContract;
use InvalidArgumentException;

class FileAssetFinder implements AssetFinderContract
{
    /**
     * The filesystem used for finding assets
     *
     * @var \Fire\Contracts\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Paths to look for assets in
     *
     * @var array
     */
    protected $paths = [];

    /**
     * Assets that have been found, used to cache lookups
     *
     * @var array
     */
    protected $found = [];

    /**
     * Create a new asset finder
     *
     * @param  \Fire\Contracts\Filesystem\Filesystem  $filesystem
     * @param  array  $paths
     * @return void
     */
    public function __construct(FilesystemContract $filesystem, array $paths)
    {
        $this->filesystem = $filesystem;
        $this->paths      = array_map('trailingslashit', $paths);
    }

    public function find($key)
    {
        if (isset($this->found[$key])) {
            return $this->found[$key];
        }

        return $this->found[$key] = $this->findInPaths($key, $this->paths);
    }

    /**
     * Search through all bound paths to find the asset file
     *
     * @param  string  $key
     * @param  array   $paths
     * @return string
     */
    protected function findInPaths($key, array $paths)
    {
        $found = false;

        foreach ($paths as $path) {
            if ($this->filesystem->isFile($asset = $path.$key)) {
                $found = $asset;
                break;
            }
        }

        return $found;
    }

    public function addPath($path)
    {
        array_unshift($this->paths, trailingslashit($path));
    }
}
