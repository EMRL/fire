<?php 

namespace Fire\Model;

class RepositoryFactory implements RepositoryFactoryInterface {

	protected $repositories = [];

	protected $instances = [];

	public function registerRepository($entityName, $className)
	{
		$this->repositories[$entityName] = $className;

		return $this;
	}

	public function getRepository(EntityManagerInterface $entityManager, $entityName)
	{
		$hash = $entityName.spl_object_hash($entityManager);

		if (isset($this->instances[$hash]))
			return $this->instances[$hash];

		return $this->instances[$hash] = $this->createRepository($entityManager, $entityName);
	}

	protected function createRepository(EntityManagerInterface $entityManager, $entityName)
	{
		$class = $this->repositories[$entityName];

		return new $class($entityManager);
	}

}