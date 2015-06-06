<?php

namespace Fire\Model;

interface EntityManagerInterface {

	public function getRepository($entityName);

	public function getMetaData($docBlock);

}