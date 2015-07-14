<?php

namespace Fire\Model;

abstract class Entity {

	protected function lazyLoad(& $property)
	{
		if (is_callable($property))
		{
			return $property = $property();
		}

		return $property;
	}

}