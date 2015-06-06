<?php

namespace Fire\Model;

use ReflectionClass;
use Fire\Foundation\MetaDataParserInterface;

class EntityManager implements EntityManagerInterface {

	protected $repositoryFactory;

	protected $metaDataParser;

	public function __construct(
		RepositoryFactoryInterface $repositoryFactory,
		MetaDataParserInterface $metaDataParser)
	{
		$this->repositoryFactory = $repositoryFactory;
		$this->metaDataParser    = $metaDataParser;
	}

	public function getRepository($entityName)
	{
		return $this->repositoryFactory->getRepository($this, $entityName);
	}

	public function getEntityReflection($entityName)
	{
		return new ReflectionClass($this->getRepository($entityName)->entityClass);
	}

	public function getEntityFromReflection(ReflectionClass $reflection)
	{
		return $reflection->newInstanceWithoutConstructor();
	}

	public function getMetaData($docBlock)
	{
		return $this->metaDataParser->parse($docBlock);
	}

}