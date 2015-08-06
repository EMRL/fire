<?php

namespace Fire\Contracts\Model;

use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

interface EntityMapper {

	public function map(
	  array $data,
	  EntityContract $entity,
	  RepositoryContract $repository
	);

}