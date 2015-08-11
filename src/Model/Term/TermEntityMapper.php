<?php

namespace Fire\Model\Term;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

class TermEntityMapper implements EntityMapperContract {

	public function map(EntityContract $entity, array $data)
	{
		$entity->setId($data['term_id']);
		$entity->setName($data['name']);
		$entity->setSlug($data['slug']);
		$entity->setDescription($data['description']);

		// Relationships
		$entity->setTaxonomy(get_taxonomy($data['taxonomy']));

		$entity->setNative($data);
	}

}