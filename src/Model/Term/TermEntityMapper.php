<?php

namespace Fire\Model\Term;

use Fire\Model\EntityMapper;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

abstract class TermEntityMapper extends EntityMapper {

	public function map(
	  array $data,
	  EntityContract $entity,
	  RepositoryContract $repository
	)
	{
		$entity->setId($data['term_id']);
		$entity->setName($data['name']);
		$entity->setSlug($data['slug']);
		$entity->setDescription($data['description']);

		// Relationships
		$entity->setTaxonomy(get_taxonomy($data['taxonomy']));

		$entity->setParent(function() use ($data)
		{
			$parent = null;

			if ($data['parent'])
			{
				$parent = $this->container['repository.'.$data['taxonomy']]->termOfId($data['parent']);
			}
			
			return $parent;
		});

		$entity->setNative($data);

		return $entity;
	}

}