<?php 

namespace Fire\Model;

use Fire\Contracts\Model\RepositoryFactory as RepositoryFactoryContract;
use Fire\Contracts\Model\EntityManager as EntityManagerContract;

class RepositoryFactory implements RepositoryFactoryContract {

	protected $repositories = [];

	protected $instances = [];

	public function registerRepository($entityName, $class)
	{
		$this->repositories[$entityName] = $class;

		return $this;
	}

	public function getRepository(EntityManagerContract $entityManager, $entityName)
	{
		$hash = $entityName.spl_object_hash($entityManager);

		if (isset($this->instances[$hash]))
			return $this->instances[$hash];

		return $this->instances[$hash] = $this->repositories[$entityName];
	}

}