<?php

namespace Fire\Foundation;

use Fire\Contracts\Foundation\Arrayable;

class Params implements Arrayable {

	protected $params = [];

	public function add($params, $value = null)
	{
		if ( ! is_array($params))
		{
			$params = array($params => $value);
		}

		$this->params = array_replace_recursive($this->params, $params);

		return $this;
	}

	public function merge($params, $value = null)
	{
		if ( ! is_array($params))
		{
			$params = array($params => $value);
		}
		
		$this->params = array_merge_recursive($this->params, $params);

		return $this;
	}

	public function reset()
	{
		$this->params = $this->defaultParams();

		return $this;
	}

	public function toArray()
	{
		return array_replace_recursive($this->defaultParams(), $this->params);
	}

	protected function defaultParams()
	{
		return [];
	}

}