<?php

namespace Fire\Model\Page;

use Fire\Model\AbstractPost\AbstractPostEntityMapper;
use Fire\Contracts\Model\User\UserRepository as UserRepositoryContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

class PageEntityMapper extends PostEntityMapper {

	public function map(
	  array $data,
	  EntityContract $entity,
	  RepositoryContract $pageRepository
	)
	{
		$entity = parent::map($data, $entity, $pageRepository);

		$id = $data['post_parent'];

		$entity->setParent(function() use ($id, $pageRepository)
		{
			return $pageRepository->pageOfId($id);
		});

		return $entity;
	}

}