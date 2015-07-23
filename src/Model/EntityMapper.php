<?php

namespace Fire\Model;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\EntityManager as EntityManagerContract;
use Fire\Contracts\Model\Entity as EntityContract;

abstract class EntityMapper implements EntityMapperContract {

	/**
	 * @var  Fire\Contracts\Model\EntityManager
	 */
	protected $em;

	public function __construct(EntityManagerContract $em)
	{
		$this->em = $em;
	}

	abstract public function map(array $data, EntityContract $entity);

}