<?php

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;

class PostEntityMapperMock implements EntityMapperContract {

	protected $postRepository;

	public function __construct(PostRepositoryContract $postRepository)
	{
		$this->postRepository = $postRepository;
	}

	public function map(EntityContract $entity, array $data)
	{
		$entity->setId($data['ID']);
		$entity->setSlug($data['post_name']);

		$id = $data['post_parent'];
		
		$entity->setParent(function() use ($id)
		{
			$parent = null;

			if ($id)
			{
				$parent = $this->postRepository->postOfId($id);
			}

			return $parent;
		});
	}

}