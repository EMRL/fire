<?php

namespace Fire\Contracts\Model;

interface RepositoryFactory {

	public function registerRepository($entityName, $className);

	public function getRepository(EntityManager $entityManager, $entityName);

}