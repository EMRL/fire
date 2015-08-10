<?php

namespace Fire\Contracts\Model;

use Fire\Contracts\Model\Entity as EntityContract;

interface EntityMapper {

	public function map(EntityContract $entity, array $data);

}