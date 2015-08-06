<?php

namespace Fire\Model;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

abstract class Repository implements RepositoryContract {

	/**
	 * @var  string
	 */
	protected $entityClass;

	/**
	 * @var  Fire\Contracts\Model\EntityMapper
	 */
	protected $entityMapper;

	/**
	 * @param   $entityMapper  Fire\Contracts\Model\EntityMapper
	 * @return  void
	 */
	public function __construct(EntityMapperContract $entityMapper)
	{
		$this->entityMapper = $entityMapper;
	}

	protected function mapData(array $data)
	{
		return $this->entityMapper->map($data, $this->createEntityClass(), $this);
	}

	protected function createEntityClass()
	{
		return new $this->entityClass;
	}

}