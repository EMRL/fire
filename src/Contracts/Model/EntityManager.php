<?php

namespace Fire\Contracts\Model;

interface EntityManager {

	public function getRepository($entityName);

}