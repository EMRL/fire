<?php

namespace Fire\Foundation;

class MetaData {

	protected $data = [];

	public function __construct(array $data)
	{
		$this->data = $data;
	}

	public function get($key, $default = null)
	{
		$value = $default;

		if (array_key_exists($key, $this->data))
		{
			$value = $this->data[$key];
		}

		return $value;
	}

	public function __get($key)
	{
		return $this->get($key);
	}

	public function __call($key, $args)
	{
		$default = null;

		if (isset($args[0]))
		{
			$default = $args[0];
		}

		return $this->get($key, $default);
	}

}