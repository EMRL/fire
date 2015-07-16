<?php

namespace Fire\Contracts\Model;

use Fire\Contracts\Model\Entity;

interface EntityMapper {

	public function map(array $data, Entity $entity);

}