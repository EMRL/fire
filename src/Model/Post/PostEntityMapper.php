<?php

namespace Fire\Model\Post;

use Fire\Foundation\Collection;
use Fire\Model\AbstractPost\AbstractPostEntityMapper;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\User\UserRepository as UserRepositoryContract;
use Fire\Contracts\Model\Category\CategoryRepository as CategoryRepositoryContract;
use Fire\Contracts\Model\Tag\TagRepository as TagRepositoryContract;
use Fire\Contracts\Model\Repository as RepositoryContract;

class PostEntityMapper extends AbstractPostEntityMapper {

	protected $categoryRepository;

	protected $tagRepository;

	public function __construct(
		UserRepositoryContract $userRepository,
		CategoryRepositoryContract $categoryRepository,
		TagRepositoryContract $tagRepository
	)
	{
		parent::__construct($userRepository);

		$this->categoryRepository = $categoryRepository;
		$this->tagRepository      = $tagRepository;
	}

	public function map(
	  array $data,
	  EntityContract $entity,
	  RepositoryContract $postRepository
	)
	{
		$entity = parent::map($data, $entity, $postRepository);

		$id = $data['post_parent'];

		$entity->setParent(function() use ($id, $postRepository)
		{
			return $postRepository->postOfId($id);
		});

		$entity->setCategories(function() use ($data)
		{
			$categories = new Collection;

			foreach (wp_get_post_categories($data['ID']) as $id)
			{
				$categories->push($this->categoryRepository->categoryOfId($id));
			}

			return $categories;
		});

		$entity->setTags(function() use ($data)
		{
			$tags = new Collection;

			foreach (wp_get_post_tags($data['ID']) as $id)
			{
				$tags->push($this->tagRepository->tagOfId($id));
			}

			return $tags;
		});

		return $entity;
	}

}