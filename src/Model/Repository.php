<?php

namespace Fire\Model;

use ReflectionClass;

abstract class Repository {

	/**
	 * @var  string
	 */
	public $entityClass;

	/**
	 * @var  Fire\Model\EntityManager
	 */
	protected $em;

	/**
	 * @param   $em  Fire\Model\EntityManager
	 * @return  void
	 */
	public function __construct($em)
	{
		$this->em = $em;
	}

}