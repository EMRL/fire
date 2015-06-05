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

	abstract protected function hydrate(array $data);

	protected function parseDocComment($comment)
	{
		$doc = [];

		if (preg_match_all('/@(\w+)(?:[ ]+(.*))?/', $comment, $matches))
		{
			$doc = array_combine(
				array_map('trim', $matches[1]),
				array_map('trim', $matches[2])
			);
		}

		return $doc;
	}

}