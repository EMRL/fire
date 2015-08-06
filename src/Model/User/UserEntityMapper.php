<?php

namespace Fire\Model\User;

use Fire\Model\EntityMapper;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

class UserEntityMapper extends EntityMapper {

	public function map(
	  array $data,
	  EntityContract $entity,
	  RepositoryContract $userRepository
	)
	{
		$entity->init((object) $data);

		return $entity;
	}

}