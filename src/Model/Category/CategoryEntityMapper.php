<?php

namespace Fire\Model\Category;

use Fire\Model\Term\TermEntityMapper;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

class CategoryEntityMapper extends TermEntityMapper {

	protected $postRepository;

	public function __construct(PostRepositoryContract $postRepository)
	{
		$this->postRepository = $postRepository;
	}

	public function map(
	  array $data,
	  EntityContract $entity,
	  RepositoryContract $categoryRepository
	)
	{
		$entity = parent::map($data, $entity, $categoryRepository);

		$entity->setPosts(function() use ($data)
		{
			return $this->postRepository->postsInCategory($data['term_id']);
		});

		return $entity;
	}

}