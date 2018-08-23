<?php

namespace Fire\Model;

use Closure;
use Fire\Contracts\Model\Entity as EntityContract;

abstract class Entity implements EntityContract
{
    /**
     * Resolve a value from a Closure
     *
     * @param mixed $property
     * @return mixed
     */
    protected function lazyLoad(& $property)
    {
        if ($property instanceof Closure) {
            return $property = $property();
        }

        return $property;
    }
}
