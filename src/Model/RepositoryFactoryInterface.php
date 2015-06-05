<?php

namespace Fire\Model;

interface RepositoryFactoryInterface {

	public function registerRepository($entityName, $className);

	public function getRepository(EntityManagerInterface $entityManager, $entityName);

}