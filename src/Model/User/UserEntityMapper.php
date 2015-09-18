<?php

namespace Fire\Model\User;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;

class UserEntityMapper implements EntityMapperContract
{
    public function map(EntityContract $entity, array $data)
    {
        $entity->init((object) $data);
    }
}
