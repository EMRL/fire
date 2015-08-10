<?php

namespace Fire\Model\User;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

class UserEntityMapper implements EntityMapperContract {

	public function map(EntityContract $entity, array $data)
	{
		$entity->init((object) $data);

		return $entity;
	}

}