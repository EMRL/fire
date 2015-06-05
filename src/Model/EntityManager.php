<?php

namespace Fire\Model;

use ReflectionClass;

class EntityManager implements EntityManagerInterface {

	protected $repositoryFactory;

	public function __construct(RepositoryFactoryInterface $repositoryFactory)
	{
		$this->repositoryFactory = $repositoryFactory;
	}

	public function getRepository($entityName)
	{
		return $this->repositoryFactory->getRepository($this, $entityName);
	}

	public function getReflection($entityName)
	{
		$class = $this->getRepository($entityName)->entityClass;

		return new ReflectionClass($class);
	}

	public function getEntityFromReflection(ReflectionClass $reflection)
	{
		return $reflection->newInstanceWithoutConstructor();
	}

}