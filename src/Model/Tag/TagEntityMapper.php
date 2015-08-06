<?php

namespace Fire\Model\Tag;

use Fire\Model\Term\TermEntityMapper;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

class TagEntityMapper extends TermEntityMapper {

	protected $postRepository;

	public function __construct(PostRepositoryContract $postRepository)
	{
		$this->postRepository = $postRepository;
	}

	public function map(
	  array $data,
	  EntityContract $entity,
	  RepositoryContract $tagRepository
	)
	{
		$entity = parent::map($data, $entity, $tagRepository);

		$entity->setPosts(function() use ($data)
		{
			return $this->postRepository->postsTagged($data['term_id']);
		});

		return $entity;
	}

}