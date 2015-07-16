<?php

namespace Fire\Model;

use Fire\Contracts\Model\Entity as EntityContract;

abstract class Entity implements EntityContract {

	protected function lazyLoad(& $property)
	{
		if (is_callable($property))
		{
			return $property = $property();
		}

		return $property;
	}

}