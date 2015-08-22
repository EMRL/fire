<?php

namespace Fire\Contracts\Model;

use Fire\Contracts\Model\Entity as EntityContract;

interface EntityMapper
{
    /**
     * Map a data array into the entity object
     *
     * Entity object is passed, so there is no need to return anything from
     * this method. Simply modify the object itself.
     *
     * @param  Fire\Contracts\Model\Entity  $entity
     * @param  array                        $data
     */
    public function map(EntityContract $entity, array $data);
}
