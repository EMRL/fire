<?php

namespace Fire\Model;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Container\Container as ContainerContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

abstract class EntityMapper implements EntityMapperContract {

	abstract public function map(array $data, EntityContract $entity, RepositoryContract $repository);

}