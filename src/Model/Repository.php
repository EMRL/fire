<?php

namespace Fire\Model;

use Fire\Contracts\Model\EntityMapper;

abstract class Repository {

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
	public function __construct(EntityMapper $entityMapper)
	{
		$this->entityMapper = $entityMapper;
	}

	protected function mapData(array $data)
	{
		return $this->entityMapper->map($data, $this->createEntityClass());
	}

	protected function createEntityClass()
	{
		return new $this->entityClass;
	}

}