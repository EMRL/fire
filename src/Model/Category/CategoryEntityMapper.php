<?php

namespace Fire\Model\Category;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Category\CategoryRepository as CategoryRepositoryContract;
use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;

class CategoryEntityMapper implements EntityMapperContract
{
    protected $categoryRepository;

    protected $postRepository;

    public function __construct(
        CategoryRepositoryContract $categoryRepository,
        PostRepositoryContract $postRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository     = $postRepository;
    }

    public function map(EntityContract $entity, array $data)
    {
        $entity->setPosts(function () use ($data) {
            return $this->postRepository->postsInCategory($data['term_id']);
        });

        $entity->setParent(function () use ($data) {
            $parent = null;

            if ($data['parent']) {
                $parent = $this->categoryRepository->categoryOfId($data['parent']);
            }

            return $parent;
        });
    }
}
