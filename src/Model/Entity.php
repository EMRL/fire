<?php

namespace Fire\Model;

use Closure;
use Fire\Contracts\Model\Entity as EntityContract;

abstract class Entity implements EntityContract {

	protected function lazyLoad(& $property)
	{
		if ($property instanceof Closure)
		{
			return $property = $property();
		}

		return $property;
	}

}