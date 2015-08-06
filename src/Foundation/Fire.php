<?php

namespace Fire\Foundation;

use Fire\Container\Container;

class Fire extends Container {

	public function __construct()
	{
		$this->registerBaseBindings();
		$this->loadBaseFiles();
	}

	protected function registerBaseBindings()
	{
		static::setInstance($this);

		$this->instance('fire', $this);
		$this->instance('Fire\Container\Container', $this);

		$this->instance('path.fire', FIRE_PATH);
		$this->instance('url.fire',  FIRE_URL);
		$this->instance('path.parent', trailingslashit(get_template_directory()));
		$this->instance('url.parent', trailingslashit(get_template_directory_uri()));
		$this->instance('path.theme', trailingslashit(get_stylesheet_directory()));
		$this->instance('url.theme', trailingslashit(get_stylesheet_directory_uri()));
	}

	protected function loadBaseFiles()
	{
		$files = [
			'src/Model/services.php',
		];

		foreach ($files as $file)
		{
			include $this['path.fire'].$file;
		}
	}

	public function registerServices()
	{
		do_action('fire/services', $this);
	}

	public function ignite()
	{
		do_action('fire/ignite', $this);
	}

}