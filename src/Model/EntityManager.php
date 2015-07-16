<?php

namespace Fire\Model;

use Fire\Contracts\Model\EntityManager as EntityManagerContract;
use Fire\Contracts\Model\RepositoryFactory as RepositoryFactoryContract;

class EntityManager implements EntityManagerContract {

	protected $repositoryFactory;

	public function __construct(RepositoryFactoryContract $repositoryFactory)
	{
		$this->repositoryFactory = $repositoryFactory;
	}

	public function getRepository($entityName)
	{
		return $this->repositoryFactory->getRepository($this, $entityName);
	}

}