<?php

namespace Fire\Model\Category;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Category\CategoryRepository as CategoryRepositoryContract;
use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;

class CategoryEntityMapper implements EntityMapperContract
{
    /**
     * @var Fire\Contracts\Model\Category\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var Fire\Contracts\Model\Post\PostRepository
     */
    protected $postRepository;

    /**
     * @param Fire\Contracts\Model\Category\CategoryRepository  $categoryRepository
     * @param Fire\Contracts\Model\Post\PostRepository          $postRepository
     */
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

        $id = $data['parent'];

        $entity->setParentId($id);

        $entity->setParent(function () use ($id) {
            $parent = null;

            if ($id) {
                $parent = $this->categoryRepository->categoryOfId($id);
            }

            return $parent;
        });
    }
}
