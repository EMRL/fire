<?php

namespace Fire\Model\Tag;

use Fire\Contracts\Model\EntityMapper as EntityMapperContract;
use Fire\Contracts\Model\Entity as EntityContract;
use Fire\Contracts\Model\Tag\TagRepository as TagRepositoryContract;
use Fire\Contracts\Model\Post\PostRepository as PostRepositoryContract;

class TagEntityMapper implements EntityMapperContract
{
    protected $tagRepository;

    protected $postRepository;

    public function __construct(
        TagRepositoryContract $tagRepository,
        PostRepositoryContract $postRepository
    ) {
        $this->tagRepository  = $tagRepository;
        $this->postRepository = $postRepository;
    }

    public function map(EntityContract $entity, array $data)
    {
        $entity->setPosts(function () use ($data) {
            return $this->postRepository->postsTagged($data['term_id']);
        });

        $entity->setParent(function () use ($data) {
            $parent = null;

            if ($data['parent']) {
                $parent = $this->tagRepository->tagOfId($data['parent']);
            }

            return $parent;
        });
    }
}
