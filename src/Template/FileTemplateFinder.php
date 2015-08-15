<?php

namespace Fire\Template;

use Fire\Contracts\Template\TemplateFinder as TemplateFinderContract;
use Fire\Contracts\Filesystem\Filesystem as FilesystemContract;
use InvalidArgumentException;

class FileTemplateFinder implements TemplateFinderContract {

	protected $filesystem;

	protected $paths;

	protected $templates;

	public function __construct(FilesystemContract $filesystem, array $paths)
	{
		$this->filesystem = $filesystem;
		$this->paths      = array_map('trailingslashit', $paths);
	}

	public function find($key)
	{
		if (isset($this->templates[$key]))
		{
			return $this->templates[$key];
		}

		return $this->templates[$key] = $this->findInPaths($key, $this->paths);
	}

	protected function findInPaths($key, $paths)
	{
		$found = false;

		foreach ((array) $paths as $path)
		{
			if ($this->filesystem->isFile($template = $path.$key.'.php'))
			{
				$found = $template;
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