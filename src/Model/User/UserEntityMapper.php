<?php

namespace Fire\Model\User;

use Fire\Model\EntityMapper;
use Fire\Contracts\Model\Entity as EntityContract;

class UserEntityMapper extends EntityMapper {

	public function map(array $data, EntityContract $entity)
	{
		$entity->init((object) $data);

		return $entity;
	}

}